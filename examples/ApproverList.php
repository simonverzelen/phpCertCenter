<?php
require_once 'CertCenter.inc.php';
use CertCenter\RESTful as ccAPI;

$api = new ccAPI();
$api->setAuthorization('#your-token#');

$request = Array(
	"CommonName"=> "www.certcenter.com",
	"ProductCode"=> "GeoTrust.QuickSSL"
);

print_r( $api->ApproverList($request) );

?>
