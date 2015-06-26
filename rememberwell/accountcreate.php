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
		<span class='create'>
		<div class='labels'>
		<p>Email</p>
		<p>Password</p>
		<p>Confirm Password</p>
		<p>Username</p>
		</div>
		<div class='inputs'>
		<form action='createuser.php' method='POST' class='createuser'>
		<input type='text' name='newemail' class='create' />
		<input type='password' name='newpass' class='create'/>
		<input type='password' name='newpassconfirm' class='create'/>
		<input type='text' name='newusername' class='create'/><br />
		<input type='submit' name='submit' value='Create New Account'  class='submit' />
		</form>
		</div>
		</span>
		<span class='loginuser'>
		<form action='login.php' method='POST' class='loginuser'>
		<span class='logininputs'>
		<p>Email<input type='text' name='email'  class='loginuser'/></p>
		<p>Password<input type='password' name='pass'  class='loginuser'/></p>
		<input type='hidden' name='submitted' value='TRUE' />
		<input type='submit' name='submit' value='Login' class='submit'/>
		<span class='forgot'>
		<a href='forgot.php'>Forgot Password?</a>
		</span>
		</span><br />
		</form>
		</span>
		</section>";
	echo "
		</body>
		</html>";
?>
