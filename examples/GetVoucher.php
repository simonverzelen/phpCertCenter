<?php
require_once 'CertCenter.inc.php';
use CertCenter\RESTful as ccAPI;
$api = new ccAPI();

print_r( $api->GetVoucher("JDX1UBDC6AA1") );
?>
