<?php
	session_start();
	$_SESSION = array();
	session_destroy();
	setcookie('PHPSESSID', '', time()-3600, '/', '', 0, 0);
	header("Location:index.php");
?>
	
