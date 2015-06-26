<?php
	include('includes/mysqli_connect.php');
	$post = $_GET['post'];
	$tags = $_GET['tags'];
		$tagcount=1;
			foreach ($tags as $tag) {
				$tag = str_replace(' ','',$tag);
				$q = "UPDATE tags SET tag$tagcount = '$tag' WHERE post_id = $post";
				$r = @mysqli_query ($dbc,$q);
				$tagcount++;
			}
	$tagstring = implode(", ",$tags);	
		$q = "UPDATE posts SET tags='$tagstring' WHERE post_id = $post";
		$r = @mysqli_query($dbc,$q);

	$form = $_GET['form'];
	$formdata = array();
	parse_str($form,$formdata);
	$title = $formdata['title'];
	$cap = $formdata['caption'];
	$maintext = $formdata['maintext'];
	$q = "SELECT * FROM content WHERE post_id=$post";
	$r = @mysqli_query($dbc,$q);
	if(mysqli_num_rows($r)==0){
		$q = "INSERT INTO content (post_id) VALUES ($post)";
		$r = @mysqli_query($dbc,$q);
	}
	$q = "UPDATE posts SET title='$title', caption='$cap' WHERE post_id=$post";
	$r = @mysqli_query($dbc,$q);
	$q = "UPDATE content SET maintext='$maintext' WHERE post_id=$post";
	$r = @mysqli_query($dbc,$q);

?>
