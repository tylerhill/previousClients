<?php
	include('includes/mysqli_connect.php');
	$mail = $_POST['email'];
	$registered = 0;
	$q = "SELECT email FROM users";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$usersmail[] = $row['email'];
	}
	foreach ($usersmail as $usermail) {
		if($mail==$usermail) {
			$registered = 1;
	
		}
	}
	echo "
		<html>
		<head>
		<link rel='stylesheet' href='style.css' type='text/css' />
		<title>Create an Account</title>
		<script src='includes/jquery.min.js'></script>
		</head>
		<body>";
	include('logobar.php');
	include('includes/navmenu.php');

	echo "
		<section class='account'>
		<span class='loginuser'>";
	if($registered==1) {
		$resetkey = md5('jencylarue'.$mail);
		$q = "UPDATE users SET resetkey='$resetkey' WHERE email = '$mail'";
		$r = @mysqli_query($dbc,$q);
		$message = "Thank you for signing up at rememberwell.net. Please follow the link below to create a new password.\n".
			"\n http://www.rememberwell.net/resetpass.php?resetkey=".md5('jencylarue'.$mail)."&mail=".$mail;
		$headers = "From: Rememberwell.net";
		mail($mail,'Rememberwell Password',$message,$headers);
		echo '<p>Thank you! An email has just been sent to your address containing your password.
				If you do not receive the email, please contact us at heather@rememberwell.net.</p>';
	} else {
		echo "Sorry, our records do not contain a user account associated with that email address.";
	}
	echo "	</span>
		</section>";
	echo "
		</body>
		</html>";
	
?>
