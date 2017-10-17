<?php

require_once 'CertCenter.inc.php';
use CertCenter\RESTful as ccAPI;

$api = new ccAPI();
$api->setAuthorization('#your-token#');

$CommonName = "www.example.com";

// 1. Check the blacklist
//
$resValidateName = $api->ValidateName(Array(
  "CommonName" => $CommonName,
  "GeneratePrivateKey" => true
));

if(!$resValidateName->IsQualified) {
  die("CommonName is not qualified (blacklisted)");
}

echo "Your PrivateKey (save it):\n";
echo $resValidateName->PrivateKey;

// 2. Fetch file name and hash
//
$resFileData = $api->FileData(Array(
  "ProductCode" => "AlwaysOnSSL.AlwaysOnSSL",
  "CSR" => $resValidateName->CSR
));

// 3. Save the hash (requires curl modules to be installed)
//
$KvStoreAuthorizationKey = "r0Ce8WaE9naJSWMNjzbrC7TGoWuR2o1y9h93RI2N";
$curl = curl_init("https://fauth-db.eu.certcenter.com/".$CommonName);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, Array(
  "x-api-key: ".$KvStoreAuthorizationKey,
  "Content-type: application/json"
));
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(Array(
  "hash"=> $resFileData->FileAuthDetails->FileContent
)));
$r = json_decode(curl_exec($curl));
if($r->message!='success') {
  die("Couldn't write hash to key-value storage");
}

// 4. Submit the order
//
$resOrder = $api->Order(Array(
  'OrderParameters' => Array(
    "ProductCode" => "AlwaysOnSSL.AlwaysOnSSL",
    "CSR" => $resValidateName->CSR,
    "ValidityPeriod" => 180,
    "DVAuthMethod" => "FILE"
  )
));

echo "Certificate fulfillment:\n\n";
print_r($resOrder);
?>
