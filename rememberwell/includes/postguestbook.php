<?php
	session_start();
	include('mysqli_connect.php');
	if(!isset($_SESSION['user_id'])) {
		header("Location:../accountcreate.php");
		exit();
	}
	$q = "SELECT username FROM users WHERE user_id = $user_id";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$username = $row['username'];
	}
	$mem_id=$_POST['mem_id'];
	$message=$_POST['message'];

	$q = "INSERT INTO guestbook (mem_id,username,message,date,user_id) VALUES ('$mem_id','$username','$message',NOW(),$user_id)";
	$r = @mysqli_query($dbc,$q);
	header("Location:../memorial.php?mem_id=$mem_id");


?>
