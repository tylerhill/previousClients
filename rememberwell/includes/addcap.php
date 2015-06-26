<?php
	include('mysqli_connect.php');
	$img_id = $_GET['img'];
	$mem_id = $_GET['mem_id'];
	$cap = $_GET['cap'];
	$q = "UPDATE memimgs SET cap='$cap' WHERE img_id=$img_id";
	$r = @mysqli_query($dbc,$q);
?>
