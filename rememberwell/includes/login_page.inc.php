<?php # login_page.inc.php
	$page_title = 'Login';
	if (!empty($errors)) {
		echo "Sorry, didn't work";
		foreach($errors as $msg) {
			echo "- $msg<br />\n";
		}
	}
?>
<h1>login</h1>
<form action='login.php' method='post'>
	<label for='login' id='login'>Log In</label>
	<label for='email'>Username</label>
		<input type='text' name='email' class='login' />
	<label for='pass'>Password</label>
		<input type='password' name='pass' class='login' />
		<input type='submit' name='submit' value='Login' />
		<input type='hidden' name='submitted' value='TRUE' />
</form>

	
