<?php
require_once 'CertCenter.inc.php';
use CertCenter\RESTful as ccAPI;
$api = new ccAPI();



$request = Array(
	"CertCenterOrderID"=> 1234567890,
	"OrderParameters"=> Array(
		"SignatureHashAlgorithm"=> "SHA256-FULL-CHAIN",
		"DVAuthMethod"=> "EMAIL",
		"CSR"=> "-----BEGIN CERTIFICATE REQUEST-----
MIIBVTCB/QIBADCBmjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNPMRkwFwYDVQQH
ExBDb2xvcmFkbyBTcHJpbmdzMRkwFwYDVQQKExBTdXBlciBNYWxsLCBJbmMuMR8w
HQYDVQQDExZ3d3cuc3VwZXItbWFsbC1pbmMuY29tMScwJQYJKoZIhvcNAQkBFhhh
ZG1pbkBzdXBlci1tYWxsLWluYy5jb20wWTATBgcqhkjOPQIBBggqhkjOPQMBBwNC
AAT4E1K5QOPD55LbB7x8ydEJhVa69SpScj5at6R1f8HdBckhuXvxJX+XvaLQvA0d
M6aZFEfcPlzoLgmTbtcnUEWloAAwCQYHKoZIzj0EAQNIADBFAiAB0XTEhsle2SNb
A2462JcRYBSAWf4gSRUHpCxCRHm6OQIhAK6rn6B40kh4EdAvuL9BaCQjeU0HHIG9
lj1JDQDKSbBZ
-----END CERTIFICATE REQUEST-----"
	)
);

print_r( $api->Reissue($request) );


?>
