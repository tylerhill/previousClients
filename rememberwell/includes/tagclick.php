<?php
	session_start();
	include('mysqli_connect.php');
	$tag = $_GET['thistag'];		
      for ($i=1;$i<=29;$i++) {
			$q = "SELECT post_id FROM tags WHERE tag$i='$tag'";
			$r = @mysqli_query($dbc,$q);
			while ($row=mysqli_fetch_array($r)) {
			$posts[] = $row['post_id'];
			}
	}

	foreach($posts as $post_id) {
		$q = "SELECT * FROM posts WHERE post_id = $post_id";
		$r = @mysqli_query($dbc,$q);
		$row = mysqli_fetch_array($r);
		$post[] = $row['post_id'];
		$title[] = $row['title'];
		$img[] = $row['img'];
		$caption[] = $row['caption'];
		$tags[] = $row['tags'];
	}
	$results = array();
	array_push($results, $post, $title, $img, $caption, $tags);
	$results = json_encode($results);
	echo $results;
?>
