<?php
	include('includes/mysqli_connect.php');
	$q = "SELECT tags, post_id FROM posts";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$tags[] = $row['tags'];
		$posts[] =$row['post_id'];
	}
	$count = count($posts);
	for($i=0;$i<$count;$i++) {
		$tagsex = explode(', ',$tags[$i]);
		$post = $posts[$i];
		$tagcount=1;
		foreach ($tagsex as $tag) {
			$tag = str_replace(' ','',$tag);
				$q = "UPDATE tags SET tag$tagcount = '$tag' WHERE post_id = $post";
				$r = @mysqli_query ($dbc,$q);
				$tagcount++;
		}

	}

	
?>
