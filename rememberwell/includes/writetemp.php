<?php
	include('mysqli_connect.php');
	$mem_id = $_GET['mem_id'];
	$form = $_GET['form'];
	$bio = $_GET['bio'];
	echo $mem_id;
	echo $form;
	echo $bio;
	$q = "INSERT INTO memtemp (mem_id,form,bio) VALUES ('$mem_id','$form','$bio')";
	$r = @mysqli_query($dbc,$q);
?>
