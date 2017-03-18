<?php

require_once 'CertCenter.inc.php';
use CertCenter\RESTful as ccAPI;
$api = new ccAPI();

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

// 2. Fetch DNS information
//
$resDNSData = $api->DNSData(Array(
  "ProductCode" => "AlwaysOnSSL.AlwaysOnSSL",
  "CSR" => $resValidateName->CSR
));

// 3. Create DNS-entries in your zone
//
// Create a TXT-record with a very short TTL (e.g., 5 seconds)
// in your BIND, PowerDNS, Route53, or djbdns zone.
//
// {$resDNSData->DNSAuthDetails->DNSEntry} IN {$resDNSData->DNSAuthDetails->PointerType} 5 "{$resDNSData->DNSAuthDetails->DNSEntry}"
//
// Note: We also need an existing A pointer
//       for the CommonName to work correctly. 
//

// 4. Submit the order
//
$resOrder = $api->Order(Array(
  'OrderParameters' => Array(
    "ProductCode" => "AlwaysOnSSL.AlwaysOnSSL",
    "CSR" => $resValidateName->CSR,
    "ValidityPeriod" => 180,
    "DVAuthMethod" => "DNS"
  )
));

echo "Certificate fulfillment:\n\n";
print_r($resOrder);
?>