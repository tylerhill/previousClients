<?php
	session_start();
	include('includes/mysqli_connect.php');
	$clicked = $_POST['clicked'];
	unset($_SESSION['clicked']);
	$_SESSION['clicked']=$clicked;
?>
