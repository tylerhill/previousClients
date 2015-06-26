<?php
include('includes/mysqli_connect.php');
$title = $_POST['title'];
if (!empty($title)) {
	$q = "SELECT post_id FROM posts WHERE title = '$title'";
	$r = @mysqli_query ($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$post = $row['post_id'];
	}
	$q = "INSERT INTO tags (post_id) VALUES ('$post')";
	$r = @mysqli_query ($dbc,$q);
	$count=1;
foreach ($_POST['tags'] as $tag) {
	$q = "UPDATE tags SET tag$count = '$tag' WHERE post_id = $post";
	$r = @mysqli_query ($dbc,$q);
	$count++;
}
	mkdir($title);
	chmod($title,0777);
	$uploaddir = "uploads/$title/";
	$uploadfile = $uploaddir . basename($_FILES['upload']['name']);
		if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadfile)) {
		$src = "uploads/{$_FILES['upload']['name']}";
		chmod($src,0644);
		$cap = $_POST['caption'];
		$title = $_POST['title'];
		$q = "INSERT INTO posts (img, caption, title)
			VALUES ('$src','$cap','$title')";
		$r = @mysqli_query($dbc,$q);

} else {
	echo 'naw.';
}
} else {
	echo "Post needs title!";
}
	//header("Location: loggedin.php");

?>
