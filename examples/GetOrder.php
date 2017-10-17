<?php
require_once 'CertCenter.inc.php';
use CertCenter\RESTful as ccAPI;

$api = new ccAPI();
$api->setAuthorization('#your-token#');

$request = Array(
	"CertCenterOrderID"=> 1234567890,
	"includeFulfillment"=> true,
	"includeOrderParameters"=> true,
	"includeBillingDetails"=> true,
	"includeContacts"=> true,
	"includeOrganizationInfos"=> true
);
print_r( $api->GetOrder($request) );


?>
