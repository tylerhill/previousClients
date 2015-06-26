<?php
	include('mysqli_connect.php');
	$img_id = $_GET['img'];
	$mem_id = $_GET['mem_id'];
	$q = "UPDATE memimgs SET profile=0 WHERE mem_id = $mem_id";
	$r = @mysqli_query($dbc,$q);	
	$q = "UPDATE memimgs SET profile=1 WHERE img_id = $img_id";
	$r = @mysqli_query($dbc,$q);
	header("Location:../newmemorial.php?mem_id=$mem_id");
?>
