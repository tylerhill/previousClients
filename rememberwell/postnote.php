<?php 
	include('includes/mysqli_connect.php');
	$note = $_POST['note'];
	$user_id = $_POST['user_id'];
	$post_id = $_POST['post_id'];
	$q = "SELECT username FROM users WHERE user_id=$user_id";
	$r = @mysqli_query($dbc,$q);
	while($row=mysqli_fetch_array($r)) {
		$username = $row['username'];
	}
	$q = "INSERT INTO notes (user_id,post_id,note,username) VALUES ($user_id,$post_id,'$note','$username')";
	$r = @mysqli_query($dbc,$q);
	$note_id=mysqli_insert_id($dbc);
	echo "<span class='note' id=$note_id>";
				echo "<img src='close.png' class='delnote'  /><br/>";
		echo " <p class='note'>$note</p>
			<p class='sig'>$username</p>
			</span>";
?>
