<?php
	session_start();
	include('mysqli_connect.php');
	$tag = $_GET['thistag'];
	$currenttags = array();
	foreach($_SESSION['clicked'] as $click) {
		$currenttags[] = $click;
	}
	$key = array_search($tag,$currenttags);
	echo $_SESSION['clicked'][$key];
	unset($_SESSION['clicked'][$key]);
?>
