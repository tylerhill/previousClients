<?php
	include('includes/mysqli_connect.php');
	$ask = $_POST['user_id'];
	$mem_id = $_POST['mem_id'];
	$msg = $_POST['msg'];
	$username = $_POST['username'];
	$q = "SELECT user_id FROM memfacts WHERE mem_id = $mem_id";
	$r = @mysqli_query($dbc,$q);
	while ($row = mysqli_fetch_array($r)) {
		$own = $row['user_id'];
	}
	$q = "SELECT * FROM reqs WHERE (mem_id = $mem_id) AND (ask_id = $ask)";
	$r = @mysqli_query($dbc,$q);
	$num = mysqli_num_rows($r);
	if ($num==0) {
	$q = "INSERT INTO reqs (ask_id,own_id,mem_id,msg,username) VALUES ($ask,$own,$mem_id,'$msg','$username')";
	$r = @mysqli_query($dbc,$q);
	} else {
		echo 1;
	}
	

?>
