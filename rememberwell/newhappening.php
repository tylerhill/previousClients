<?php 
	include('includes/mysqli_connect.php');
	echo "
		<html>
		<head>
		<title>View Resource</title>
		<link rel='stylesheet' href='style.css' type='text/css' />
		<link rel='stylesheet' href='profilestyle.css' type='text/css' />
		<script src='includes/jquery.min.js' type='text/javascript'></script>
		</head>
		<body>";
	echo "<section class='newhap'>";
	echo "<form action='hapcreate.php' method='POST'>";
	$months=array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
	
	echo "<label id='startdate'>Start Date</label>";
	echo "<select name='startmonth' id='startmonth'>";
	foreach ($months as $month) {
		echo "<option value='$month'>$month</option>";
	}
	echo "</select>";
	echo "<select name='startday'>";
	for ($day = 1; $day <= 31; $day++) {
		echo "<option value='$day'>$day</option>";
	}
	echo "</select>";
	echo "<select name='startyear'>";
	for ($startyear = 1900; $startyear <= 2012; $startyear++) {
		echo "<option value='$startyear'>$startyear</option>";
	}
	echo "</select>";
	
?>
