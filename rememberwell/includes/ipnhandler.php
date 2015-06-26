<?php
	session_start();
	include('mysqli_connect.php');
	$ipn_post_data=$_POST;	
	if(array_key_exists('test_ipn',$ipn_post_data) && 1 ===(int)$ipn_post_data['test_ipn']) {
		$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	} else {
		$url = 'https://www.paypal.com/cgi-bin/webscr';
	}
	$request = curl_init();
	curl_setopt_array($request,array
	(
		CURLOPT_URL=>$url,
		CURLOPT_POST=>TRUE,
		CURLOPT_POSTFIELDS=>http_build_query(array('cmd' => '_notify-validate') + $ipn_post_data),
		CURLOPT_RETURNTRANSFER=>TRUE,
		CURLOPT_HEADER=>FALSE,
		CURLOPT_SSL_VERIFYPEER=>FALSE,
	));
	$response = curl_exec($request);
	$status = curl_getinfo($request, CURLINFO_HTTP_CODE);

	curl_close($request);
	if($response=='VERIFIED'){
		$user_id = $ipn_post_data['custom'];
		$quant = $ipn_post_data['option_selection1'];
		$transid = $ipn_post_data['txn_id'];
		if($quant=='1 Memorial'){
			$quant=1;
		} else if ($quant=='2 Memorials'){
			$quant=2;
		} else if ($quant=='3 Memorials'){
			$quant=3;
		}
		$q = "SELECT * FROM payments WHERE txn='$transid'";
		$r = @mysqli_query($dbc,$q);
		if(mysqli_num_rows($r)==0){
		$q = "SELECT mems FROM users WHERE user_id = $user_id";
		$r = @mysqli_query($dbc,$q);
		while($row=mysqli_fetch_array($r)){
			$curmems = $row['mems'];
		}
		$amount = $quant+$curmems;
		$q = "UPDATE users SET mems = $amount WHERE user_id = $user_id";
		$r = @mysqli_query($dbc,$q);
		$q = "INSERT INTO payments (txn,quant) VALUES ('$transid','$quant')";
		$r = @mysqli_query($dbc,$q);
		}

		$message = $quant.  '\n' .$transid . ':::' . $user_id;
		$email = 'tylerhillwebdev@gmail.com';
		mail($email,'IPN',$message);
	}

	
?>
