<?php
	include('mysqli_connect.php');
	$offer_id = $_GET['deloffer'];
	$q = "DELETE FROM offerings WHERE offer_id=$offer_id";
	$r = @mysqli_query($dbc,$q);
	echo $offer_id;
?>
