<?php
	session_start();
	include('includes/mysqli_connect.php');
	$nodes = $_POST['nodes'];
	$mem_id = $_POST['mem_id'];
	$nodes = json_encode($nodes);
	$q = "INSERT INTO collage (mem_id,nodes) VALUES ($mem_id,'$nodes')";
	$r = @mysqli_query($dbc,$q);

	
?>
