<?php
require_once 'CertCenter.inc.php';
use CertCenter\RESTful as ccAPI;

$api = new ccAPI();
$api->setAuthorization('#your-token#');


$request = Array(
	"ProductCode"=>"GeoTrust.QuickSSLPremium"
);

print_r( $api->UserAgreement($request) );

?>
