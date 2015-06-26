<?php
	include('includes/mysqli_connect.php');
	$mem_id = $_POST['mem_id'];
	$firstname = $_POST['firstname'];	
	$midname = $_POST['midname'];	
	$lastname = $_POST['lastname'];	
	$birthmonth = $_POST['birthmonth'];
	$birthday = $_POST['birthday'];
	$birthyear = $_POST['birthyear'];
	$birthdate = $birthmonth. " " . $birthday. ", ". $birthyear;
	$birthplace = $_POST['birthplace'];
	$deathmonth = $_POST['deathmonth'];
	$deathday = $_POST['deathday'];
	$deathyear = $_POST['deathyear'];
	$deathdate = $deathmonth. " " . $deathday. ", ". $deathyear;
	$deathcause = $_POST['deathcause'];
	$achievements = $_POST['achievements'];
	$career = $_POST['career'];
	$belief = $_POST['belief'];
	$bio = $_POST['bio'];
	$q = "UPDATE memfacts SET 
		firstname='$firstname',
		midname='$midname',
		lastname='$lastname',
		birthmonth='$birthmonth',
		birthday='$birthday',
		birthyear='$birthyear',
		birthdate='$birthdate',
		birthplace='$birthplace',
		deathmonth='$deathmonth',
		deathday='$deathday',
		deathyear='$deathyear',
		deathdate='$deathdate',
		deathcause='$deathcause',
		achievements='$achievements',
		career='$career',
		belief='$belief',
		bio='$bio'
	       	WHERE mem_id=$mem_id";
	$r = @mysqli_query($dbc,$q);
	header("Location:memorial.php?mem_id=$mem_id");
	
?>
