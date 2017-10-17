<?php
require_once 'CertCenter.inc.php';
use CertCenter\RESTful as ccAPI;

$api = new ccAPI();
$api->setAuthorization('#your-token#');

$request = Array(
	"FromDate"=>"2015-11-19T00:00:00Z",
	"ToDate"=>"2015-11-21T00:00:00Z",
	"includeFulfillment"=> false,
	"includeOrderParameters"=> false,
	"includeBillingDetails"=> false,
	"includeContacts"=> false,
	"includeOrganizationInfos"=> false
);

print_r( $api->ModifiedOrders($request) );


?>
