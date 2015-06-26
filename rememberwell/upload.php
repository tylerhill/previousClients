<?php
	include('includes/mysqli_connect.php');
	$q = "INSERT INTO posts	(img) VALUES ('temp')";
	$r = @mysqli_query($dbc,$q);
	$q = "SELECT post_id FROM posts WHERE img='temp'";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$post = $row['post_id'];
	}
	$q = "INSERT INTO content (post_id) VALUES ('$post')";
	$r = @mysqli_query($dbc,$q);
	$cap = $_POST['caption'];
	$title = $_POST['title'];
	$maintext = $_POST['maintext'];
	$maintext = nl2br($maintext);
	$video = $_POST['video'];
	mkdir("uploads/$post");
	chmod("uploads/".$post,0775);
	$filecount = 0;
	$col[] = "thumbimg";
	$col[] = "headimg";
	$col[] = "bodyimg1";
	$col[] = "bodyimg2";
	foreach ($_FILES['file']['name'] as $filename) {
		if ($tmp = $_FILES['file']['tmp_name'][$filecount]) {
			$uploaddir = "uploads/$post/";
			$uploadfile = $uploaddir . basename($_FILES['file']['name'][$filecount]);
			move_uploaded_file($tmp,$uploadfile);
			chmod($uploadfile,0644);
			$q = "UPDATE content SET $col[$filecount]='$uploadfile' WHERE post_id=$post";
			$r = @mysqli_query($dbc,$q);
			$filecount++;
		}
	}
		$q = "SELECT thumbimg FROM content WHERE post_id = $post";
		$r = @mysqli_query($dbc,$q);
		while ($row=mysqli_fetch_array($r)) {
			$img = $row['thumbimg'];
		}
		$q = "UPDATE posts SET img='$img', caption='$cap', title='$title', video='$video' WHERE post_id=$post";
		$r = @mysqli_query($dbc,$q);
		$q = "UPDATE content SET maintext='$maintext' WHERE post_id=$post";
		$r = @mysqli_query($dbc,$q);
		$q = "INSERT INTO tags (post_id) VALUES ('$post')";
		$r = @mysqli_query ($dbc,$q);
		$tagcount=1;
		$tags = implode(", ",$_POST['tags']);	
		$q = "UPDATE posts SET tags='$tags' WHERE post_id = $post";
		$r = @mysqli_query($dbc,$q);
			foreach ($_POST['tags'] as $tag) {
				$tag = str_replace(' ','',$tag);
				$q = "UPDATE tags SET tag$tagcount = '$tag' WHERE post_id = $post";
				$r = @mysqli_query ($dbc,$q);
				$tagcount++;
			}
		header("Location:loggedin.php");
?>
