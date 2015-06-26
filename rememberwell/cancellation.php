<?php 
	include('includes/mysqli_connect.php');
	echo "
		<html>
		<head>
		<link rel='stylesheet' href='style.css' type='text/css' />
		<title>Create an Account</title>
		<script src='includes/jquery.min.js'></script>
		</head>
		<body>";
	include('logobar.php');
	echo "
		<nav class='accountcreate'>
		<h4>What would you like to do?</h4>
		<a href='index.php'>Find Resources</a><br />
		<a href='index.php'>Commemorate a Loved One</a><br />
		<a href='index.php'>Discover Happenings</a><br />
		<a href='index.php'>Read News</a><br />
		<span class='social'>
		<a href='https://www.facebook.com/RememberWell' target='_blank'>
		<img src='faceicon.jpg' class='social' />
		</a>
		<a href='http://www.linkedin.com/profile/view?id=13796028&trk=tab_pro' target='_blank'>
		<img src='linkedicon.jpg' class='social' />
		</a>
		<a href='https://plus.google.com/105392463603909325675/posts?hl=en' target='_blank'>
		<img src='googicon.jpg' class='social' />
		</a>
		<a href='https://twitter.com/#!/RememberWell' target='_blank'>
		<img src='twiticon.jpg' class='social' />
		</a>
		</span>
		</nav>";

	echo "
		<section class='account'>
		<p class='cancel'>Your order has been cancelled. If you have further questions, please email heather@rememberwell.net. Thank you.</p>
		</section>";
	echo "
		</body>
		</html>";
?>
