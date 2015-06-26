<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("Location:accountcreate.php");
		exit();
	}
	include('includes/mysqli_connect.php');
	echo "<html>
		<head>
		<title>Edit Memorial</title>
		<link rel='stylesheet' href='style.css' type='text/css' />
		<link rel='stylesheet' href='profilestyle.css' type='text/css' />
		<script src='includes/jquery.min.js'></script>
		</head>
		<body>";
	include('logobar.php');
	$q = "SELECT user_id FROM memfacts WHERE mem_id=$mem_id";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$mem_user=$row['user_id'];
	}
	if ($user_id!=$mem_user) {
		echo "<p>You do not have permission to edit this memorial.</p>";
		echo "<a href='index.php'>Home</a>";
	} else {

	$mem_id = $_GET['mem_id'];
	$q = "SELECT * FROM memfacts WHERE mem_id = $mem_id";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$firstname = $row['firstname'];	
		$midname = $row['midname'];	
		$lastname = $row['lastname'];	
		$birthmonth = $row['birthmonth'];
		$birthday = $row['birthday'];
		$birthyear = $row['birthyear'];
		$birthplace = $row['birthplace'];
		$deathmonth = $row['deathmonth'];
		$deathday = $row['deathday'];
		$deathyear = $row['deathyear'];
		$deathcause = $row['deathcause'];
		$achievements = $row['achievements'];
		$career = $row['career'];
		$belief = $row['belief'];
		$bio = $row['bio'];
	}
	$q = "SELECT imgsrc FROM memimgs WHERE (mem_id = $mem_id) AND (profile = 1)";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$profilepic = $row['imgsrc'];
	}
	echo "	<section class='memfacts'>
		<h3>Profile Picture</h3>
		<span class='profilepic'>";
	if ($profilepic) {
		echo "<img src='$profilepic' class='profilepic' />";
	} else {
		echo "<label>No picture selected</label>";
	}
	echo "
		</span>
		<form action='memupdate.php' method='POST'>
		<label for='firstname' id='firstname'>First Name</label>
		<input type='text' name='firstname' value='$firstname' class='newprofin' />
		<label for='midname' id='midname'>Middle Name</label>
		<input type='text' name='midname' value='$midname' class='newprofin' />
		<label for='lastname' id='lastname'>Last Name</label>
		<input type='text' name='lastname' value='$lastname' class='newprofin' />";
	$months=array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
	echo "<label id='birthdate'>Birthdate</label>";
	echo "<select name='birthmonth' id='birthmonth'>";
	foreach ($months as $month) {
		if ($month == $birthmonth) {
			echo "<option value='$month' selected='selected'>$month</option>";
		} else {
		echo "<option value='$month'>$month</option>";
		}
	}
	echo "</select>";
	echo "<select name='birthday'>";
	for ($day = 1; $day <= 31; $day++) {
		if ($day == $birthday) {
			echo "<option value='$day' selected='selected'>$day</option>";
		} else {
		echo "<option value='$day'>$day</option>";
		}
	}
	echo "</select>";
	echo "<select name='birthyear'>";
	for ($year = 1900; $year <= 2012; $year++) {
		if ($year == $birthyear) {
			echo "<option value='$year' selected='selected'>$year</option>";
		} else {
		echo "<option value='$year'>$year</option>";
		}
	}
	echo "</select>";
	echo "<label for='birthplace' id='birthplace'>Place of Birth</label>";
	echo "<input type='text' name='birthplace' value='birthplace' />";

	echo "<label id='deathdate'>Deathdate</label>";
	echo "<select name='deathmonth' id='deathmonth'>";
	foreach ($months as $month) {
		if ($month == $deathmonth) {
			echo "<option value='$month' selected='selected>$month</option>";
		} else {
		echo "<option value='$month'>$month</option>";
		}
	}
	echo "</select>";
	echo "<select name='deathday'>";
	for ($day = 1; $day <= 31; $day++) {
		if ($day == $deathday) {
			echo "<option value='$day' selected='selected'>$day</option>";
		} else {
		echo "<option value='$day'>$day</option>";
		}
	}
	echo "</select>";
	echo "<select name='deathyear'>";
	for ($year = 1900; $year <= 2012; $year++) {
		if ($year == $deathyear) {
			echo "<option value='$year' selected='selected'>$year</option>";
		} else {
		echo "<option value='$year'>$year</option>";
		}
	}
	echo "</select>";
	echo "<label for='deathcause' id='deathcause'>Cause of Death</label>
		<input type='text' name='deathcause' value='$deathcause' />";
	echo "<label for='achievements' id='achievements'>Achievements</label>
		<textarea rows='10' cols='40' name='achievements'>$achievements</textarea><br />";
	echo "<label for='career' id='career'>Career</label>
		<input type='text' name='career' value='$career' />";
	echo "<label for='belief' id='belief'>Belief</label>
		<input type='text' name='belief' value='$belief' />";
	echo "<label for='bio' id='bio'>Bio</label>
		<textarea rows='10' cols='40' name='bio'>$bio</textarea><br />";
	echo "<input type='hidden' name='mem_id' value='$mem_id' />";
	echo "<input type='submit' name='submit' value='Submit' />";
	echo "</form>
	<a href='memorial.php?mem_id=$mem_id' class='back'>back</a>
	</section>";
	echo "<section class='imgupload'>
		<h3>Upload images for your memorial</h3>
		<form enctype='multipart/form-data' action='memupload.php' method='POST'>
		<input type='hidden' name='max_file_size' value='524288'>
		<input type='file' name='file[]' multiple /><br />
		<input type='file' name='file[]' multiple /><br />
		<input type='file' name='file[]' multiple /><br />
		<input type='hidden' name='mem_id' value='$mem_id' />
		<input type='submit' name='submit' value='Submit' />
		</form>";
	echo "</section>";
	echo "<section class='currentimgs'>";
	$q = "SELECT img_id, imgsrc FROM memimgs WHERE mem_id = $mem_id";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$img_id = $row['img_id'];
		$imgsrc = $row['imgsrc'];
		echo "<div class='currentimg'>";
		echo "<img src='$imgsrc' class='memimgedit' />";
		echo "<form action='updatememimg.php' method='POST'>
			<label for='caption'>Caption</label>
			<input type='text' name='caption' />
			<input type='submit' name='submit' value='Add' />
			</form>";
		echo "<form action='includes/makeprofpic.php' method='POST'>
			<input type='hidden' name='img_id' value=$img_id />
			<input type='hidden' name='mem_id' value=$mem_id />
			<input type='submit' name='submit' value='Make Profile Picture' />
			</form>";
		echo "</div>";
	}
	echo "</section>";
	echo "<section class='delete'>
		<h3>Delete this Memorial</h3>
		<form action='uploads/memorials/memdeleteconfirm.php' method='POST'>
		<input type='hidden' name='mem_id' value='$mem_id' />
		<input type='submit' name='submit' value='Delete' />
		</section>";

	echo "</body>
		</html>";
	}
?>
