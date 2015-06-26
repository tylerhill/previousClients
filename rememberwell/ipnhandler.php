<?php
	include('mysqli_connect.php');
	$worked = 'no...';
	$header = '';
	$emailtext = '';
	$email='tylerhillwebdev@gmail.com';
	$req = 'cmd=_notify-validate';
	if(function_exists('get_magic_quotes_gpc')) {
		$get_magic_quotes_exists=true;
	}
	foreach($_POST as $key => $value) {
		if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1){
			$value = urlencode(stripslashes($value));
		} else {
			$value = urlencode($value);
		}
		$req  .='&$key=$value';
	}
	$header .= 'POST /cgi-bin/webscr HTTP/1.0\r\n';
	$header .= 'Content-Type: application/x-www-form-urlencoded\r\n';
	$header .= 'Content-Length: ' . strlen($req) . '\r\n\r\n';
	$fp = fsockopen('ssl://www.paypal.com',443,$errno,$errstr,30);
	if(!$fp){
		echo 'error';
	} else {
		fputs($fp,$header . $req);
		while(!feof($fp)){
			$res=fgets($fp,1024);
			if(strcmp($res,'VERIFIED') ==0){
				foreach($_POST as $key => $value){
					$emailtext .= $key . ' = '.$value. '\n\n';
				}
				mail($email,'IPN',$emailtext.'\n\n' . $req);
				$q = "INSERT INTO test (worked,email) VALUES (1,$email)";
				$r = @mysqli_connect($dbc,$q);
				$worked = 'yeah!';
			} else if (strcmp($res,'INVALID')==0) {
				foreach($_POST as $key => $value){
					$emailtext .= $key . ' = '.$value. '\n\n';
				}
				mail($email,'IPN',$emailtext.'\n\n' . $req);
				$q = "INSERT INTO test (worked,email) VALUES (0,$email)";
				$r = @mysqli_connect($dbc,$q);
				$worked = 'yeah!';
			}
		}
	fclose($fp);
	}
	echo $worked;
	
?>
