<?php
require_once 'CertCenter.inc.php';
use CertCenter\RESTful as ccAPI;
$api = new ccAPI();



$request = Array(
	"ProductCode"=>"GeoTrust.QuickSSLPremium"
);

print_r( $api->UserAgreement($request) );

?>
