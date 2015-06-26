<?php 
	session_start();
	include('includes/mysqli_connect.php');
	if (!empty($_POST['newemail'])){
	$newemail = $_POST['newemail'];
	} else {
		echo "Please input email";
	}
	if (!empty($_POST['newpass'])) {
	$newpass = $_POST['newpass'];
	} else {
		echo "Please input password";
	}
	if (!empty($_POST['newpassconfirm'])) {
	$newpassconfirm = $_POST['newpassconfirm'];
	} else {
		echo "Please confirm password";
	} 
	if (!empty($_POST['newusername'])) {
		$newusername = $_POST['newusername'];
	} else {
		echo "Please enter a username";
	}
	if ($newemail && $newpass && $newpassconfirm && $newusername) {
		if ($newpass == $newpassconfirm){
			$q = "SELECT email,username FROM users";
			$r = @mysqli_query($dbc,$q);
			while($row=mysqli_fetch_array($r)) {
				$users[] = $row['email'];
				$names[] = $row['username'];
			}
			foreach ($users as $usermail) {
				if ($newemail==$usermail) {
					$errors[] = "There is already an account associated with that email address";
				}
			}
			foreach ($names as $username) {
				if ($newusername==$username) {
					$errors[] = "That username is already taken";
				}
			}
			if (!empty($errors)) {
				foreach ($errors as $error) {
					echo $error;
				}
			} else {
			$q = "INSERT INTO users (email,pass,username) VALUES ('$newemail',SHA1('$newpass'),'$newusername')";
			$r = @mysqli_query($dbc,$q);
			echo "Account Created!";
			$q = "SELECT user_id FROM users WHERE username = '$newusername'";
			$r = @mysqli_query($dbc,$q);
			while ($row=mysqli_fetch_array($r)) {
				$user_id = $row['user_id'];
			}
			$_SESSION['user_id'] = $user_id;
			header("Location:userhome.php");
			}
		} else {
			echo "Passwords do not match";
		}
	}
?>
