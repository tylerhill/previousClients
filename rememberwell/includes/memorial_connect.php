<?php # mysqli_connect.php
	DEFINE ('DB_USER', 'hswainmems');
	DEFINE ('DB_PASSWORD','Remember12');
	DEFINE ('DB_HOST', '205.178.146.108');
	DEFINE ('DB_NAME', 'memorials');
	$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('this did not work' . mysqli_connect_error() );
?>
