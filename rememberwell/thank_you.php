<?php 
	session_start();
	$user_id=$_SESSION['user_id'];
	include('includes/mysqli_connect.php');
	if(isset($_GET['tx'])){
		$tx = $_GET['tx'];
	}
	$request = curl_init();
	$token = '7DI133BSt-yoh4SXmQ3GdJjfib_zQgaQlvlFQIB1WC5IDh2eX91duzp1BVm';
		
	curl_setopt_array($request, array
		(
			CURLOPT_URL=>'https://www.paypal.com/cgi-bin/webscr',
			CURLOPT_POST=>TRUE,
			CURLOPT_POSTFIELDS=>http_build_query(array
			(
				'cmd'=>'_notify-synch',
				'tx'=>$tx,
				'at'=>$token,
			)),
			CURLOPT_RETURNTRANSFER=>TRUE,
			CURLOPT_HEADER=>FALSE,
		));
	$response=curl_exec($request);
	$status=curl_getinfo($request,CURLINFO_HTTP_CODE);
	curl_close($request);
	$message = $response . ':::' .  $status;
	if($status==200 AND strpos($response,'SUCCESS') === 0) {
		$response = substr($response, 7);
		$response = urldecode($response);
		preg_match_all('/^([^=\s]++)=(.*+)/m',$response,$m,PREG_PATTERN_ORDER);
		$response = array_combine($m[1],$m[2]);
		$quant = $response['option_selection1'];
		if($quant=='1 Memorial'){
			$quant=1;
		} else if ($quant=='2 Memorials'){
			$quant=2;
		} else if ($quant=='3 Memorials'){
			$quant=3;
		}
		$transid = $response['txn_id'];
		$user_id = $response['custom'];
		$_SESSION['user_id']=$user_id;
		$messasge = $message . ':::' . $quant . ':::' . $transid;
		$q = "SELECT * FROM payments WHERE txn='$transid'";
		$r = @mysqli_query($dbc,$q);
		$paymentlogged = mysqli_num_rows($r);
		if($paymentlogged==0){
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
		$email = 'tylerhillwebdev@gmail.com';
		mail($email,'PDT Callback Success',$message);

	} else {
		echo 'error';
		$email = 'tylerhillwebdev@gmail.com';
		mail($email,'PDT Callback Fail',$message);
	}
	echo "
		<html>
		<head>
		<link rel='stylesheet' href='style.css' type='text/css' />
		<title>Create an Account</title>
		<script src='includes/jquery.min.js'></script>
		</head>
		<body>";
	include('logobar.php');
	include('includes/navmenu.php');


	echo "
		<section class='account'>
		<span class='thankyou'>
		<p>Thank you for your order! Please continue to your account to create a new memorial.</p>";


		
	echo 	"</span>
		<span class='loginuser'>
		<a href='userhome.php'>Profile Home</a>	
		</span>
		</section>";
	echo "
		</body>
		</html>";
?>
