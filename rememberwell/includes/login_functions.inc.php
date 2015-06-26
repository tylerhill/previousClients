<?php # login_functions.inc.php
	function absolute_url ($page = 'login.php') {
		$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
		$url = rtrim($url, '/\\');
		$url .= '/' . $page;
		return $url;
	}

	function check_login($dbc, $email = '', $pass = '') {
		$errors = array();
		if (empty($email)) {
			$errors[] = 'no email';
		} else {
			$e = mysqli_real_escape_string($dbc,trim($email));
		}

		if (empty($pass)) {
			$errors[] = 'no password';
		} else {
			$p = SHA1(mysqli_real_escape_string($dbc,trim($pass)));
		}	

		if (empty($errors)) {
			$q = "SELECT * FROM users WHERE email = '$e' AND pass='$p'";
			$r = @mysqli_query ($dbc,$q);

			if(mysqli_num_rows($r) == 1) {
				$row=mysqli_fetch_array ($r,MYSQLI_ASSOC);
				return array(true, $row);
			} else {
				$errors[]="The email address and password don't  match ";
			}
		}
		return array(false, $errors);
	}
?>
