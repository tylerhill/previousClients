<?php
	session_start();
	include('includes/mysqli_connect.php');
	$mem_id = $_GET['mem_id'];
	$user_id = $_GET['user_id'];
	$headimg = $_GET['headimg'];
	$form = $_GET['form'];
	$formdata = array();
	parse_str($form,$formdata);
	$firstname = $formdata['firstname'];	
	$midname = $formdata['midname'];	
	$lastname = $formdata['lastname'];	
	$birthmonth = $formdata['birthmonth'];
	$birthday = $formdata['birthday'];
	$birthyear = $formdata['birthyear'];
	$birthdate = $birthmonth. " " . $birthday. ", ". $birthyear;
	$birthplace = $formdata['birthplace'];
	$deathmonth = $formdata['deathmonth'];
	$deathday = $formdata['deathday'];
	$deathyear = $formdata['deathyear'];
	$deathdate = $deathmonth. " " . $deathday. ", ". $deathyear;
	$deathcause = $formdata['deathcause'];
	$achievements = $formdata['achievements'];
	$career = $formdata['career'];
	$belief = $formdata['belief'];
	$bio = $_GET['bio'];
	$bio = nl2br($bio);
	if($mem_id==0) {
	$q = "INSERT INTO memfacts (firstname, midname, lastname, birthdate, birthmonth, birthday, birthyear, birthplace, deathdate, deathmonth, deathday, deathyear, deathcause, achievements, career, belief, bio, user_id, headimg) VALUES ('$firstname','$midname','$lastname','$birthdate','$birthmonth','$birthday','$birthyear','$birthplace','$deathdate','$deathmonth','$deathday','$deathyear','$deathcause','$achievements','$career','$belief','$bio','$user_id','$headimg')";
	$r = @mysqli_query($dbc,$q);
	$newmem = mysqli_insert_id($dbc);
	mkdir("uploads/memorials/$newmem");
	chmod("uploads/memorials/".$newmem,0775);
		
	$q = "SELECT mems FROM users WHERE user_id = $user_id";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$memsLeft = $row['mems'];
	}
	$newMems=$memsLeft-1;
	$q = "UPDATE users SET mems=$newMems WHERE user_id=$user_id";
	$r = @mysqli_query($dbc,$q);
	} else {
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
		bio='$bio',
		headimg='$headimg'
	       	WHERE mem_id=$mem_id";
	$r = @mysqli_query($dbc,$q);
	}
	

?>
