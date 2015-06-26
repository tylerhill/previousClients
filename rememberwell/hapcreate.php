<?php
	include('includes/mysqli_connect.php');
	$startyear = $_POST['startyear'];
	$startmonth = $_POST['startmonth'];
	$startday = $_POST['startday'];
	$starthour = $_POST['starthour'];
	$startminute = $_POST['startminute'];


	echo $starthour;
	echo $startminute;
	$datestart = $startmonth.' '. $startday . ' ' . $startyear . ' ' . $starthour . $startminute;
	$datestart = date('Y-m-d G:i:s',strtotime($datestart));
	echo $datestart;
	$q = "INSERT INTO happenings (datestart) VALUES ('$datestart')";
	$r = @mysqli_query($dbc,$q);
?>
