<?php
	include('includes/mysqli_connect.php');
	$mail = $_GET['mail'];
	$key = $_GET['resetkey'];
	$q = "SELECT resetkey FROM users WHERE mail = '$mail'";
	$r = @mysqli_query($dbc,$q);
	while($row=mysqli_fetch_array($r)){
		$resetkey = $row['resetkey'];
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
	echo "<section class='account'>";
	if($key==$resetkey) {
		echo "<span class='resetpass'>
			<form action='updatepass.php' method='POST'>
			<p>Please enter your new password</p>
			<p>New Password</p>
			<input type='password' name='editpass' class='editpass' />
			<p>Confirm New Password</p>
			<input type='password' name='confeditpass' class='editpass' />
			<input type='hidden' name='mail' value='$mail' />
			<input type='submit' name='name' value='Create New Password' />
			</form>
			</span>";

	} else {
		echo 'Sorry, the reset key does not match for this email. Please try again.';
	}
	echo "</section>
		</body>
		</html>";
?>
