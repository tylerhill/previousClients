<?php 
	session_start();
	if(!isset($_SESSION['user_id'])){
		header("location:accountcreate.php");
	}
	$user_id = $_SESSION['user_id'];
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
		<p class='cancel'>You do not have any available memorials left. Please purchase more memorials to create a new one.</p>";

	echo "<div class='paypal'>
<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>
<input type='hidden' name='cmd' value='_s-xclick'>
<input type='hidden' name='hosted_button_id' value='TPB2ZGMFUFYHS'>
<table>
<tr><td><input type='hidden' name='on0' value='Memorials'>Memorials</td></tr><tr><td><select name='os0'>
	<option value='1 Memorial'>1 Memorial $9.99 USD</option>
	<option value='2 Memorials'>2 Memorials	$19.98 USD</option>
	<option value='3 Memorials'>3 Memorials	$27.97 USD</option>
</select> </td></tr>
</table>
<input type='hidden' name='currency_code' value='USD'>
<input type='hidden' name='custom' value=$user_id />
<input type='image' src='http://www.rememberwell.net/buynow.jpg' border='0' name='submit' alt='PayPal - The safer, easier way to pay online!'>
<img alt='' border='0' src='https://www.paypalobjects.com/en_US/i/scr/pixel.gif' width='1' height='1'>
</form>
	</div>";
	
		echo 	"
	<p class='cancel'>Our commemorations cost $9.99 because we don't sell your personal browsing and profile data to sustain the website, nor do we sell advertising space on the memorials themsleves- we believe banner ads have no place in a space devoted to memorializing a loved one.</p>
		<p class='cancel'>We ask for this money so we can continue to provide a reliable and respectful space for you to honor someone you loved, as well as offer information to keep you and your loved ones informed for the most important transition of your life.</p>
		</section>";
	echo "
		</body>
		</html>";
?>
