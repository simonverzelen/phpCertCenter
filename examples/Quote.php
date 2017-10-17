<?php
require_once 'CertCenter.inc.php';
use CertCenter\RESTful as ccAPI;

$api = new ccAPI();
$api->setAuthorization('#your-token#');

$request = Array(
	"ProductCode"=>"GlobalSign.ExtendedSSL",
	"SubjectAltNameCount"=>2,
	"ValidityPeriod"=>12,
	"ServerCount"=>1
);

print_r( $api->Quote($request) );

?>
