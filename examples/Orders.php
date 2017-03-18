<?php
require_once 'CertCenter.inc.php';
use CertCenter\RESTful as ccAPI;
$api = new ccAPI();



$request = Array(
	"Status"=> "COMPLETE",
	"ProductType"=> "SSL",
	"CommonName"=> "*.%",
	"Page"=> 1,
	"ItemsPerPage"=> 1000,
	"OrderBy"=> "ID",
	"OrderDir"=> "DESC",
	"includeFulfillment"=> false,
	"includeOrderParameters"=> false,
	"includeBillingDetails"=> false,
	"includeContacts"=> false,
	"includeOrganizationInfos"=> false
);
print_r( $api->Orders($request) );


?>
