<?php 
	include('includes/mysqli_connect.php');
	$post_id = $_POST['resc'];
	$user_id = $_POST['user_id'];
	$q = "DELETE FROM favorites WHERE user_id = $user_id AND post_id = $post_id";
	$r = @mysqli_query($dbc,$q);
?>
