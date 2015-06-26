<?php
	include('includes/mysqli_connect.php');
	$mem_id = $_GET['mem_id'];
	$user_id = $_GET['user_id'];
	$imgsrc = $_GET['imgsrc'];
	$sent = $_GET['sent'];
	$q = "SELECT username FROM users WHERE user_id=$user_id";
	$r = @mysqli_query($dbc,$q);
	while($row=mysqli_fetch_array($r)) {
		$username=$row['username'];
	}
	$q = "INSERT INTO offerings (mem_id,user_id,offersrc,username,sent) VALUES ('$mem_id','$user_id','$imgsrc','$username','$sent')";
	$r = @mysqli_query($dbc,$q);
?>
