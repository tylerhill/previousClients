<?php
	include('includes/mysqli_connect.php');
	echo "
	<!DOCTYPE html>
	<html>
	<head>
	<link rel='stylesheet' href='style.css' type='text/css' />
	<title>Upload Post</title>
	</head>
	<body>
	<div class='form'>
	<form action='upload.php' method='POST'>
	<p>Title</p>
	<input type='text' name='title' />
	<p>Body</p>
	<textarea name='body'></textarea>
	<input type='submit' name='submit' value='Post' />
	</form>
	</div>
	<div class='posts'>
	";
	$q = "SELECT * FROM posts ORDER BY time DESC";
	$r = @mysqli_query($dbc,$q);
	$num = mysqli_num_rows($r);
	while ($row = mysqli_fetch_array($r)) {
		$post[] = $row['post_id'];
		$title[] = $row['title'];
	}
	for($i=0;$i<$num;$i++) {
		echo "<p>$title[$i]</p><a href='delete.php?post=".$post[$i]."'>Delete</a>";
	}

	echo "
	</div>
	</body>
	</html>";
?>
