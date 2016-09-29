<?php
require_once 'CertCenter.inc.php';
use CertCenter\RESTful as ccAPI;
$api = new ccAPI();



$request = Array(
	"CertCenterOrderID"=> 1234567890,
	"RevokeReason"=> "Key compromised",
	"Certificate"=> "-----BEGIN CERTIFICATE-----
MIIF9DCCBNygAwIBAgISESFmIcxYP/Sni/D+JNTAGTn2MA0GCSqGSIb3DQEBCwUA
MGAxCzAJBgNVBAYTAkJFMRkwFwYDVQQKExBHbG9iYWxTaWduIG52LXNhMTYwNAYD
VQQDEy1HbG9iYWxTaWduIERvbWFpbiBWYWxpZGF0aW9uIENBIC0gU0hBMjU2IC0g
c3AyLmdsb2JhbHNpZ24uY29tL2dzZG9tYWludmFsc2hhMmcyMB0GA1UdDgQWBBS7
osGxxbQ36FP3rztgq3Qkw0s83zAfBgNVHSMEGDAWgBTqTnzUgC3lFYGGJoyCbcCY
pM+XDzANBgkqhkiG9w0BAQsFAAOCAQEAA45xDJ+N10maaDSG2dXMdnFemO7m1T3U
SAmx7M+vbQHggCwfI4LbQ8Sdv34fZEy+TFTjdP4gnGzuOdyqdzbUQ1eIU2g825qs
U9RiWWWYEFctSlCJz7uZCuv7IAQSpmRYeRJTxYgbB1r/wLRpe5YPOJKneMhVsXXb
uPsjgVLkb+qKIduTfHaXZGbLbOwJskBVpiQn/q3D5V5tTfiguWO3R3NiZCkp++I8
ua7e9NFy2gcnzCWKuzbjHhl/2lkkV+gSnLnLQQ4H8Gc++N1Wx7e/tD4MpMdVMsWa
1Mpgjeodu1toGRwerxyPB8LuabwFtT/0vPG/IhfOBM+7NlYYf7lriA==
-----END CERTIFICATE-----",
);


print_r( $api->Revoke($request) );


?>
