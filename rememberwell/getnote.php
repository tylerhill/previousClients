<?php
	include('includes/mysqli_connect.php');
	$curuser = $_GET['curuser'];
	$post_id=$_GET['post_id'];
	$q = "SELECT * FROM notes WHERE post_id = $post_id";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$note_id[] = $row['note_id'];
		$user_id[] = $row['user_id'];
		$note[] = $row['note'];
		$username[] = $row['username'];
	}
	$numNotes=count($note_id);
	if(empty($numNotes)) {
		echo "<p>No notes posted here yet.</p>";
	}
	for($i=0;$i<$numNotes;$i++) {
		echo "<span class='note' id=$note_id[$i]>";
			if($user_id[$i]==$curuser){
				echo "<img src='close.png' class='delnote'  /><br/>";
			}
		echo " <p class='note'>$note[$i]</p>
			<p class='sig'>$username[$i]</p>
			</span>";
	}
?>
