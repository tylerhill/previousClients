<?php
	include('mysqli_connect.php');
	$redir=$_POST['redir'];
	$msg_id=$_POST['msg_id'];
	$mem_id=$_POST['mem_id'];
	$q = "DELETE FROM guestbook WHERE msg_id=$msg_id";
	$r = @mysqli_query($dbc,$q);
	if($redir=='edit') {
	header("Location:../newmemorial.php?mem_id=$mem_id");
	} else {
	header("Location:../memorial.php?mem_id=$mem_id");
	}
	
?>
