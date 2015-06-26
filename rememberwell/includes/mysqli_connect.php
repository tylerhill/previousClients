<?php # mysqli_connect.php
	DEFINE ('DB_USER', 'dbo538823316');
	DEFINE ('DB_PASSWORD','Remember12');
	DEFINE ('DB_HOST', 'db538823316.db.1and1.com');
	DEFINE ('DB_NAME', 'db538823316');
	$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('this did not work' . mysqli_connect_error() );
?>
