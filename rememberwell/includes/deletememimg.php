<?php
	include('mysqli_connect.php');
	$img_id = $_GET['img'];
	$q = "DELETE FROM memimgs WHERE img_id=$img_id";
	$r = @mysqli_query($dbc,$q);
?>
