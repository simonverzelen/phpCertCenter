<?php
require_once 'CertCenter.inc.php';
use CertCenter\RESTful as ccAPI;
$api = new ccAPI();



$request = Array(
	"CertCenterOrderID"=> 1234567890,
);

print_r( $api->CancelOrder($request) );

?>
