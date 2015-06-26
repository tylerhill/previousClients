<?php
class AccessTokenAuthentication {
	function getTokens($grantType,$scopeUrl,$clientID,$clientSecret,$authUrl){
		try {
			$ch = curl_init();
			$paramArr = array (
				'grant_type'=>$grantType,
				'scope'=>$scopeUrl,
				'client_id'=>$clientID,
				'client_secret'=>$clientSecret
			);
			$paramArr = http_build_query($paramArr);
			curl_setopt($ch,CURLOPT_URL,$authUrl);
			curl_setopt($ch,CURLOPT_POST,TRUE);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$paramArr);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			$strResponse=curl_exec($ch);
			$curlErrno=curl_errno($ch);
			if($curlErrno){
				$curlError = curl_error($ch);
				throw new Exception($curlError);
			}
			curl_close($ch);
			$objResponse = json_decode($strResponse);
			if($objResponse->error){
				throw new Exception($objResponse->error_description);
			}
			return $objResponse->access_token;
		} catch (Exception $e) {
			echo "Exception-".$e->getMessage();
		}
	}
}
class HTTPTranslator {
	function curlRequest($url,$authHeader,$postData=''){
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_HTTPHEADER,array($authHeader,'Content-Type:text/xml'));
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		if($postData) {
			curl_setopt($ch,CURLOPT_POST,TRUE);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$postData);
		}
		$curlResponse = curl_exec($ch);
		$curlErrno = curl_errno($ch);
			if($curlErrno) {
				$curlError = curl_error($ch);
				throw new Exception($curlError);
			}
		curl_close($ch);
		return $curlResponse;
	}
	function createReqXML($languageCode) {
		$requestXML = "<ArrayOfstring xmlns='http://schemas.microsoft.com/2003/10/Serialization/Arrays' xmlns:i='http://www.w3.org/2001/XMLSchema-instance'>";
		if($languageCode) {
			$requestXML .= '<string>$languageCode</string>';
		} else {
			throw new Exception('Language Code is empty.');
		}
		$requestXML .='</ArrayOfstring>';
		return $requestXml;
	}
}
try {
	$clientID = 'tylerhillwebdev';
	$clientSecret = 'ThS5JNl2DSyVkMOAcvMs2431NMp4Cp4shGsoqYSkEW8=';
	$authUrl = 'https://datamarket.accesscontrol.windows.net/v2/OAuth2-13';
	$scopeUrl = 'http://api.microsofttranslator.com';
	$grantType = 'client_credentials';
	$authObj = new AccessTokenAuthentication();
	$accessToken = $authObj->getTokens($grantType,$scopeUrl,$clientID,$clientSecret,$authUrl);
//	$authHeader = "Authorization: Bearer ". $accessToken;
//	$translatorObj = new HTTPTranslator();
//	$inputStr = 'This is the sample string.';
//	$detectMethodUrl = 'http://api.microsofttranslator.com/V2/Http.svc/Detect?text='.urlencode($inputStr);
//	$strResponse = $translatorObj->curlRequest($detectMethodUrl,$authHeader);
//	$xmlObj = simplexml_load_string($strResponse);
//	foreach((array)$xmlObj[0] as $val) {
//		$languageCode = $val;
//	}
//	$locale = 'en';
//	$getLanguageNamesurl = 'http://api.microsofttranslator.com/V2/Http.svc/GetLanguageNames?locale=$locale';
//	$requestXml = $translatorObj->createReqXML($languageCode);
//	$curlResponse = $translatorObj->curlRequest($getLanguageNamesurl,$authHeader,$requestXml);
//	$xmlObj = simplexml_load_string($curlResponse);
//	echo "<table border=2px>";
//	echo "<tr>";
//	echo "<td>Language Codes</td><td>Language Names</td>";
//	echo "</tr>";
//	foreach($xmlObj->string as $language) {
//		echo "<tr><td>".$inputStr."</td><td>".$languageCode."(".$language.")"."</td></tr>";
//	}
//	echo "</table>";
} catch (Exception $e) {
	echo "Exception: ". $e->$getMessage().PHP_EOL;
}
?>
