<?php
	header("location:post.php");
	include('includes/mysqli_connect.php');
	$title = $_POST['title'];
	$body = $_POST['body'];
	$body = nl2br($body);
	$q = "INSERT INTO posts (title,body) VALUES ('$title','$body')";
	$r = mysqli_query($dbc,$q);
?>
