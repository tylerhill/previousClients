<?php 
	include('mysqli_connect.php');
	$post_id = $_POST['post_id'];
	$user_id = $_POST['user_id'];
	$q = "SELECT * FROM favorites WHERE user_id=$user_id AND post_id=$post_id";
	$r = @mysqli_query($dbc,$q);
	if (mysqli_num_rows($r)==0) {
	$q = "INSERT INTO favorites (user_id,post_id) VALUES ($user_id,$post_id)";
	$r = @mysqli_query($dbc,$q);
	}

?>
