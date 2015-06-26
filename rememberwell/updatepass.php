<?php 
	include('includes/mysqli_connect.php');
	$pass = $_POST['editpass'];
	$passconf = $_POST['confeditpass'];
	$mail = $_POST['mail'];
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
	
	if ($pass==$passconf) {
		$newpassreset = SHA1($pass);
		$q = "UPDATE users SET pass = '$newpassreset' WHERE email = '$mail'";
		$r = @mysqli_query($dbc,$q);
		echo "<p>Thank you! Your password has now been changed.</p>
			<a href='accountcreate.php'>Log In</a>";
	} else {
		echo '<p>Sorry, passwords do not match.</p>';
	echo "<span class='resetpass'>
			<form action='updatepass.php' method='POST'>
			<p>Please enter your new password</p>
			<p>New Password</p>
			<input type='password' name='editpass' class='editpass' />
			<p>Confirm New Password</p>
			<input type='password' name='confeditpass' class='editpass' /><br /><br />
			<input type='submit' name='name' value='Create New Password' />
			</form>
			</span>";
	}
	echo "</section>
		</body>
		</html>";

?>
