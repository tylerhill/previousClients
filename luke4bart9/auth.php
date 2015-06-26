<?php
class AccessTokenAuthentication {
	function getTokens($grantType,$scopeUrl,$clientID,$clientSecret,$authUrl) {
		try {
			$ch = curl_init();
			$paramArr = array (
				'grant_type' => $grantType,
				'scope' => $scopeUrl,
				'client_id' => $clientID,
				'client_secret' => $clientSecret
			);
			$paramArr = http_build_query($paramArr);
			curl_setopt($ch,CURLOPT_URL,$authUrl);
			curl_setopt($ch,CURLOPT_POST,TRUE);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$paramArr);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			$strResponse=curl_exec($ch);
			$curlErrno=curl_error($ch);
			if($curlErrno){
				$curlError=curl_error($ch);
				throw new Exception($curlError);
			}
			curl_close($ch);
			$objResponse=json_decode($strResponse);
			if($objResponse->error){
				throw new Exception($objResponse->error_description);
			}
			return $objResponse->access_token;
		} catch (Exception $e) {
			echo "Exception-".$e->getMessage();
		}
	}
}
?>

