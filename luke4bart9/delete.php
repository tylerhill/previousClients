<?php
	header("location:post.php");
	include('includes/mysqli_connect.php');
	$post = $_GET['post'];
	$q = "DELETE FROM posts WHERE post_id = $post";
	$r = @mysqli_query($dbc,$q);
?>
