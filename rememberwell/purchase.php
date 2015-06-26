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
		<title>Purchase Memorials</title>
		<script src='includes/jquery.min.js'></script>
		</head>
		<body>";
	include('logobar.php');
	include('includes/navmenu.php');

	echo "
		<section class='account'>
		<h2>Purchase Memorials</h2>";
	

echo "<div class='paypal'>

<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>
<input type='hidden' name='cmd' value='_s-xclick'>
<input type='hidden' name='hosted_button_id' value='TPB2ZGMFUFYHS'>
<table>
<tr><td><input type='hidden' name='on0' value='Memorials'>Memorials</td></tr><tr><td><select name='os0'>
	<option value='1 Memorial'>1 Memorial	$9.99 USD</option>
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


		echo "</section>";
	echo "
		</body>
		</html>";
?>
