<?php 
	include('includes/mysqli_connect.php');
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
		<span class='loginuser'>
		<p>Please enter the email address associated with your account. You will be sent an email containing your password.</p>
		<form action='forgotmail.php' method='POST' class='loginuser'>
		<span class='logininputs'>
		<p>Email<input type='text' name='email'  class='loginuser'/></p>
		<input type='hidden' name='submitted' value='TRUE' />
		<input type='submit' name='submit' value='Send' class='submit'/>
		</span><br />
		</form>
		</span>
		</section>";
	echo "
		</body>
		</html>";
?>
