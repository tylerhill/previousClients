<?php
Class HTTPTranslator {
	function curlRequest($url,$authHeader,$postData) {
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_HTTPHEADER,array($authHeader,'Content-Type: text/xml'));
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,TRUE);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			//$postData = utf8_encode($postData);
			curl_setopt($ch,CURLOPT_POST,TRUE);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$postData);
		$curlResponse = curl_exec($ch);
		$code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		$curlErrno = curl_errno($ch);
		if($curlErrno){
			$curlErrno=curl_error($ch);
			throw new Exception($curlError);
		}
		curl_close($ch);
		return $curlResponse;
	}

	function createReqXML($fromLanguage,$toLanguage,$contentType,$inputStrArr) {
		$fromLanguage = utf8_encode($fromLanguage);
		$toLanguage = utf8_encode($toLanguage);
		$requestXml = "<TranslateArrayRequest>".
			"<AppId/>".
			"<From>$fromLanguage</From>".
			"<Options>".
			//"<Catgeory xmlns=\"http://schemas.datacontract.org/2004/07/Microsoft.MT.Web.Service.V2\"></Category>".
			"<ContentType xmlns=\"http://schemas.datacontract.org/2004/07/Microsoft.MT.Web.Service.V2\">$contentType</ContentType>".
			//"<ReservedFlags xmlns=\"http://schemas.datacontract.org/2004/07/Microsoft.MT.Web.Service.V2\"></ReservedFlags> ".
			//"<State xmlns=\"http://schemas.datacontract.org/2004/07/Microsoft.MT.Web.Service.V2\"></State>".
			//"<Uri xmlns=\"http://schemas.datacontract.org/2004/07/Microsoft.MT.Web.Service.V2\"></Uri>".
			//"<User xmlns=\"http://schemas.datacontract.org/2004/07/Microsoft.MT.Web.Service.V2\"></User>".
			"</Options>".	
			"<Texts>";
		foreach($inputStrArr as $inputStr){
			$requestXml .= "<string xmlns=\"http://schemas.microsoft.com/2003/10/Serialization/Arrays\">$inputStr</string>";
		}
			$requestXml .= "</Texts>".
				"<To>$toLanguage</To>".
		
				"</TranslateArrayRequest>";
		return $requestXml;
	}
}

?>
