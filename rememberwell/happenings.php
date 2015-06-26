<?php
	session_start();
	include('includes/mysqli_connect.php');
	echo "
		<html>
		<head>
		<link rel='stylesheet' href='style.css' type='text/css' />
		<title>Discover Happenings</title>
		<script src='includes/jquery.min.js'></script>
		</head>
		<body>";
	include('logobar.php');
	include('includes/navmenu.php');	

	echo "
		<section class='happenings'>";
?>
<iframe src="https://www.google.com/calendar/embed?src=rememberwell%40gmail.com&ctz=America/Los_Angeles" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
<?php echo "</section>
	</body>
	</html>";
