<?php
	include('includes/mysqli_connect.php');
	$note_id=$_POST['note_id'];
	$q= "DELETE FROM notes WHERE note_id = $note_id";
	$r = @mysqli_query($dbc,$q);
?>
