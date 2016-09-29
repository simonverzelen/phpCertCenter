<?php
require_once 'CertCenter.inc.php';
use CertCenter\RESTful as ccAPI;
$api = new ccAPI();


# First of all, check the common name against the CAs phishing blacklist.
$request = Array( "CommonName" => "dvtest.alwaysonssl.com" );
$DVAuthMethod = 'FILE'; # Possible values: DNS, FILE
$ValidateNameResult = $api->ValidateName($request);
if(!$ValidateNameResult->IsQualified) {
	echo "CommonName cannot be used for AlwaysOnSSL because it's blacklisted.";
	exit;
}

# Now let's get the information we need in order to provision
# the DNS zone with the proper CNAME record.
$CSR = "-----BEGIN CERTIFICATE REQUEST-----
MIIC1zCCAb8CAQAwaTEfMB0GA1UEAwwWZHZ0ZXN0LmFsd2F5c29uc3NsLmNvbTEL
MAkGA1UEBhMCREUxDzANBgNVBAgMBkhlc3NlbjEQMA4GA1UEBwwHR2llc3NlbjEW
MBQGA1UECgwNTm90IEF2YWlsYWJsZTCCASIwDQYJKoZIhvcNAQEBBQADggEPADCC
AQoCggEBALcmAP8FpqcJp2OXrDUp4AEY1VHQu9UtFOu2tPKZ6VvkTfRe2Jbk011V
aqn5ioDPhFcGB1ZfzEo8Umbn/F9Da6XoRdJv/gAr+0EWGkCRkLdtn8mr1DMZaBnF
b2YUxGIjj4BfBPMada9Wt8VuIjpSgafYHhLJohC7c2icuyf/bqfxtLJslpepu5iZ
QSdc5TqCsAWhjoXEcLoa/07v/VbLLpjmViOkrAd8h2nuRg2AoKydU+SYC2+EDImz
kxTcGIjb6GVl6QL/XVwdz602bjzyzFyZdexPKDfw8PaYuJkifxjbfzAKSxhAgd4k
PgJbY0fq0OV6LU1yAGkromTBu202eysCAwEAAaApMCcGCSqGSIb3DQEJDjEaMBgw
CwYDVR0PBAQDAgXgMAkGA1UdEwQCMAAwDQYJKoZIhvcNAQELBQADggEBAJO3dM4y
ngKsjylNJjCFopntboXZH/Jwu5Tjm6icwc4ULhd2F5Yzrq2RvZ9TAUCmp+WHQwwr
vETPgZB8/SXtQYn2DBY8DUETW7jF/AghkPcyNuOzbpmxI0uf6Bp6uju4hzovcbOq
m4rD+jl0JGfQCbnQyJ0oH1KxNhMYRzush72129hNshl1Z1KVV2nu/pQxULg9N5k6
GVCfacmDgOOCMpCI5nsif/wGR5NjTlEqQ4/MKkBzgNxpNACl09g8U9BEkcBFokk0
7XDEKxP9TmH2TkWYmZ8RWRBihijQmSvA7RoJbGdqryRXg9msV1AUTxHrTyxneV9/
Qfhjn38lALqDF60=
-----END CERTIFICATE REQUEST-----";

$request = Array(
	"ProductCode" => "AlwaysOnSSL.AlwaysOnSSL",
	"CSR" => $CSR,
);
if($DVAuthMethod=='DNS') {
	$DNSDataResult = $api->DNSData($request);
	print_r($DNSDataResult);
	/* Example Output:
	stdClass Object
	(
		[DNSAuthDetails] => stdClass Object
			(
				[PointerType] => CNAME
				[DNSEntry] => sadxoi5spfy8axlgu9lpcga55wncn6bo.dvtest.alwaysonssl.com.
				[DNSValue] => s20160322213337.dvtest.alwaysonssl.com.
			)
		[success] => 1
	)
	*/
} else {
	$FileDataResult = $api->FileData($request);
	print_r($FileDataResult);
	/* Example Output:
	stdClass Object
	(
		[FileAuthDetails] => stdClass Object
			(
				[FileContents] => 20160817082955250uyhevt9xaauim6pvk4yx5p50su4z2u8atievmbgk3r7gppp
				[FileName] => http://dvtest.alwaysonssl.com/.well-known/pki-validation/fileauth.htm
			)
		[success] => 1
	)
	*/
}

# The name is qualified, the dns zone has been updated with the
# proper DNS records. Now we can request the AlwaysOnSSL Certificate.
$request = Array(
	'OrderParameters' => Array(
		"ProductCode" => "AlwaysOnSSL.AlwaysOnSSL",
		"CSR" => $CSR,
		"ValidityPeriod" => 180,
		"DVAuthMethod" => $DVAuthMethod
	)
);

$OrderResult = $api->Order($request);
/* Example Output:
stdClass Object
(
    [Timestamp] => 2016-03-22T14:34:54Z
    [OrderParameters] => stdClass Object
        (
            [ProductCode] => AlwaysOnSSL.AlwaysOnSSL
            [DVAuthMethod] => FILE/DNS
            [PartnerOrderID] => APIR-QGBRJJRT946MSR24TRO587EN
            [SignatureHashAlgorithm] => SHA256-FULL-CHAIN
            [CSR] => #YourCSR#
            [ValidityPeriod] => 180
        )

    [CertCenterOrderID] => 6260509
    [success] => 1
    [Fulfillment] => stdClass Object
        (
            [Certificate_PKCS7] => #PKCS7#
            [Intermediate] => #AlwaysOnSSLIntermediate#
            [Certificate] => #ServerCertificate#
        )
)
*/
?>
