<?php
	include('includes/mysqli_connect.php');
	$req_id = $_POST['req_id'];
	$answer = $_POST['answer'];
	if ($answer==1) {
	$q = "SELECT ask_id, mem_id FROM reqs WHERE req_id = $req_id";
	$r = @mysqli_query($dbc,$q);
	while ($row = mysqli_fetch_array($r)) {
		$user_id = $row['ask_id'];
		$mem_id = $row['mem_id'];
	}
	$q = "INSERT INTO collabs (user_id,mem_id) VALUES ($user_id,$mem_id)";
	$r = @mysqli_query($dbc,$q);
	$q = "DELETE FROM reqs WHERE req_id = $req_id";
	$r = @mysqli_query($dbc,$q);
	} else if ($answer==0) {
	$q = "DELETE FROM reqs WHERE req_id = $req_id";
	$r = @mysqli_query($dbc,$q);
	}


?>
