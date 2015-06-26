<?php 
	include('includes/mysqli_connect.php');
echo "
	<div class='header'>
	<a href='index.php' class='logo'>
	<img src='logo.png' class='logo' />";
	if(isset($_SESSION['user_id'])) {
		$user_id = $_SESSION['user_id'];
		$q = "SELECT username FROM users WHERE user_id = $user_id";
		$r = @mysqli_query($dbc,$q);
		$row = mysqli_fetch_array($r);
		$username = $row['username'];
		echo "</a>
			<a href='userhome.php' class='logo'><h2 class='logo'>$username</h2>
			</a>";
		echo "<span class='login'>
			<a href='userhome.php'>$username</a>
			<a href='logout.php'>Log Out</a>
			</span>";
		if($user_id==1) {
			echo "<a href='loggedin.php' class='admin'>Admin Page</a>";
		}
	} else {
	 echo "<h2 class='logo'>RememberWell.net</h2>
	</a>
	<p>Online memorials and end-of-life resources for a conscious transition</p>";
	
	echo "
	<span class='login'>
	<a href='accountcreate.php'>Log In</a>
	<a href='accountcreate.php'>or</a>
	<a href='accountcreate.php'>Sign Up</a>
	</span>";
	}
	echo "
	<input type='text' name='search' value='search' class='search' />
	</div> ";
?>
