<?php # mysqli_connect.php
	DEFINE ('DB_USER', 'dbo435862162');
	DEFINE ('DB_PASSWORD','luke4bart9');
	DEFINE ('DB_HOST', 'db435862162.db.1and1.com');
	DEFINE ('DB_NAME', 'db435862162');

	$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('this did not work' . mysqli_connect_error() );
?>
	
