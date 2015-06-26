<?php
	include('includes/mysqli_connect.php');
	$post = $_POST['post'];
	$new = $_POST['new'];
	$newvalue = $_POST['newvalue'];
	$newvalue = nl2br($newvalue);
	$q = "INSERT INTO content (post_id) VALUES ('$post')";
	$r = @mysqli_query($dbc,$q);
	$q = "UPDATE content SET $new='$newvalue' WHERE post_id=$post";
	$r = @mysqli_query($dbc,$q);
		echo "<form action='edit.php' method='POST'><input type='hidden' name='post_id' value=$post /><input type='submit' name='submit' value='back to edit' /></form>";
	
?>
