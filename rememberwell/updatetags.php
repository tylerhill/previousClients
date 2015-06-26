<?php
	include('includes/mysqli_connect.php');
		$tags = implode(", ",$_POST['tags']);	
		$q = "UPDATE posts SET tags='$tags' WHERE post_id = $post";
		$r = @mysqli_query($dbc,$q);
		$tagcount=1;
			foreach ($_POST['tags'] as $tag) {
				$q = "UPDATE tags SET tag$tagcount = '$tag' WHERE post_id = $post";
				$r = @mysqli_query ($dbc,$q);
				$tagcount++;
			}
	header("Location:edit.php?post=$post");
?>
