<?php namespace CertCenter {

	define("CC_CRLF","\r\n");
	class RESTful {


		/** PLEASE INSERT YOUR OWN OAUTH2 BEARER TOKEN **/
		private $__authorization = Array('Bearer'=> 'XYZXYZXYZ.oauth2.certcenter.com');


		private $__ob = 'object';
		private $__API_URL = 'https://api.certcenter.com/rest/v1';
		private $__MethodInfo = Array(
			'Limit'=>Array('http_method'=>'GET'),
			'Products'=>Array('http_method'=>'GET'),
			'ProductDetails'=>Array('http_method'=>'GET'),
			'Profile'=>Array('http_method'=>'GET'),
			'Quote'=>Array('http_method'=>'GET'),
			'ValidateCSR'=>Array('http_method'=>'POST'),
			'TestOrder'=>Array('http_method'=>'POST'),
			'AddUser'=>Array('http_method'=>'POST'),
			'GetUser'=>Array('http_method'=>'GET','path_parameter'=>'UserNameOrUserId'),
			'UpdateUser'=>Array('http_method'=>'POST','path_parameter'=>'UserNameOrUserId'),
			'DeleteUser'=>Array('http_method'=>'DELETE','path_parameter'=>'UserNameOrUserId'),
			'GetCustomers'=>Array('http_method'=>'GET'),
			'GetCustomer'=>Array('http_method'=>'GET','path_parameter'=>'UserNameOrUserId'),
			'VulnerabiltyAssessment'=>Array('http_method'=>'POST'),
			'VulnerabiltyAssessmentRescan'=>Array('http_method'=>'GET', 'path_parameter'=>'CertCenterOrderID'),
			'Order'=>Array('http_method'=>'POST'),
			'CancelOrder'=>Array('http_method'=>'DELETE','path_parameter'=>'CertCenterOrderID'),
			'Revoke'=>Array('http_method'=>'DELETE','path_parameter'=>'CertCenterOrderID'),
			'UserAgreement'=>Array('http_method'=>'GET'),
			'ApproverList'=>Array('http_method'=>'GET'),
			'Orders'=>Array('http_method'=>'GET'),
			'ModifiedOrders'=>Array('http_method'=>'GET'),
			'GetOrder'=>Array('http_method'=>'GET','path_parameter'=>'CertCenterOrderID'),
			'Reissue'=>Array('http_method'=>'POST'),
			'UpdateApproverEmail'=>	Array('http_method'=>'PUT','path_parameter'=>'CertCenterOrderID','query_parameter'=>'ApproverEmail'),
			'ResendApproverEmail'=>	Array('http_method'=>'POST','path_parameter'=>'CertCenterOrderID'),
			'DNSData'=>Array('http_method'=>'POST'),
			'FileData'=>Array('http_method'=>'POST'),
			'ValidateName'=>Array('http_method'=>'POST')
		);


		public function __construct($OutputBehavior='object') {
			$this->__ob = $OutputBehavior;
		}

		public function __call($method,$kwargs) {
			if(!array_key_exists($method,$this->__MethodInfo)) {
				#echo "Methode $method nicht gefunden!\n";
				return false;
			}
			return $this->__generic($method,$kwargs,$this->__MethodInfo[$method]);
		}

		private function str2array($str) {
			$ret=Array();
			foreach(explode(CC_CRLF,$str) as $l) {
				$x=explode(": ",$l);
				if(count($x)>1) $ret[trim($x[0])]=trim($x[1]);
			}
			return $ret;
		}

		private function is_hex($hex_code) {
			return preg_match("/^[a-f0-9]{2,}$/i", $hex_code) && !(strlen($hex_code) & 1);
		}

		private function http_chunked_decode($chunk) {
			$pos = 0;
			$len = strlen($chunk);
			$dechunk = null;
			while(($pos < $len) && ($chunkLenHex = substr($chunk,$pos, ($newlineAt = strpos($chunk,"\n",$pos+1))-$pos))) {
				if (!$this->is_hex($chunkLenHex))
					return $chunk;
				$pos = $newlineAt + 1;
				$chunkLen = hexdec(rtrim($chunkLenHex,"\r\n"));
				$dechunk .= substr($chunk, $pos, $chunkLen);
				$pos = strpos($chunk, "\n", $pos + $chunkLen) + 1;
			}
			return $dechunk;
		}

		private function __generic($method="Limit", $kw, $info) {
			$http_method = $info['http_method'];
			$data = isset($kw[0])?$kw["0"]:Array();
			$_method = $method;

			if(	preg_match("/^(Get|Add)/i",$_method)) {
				$_method = substr($_method,3,strlen($_method));
			}
			elseif(	preg_match("/^(Update|Delete|Resend|Cancel)/i",$_method))
				$_method = substr($_method,6,strlen($_method));

			if( array_key_exists("path_parameter",$info) ) {
				if( array_key_exists($info["path_parameter"],$data) ) {
					$_method .= "/".$data[$info["path_parameter"]];
					unset($data[$info["path_parameter"]]);
				}
			}

			if($http_method=="GET"||array_key_exists("query_parameter",$info)) {
				if( array_key_exists("query_parameter",$info) ) {
					$query_parameter = $info["query_parameter"];
					$_data = Array();
					switch(gettype($query_parameter)) {
						case "string": $_data = Array($query_parameter=>$data[$query_parameter]); break;
						case "array": foreach($query_parameter as $item) array_push($_data, $item); break;
					}
				} else $_data = $data;
				$q = http_build_query($query_data=$_data, $enc_type=PHP_QUERY_RFC3986);
				if(!empty($q)) $_method = $_method."?".$q;
			}

			$url = parse_url($this->__API_URL."/".$_method);
			$fp = @fsockopen("ssl://".$url["host"],443,$errno,$errstr,300);
			if(!$fp) return false;

			fputs($fp, $http_method." ".$url["path"].(array_key_exists('query',$url) ? ("?".$url["query"]) : "")." HTTP/1.1".CC_CRLF);
			fputs($fp, "Host: ".$url["host"].CC_CRLF);
			if(array_key_exists("Bearer",$this->__authorization))
				fputs($fp, "Authorization: Bearer ".$this->__authorization["Bearer"].CC_CRLF);
			if(sizeof($data)>0)
				fputs($fp, "Content-type: application/json; charset=utf8".CC_CRLF);
			$sz=0;
			if(sizeof($data)>0) {
				$data = json_encode($data);
				$sz = strlen($data);
				fputs($fp, "Content-Length: $sz".CC_CRLF);
			}
			fputs($fp, "Connection: close".CC_CRLF.CC_CRLF);
			if($sz>0) fputs($fp, $data);

			$headers = $content = $buf = "";
			while(!@feof($fp)) $buf .= @fgets($fp, 64);
			@fclose($fp);

			if($buf!="") {
				$buf = explode(CC_CRLF.CC_CRLF,$buf);
				$headers = isset($buf[0]) ? $this->str2array($buf[0]) : "";
				$content = isset($buf[1]) ? trim($buf[1]) : "";
				$content_type = array_key_exists("Content-Type", $headers) ? $headers["Content-Type"] : "text/plain";
				if(array_key_exists('Transfer-Encoding',$headers) && $headers['Transfer-Encoding']=='chunked')
					$content = $this->http_chunked_decode($content);
				if($this->__ob=='object')
					try { $content = json_decode($content); } catch (Exception $e) { }
			}
			return $content;
		}
	}
}

?>
