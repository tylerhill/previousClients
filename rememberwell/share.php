<?php 
	include('includes/mysqli_connect.php');
	$sharemail = $_POST['sharemail'];
	$frommail = $_POST['frommail'];
	$post_id = $_POST['post_id'];
	$url = 'www.rememberwell.net/resource.php?resc='.$post_id;
	$q = "SELECT title FROM posts WHERE post_id = $post_id";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$title = $row['title'];
	}

		$message = "$frommail found this on RememberWell.net, and wanted to share it with you!".
			"\n".
			"\n'$title'".
			"\n$url";
		$headers = "From:$frommail";
		mail($sharemail,'Article on RememberWell.net',$message,$headers);
?>
