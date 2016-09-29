<?php
require_once 'CertCenter.inc.php';
use CertCenter\RESTful as ccAPI;
$api = new ccAPI();



$request = Array(
  "OrganizationInfo"=>Array(
	"OrganizationName"=>"Super Mall, Inc.",
	"OrganizationAddress"=>Array(
		"AddressLine1"=>"5550 E Woodmen Rd",
		"PostalCode"=>"80920",
		"City"=>"Colorado Springs",
		"Region"=>"CO",
		"Country"=>"US",
		"Phone"=>"string",
		"Fax"=>"string",
		"Phone"=>"+1 719-111-111",
		"Fax"=>"+1 719-111-112"
	)
  ),
  "OrderParameters"=>Array(
    "ProductCode"=>"GlobalSign.OrganizationSSL",
    "IsCompetitiveUpgrade"=>false,
    "SubjectAltNames"=>Array(
      "www.super-mall-inc.net",
      "www.super-mall-inc.de"
    ),
    "PartnerOrderID"=>"WhatEverYouWant-ItsYourOrderIdentifier",
    "IsRenewal"=>false,
    "ServerCount"=>1,
    "SignatureHashAlgorithm"=>"SHA256-ECC-HYBRID",
    "CSR"=>"-----BEGIN CERTIFICATE REQUEST-----
MIIBVTCB/QIBADCBmjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNPMRkwFwYDVQQH
ExBDb2xvcmFkbyBTcHJpbmdzMRkwFwYDVQQKExBTdXBlciBNYWxsLCBJbmMuMR8w
HQYDVQQDExZ3d3cuc3VwZXItbWFsbC1pbmMuY29tMScwJQYJKoZIhvcNAQkBFhhh
ZG1pbkBzdXBlci1tYWxsLWluYy5jb20wWTATBgcqhkjOPQIBBggqhkjOPQMBBwNC
AAT4E1K5QOPD55LbB7x8ydEJhVa69SpScj5at6R1f8HdBckhuXvxJX+XvaLQvA0d
M6aZFEfcPlzoLgmTbtcnUEWloAAwCQYHKoZIzj0EAQNIADBFAiAB0XTEhsle2SNb
A2462JcRYBSAWf4gSRUHpCxCRHm6OQIhAK6rn6B40kh4EdAvuL9BaCQjeU0HHIG9
lj1JDQDKSbBZ
-----END CERTIFICATE REQUEST-----
",
    "Email"=>"domains@super-mall.com",
    "ValidityPeriod"=>12
  ),
  "AdminContact"=>Array(
    "Title"=>"CIO",
    "FirstName"=>"John",
    "LastName"=>"Doe",
    "OrganizationName"=>"Super Mall, Inc.",
    "OrganizationAddress"=>Array(
      "AddressLine1"=>"5550 E Woodmen Rd",
      "PostalCode"=>"80920",
      "City"=>"Colorado Springs",
      "Region"=>"CO",
      "Country"=>"US"
    ),
    "Phone"=>"+1 719-111-111",
    "Fax"=>"+1 719-111-112",
    "Email"=>"admin@super-mall.com"
  ),
);
$request['TechContact'] = $request['AdminContact'];

print_r( $api->TestOrder($request) );

?>
