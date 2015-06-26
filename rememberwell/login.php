<?php # login.php
	if(isset($_POST['submitted'])) {
		require_once('includes/login_functions.inc.php');
		require_once('includes/mysqli_connect.php');
		list ($check,$data) = check_login($dbc,$_POST['email'],$_POST['pass']);
		if($check) {
			session_start();
			$_SESSION['user_id'] = $data['user_id'];
			$_SESSION['first_name'] = $data['first_name'];
			if ($_SESSION['user_id']==1) {
			$url = absolute_url ('loggedin.php');
			header("Location: $url");
			} else {
				header('Location:userhome.php');
			}
			exit();
		} else {
			$errors = $data;
		}

		mysqli_close($dbc);
	}
	include('includes/login_page.inc.php');
?>
