<?php
	session_start();	
	$user_id=$_SESSION['user_id'];
	include('includes/mysqli_connect.php');
	$mem_id = $_GET['mem_id'];
	$headimg = $_GET['headimg'];
	$firstname = $_GET['firstname'];	
	$midname = $_GET['midname'];	
	$lastname = $_GET['lastname'];	
	$birthmonth = $_GET['birthmonth'];
	$birthday = $_GET['birthday'];
	$birthyear = $_GET['birthyear'];
	$birthdate = $birthmonth. " " . $birthday. ", ". $birthyear;
	$birthplace = $_GET['birthplace'];
	$deathmonth = $_GET['deathmonth'];
	$deathday = $_GET['deathday'];
	$deathyear = $_GET['deathyear'];
	$deathdate = $deathmonth. " " . $deathday. ", ". $deathyear;
	$deathcause = $_GET['deathcause'];
	$achievements = $_GET['achievements'];
	$career = $_GET['career'];
	$belief = $_GET['belief'];
	$bio = $_GET['bio'];
	$bio = nl2br($bio);

	echo "<html>
		<head>
		<title>$name</title>
		<link rel='stylesheet' href='style.css' type='text/css' />
		<link rel='stylesheet' href='profilestyle.css' type='text/css' />
		<script src='includes/jquery.min.js'></script>";
?>
<script>
$(document).ready(function(){
	$('div.openoffer').click(function(){
		alert('Please exit preview mode to leave offerings');
	});
	$('form.sign').submit(function(){
		alert('Please exit preview mode to sign the guestbook');
	});
});
</script>

<?php echo "	</head>
		<body>";
	include ('logobar.php');


	if(!empty($headimg)) {
		echo "<section class='headimg'>
			<img src='$headimg' class='memheader' />
		<h1 class='preheadname'>$firstname $midname $lastname</h1>
			</section>";
	}
		echo "<section class='previewmode'>
		<p>Preview Mode</p>
		<a href='newmemorial.php?mem_id=$mem_id'>Back to Edit Memorial</a>
		</section>";

	$q = "SELECT * FROM offerings WHERE (mem_id = $mem_id) ORDER BY offer_id DESC";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$img[] = $row['offersrc'];
		$sent[] = $row['sent'];
		$user[] = $row['username'];
		$offer[]= $row['offer_id'];
	}
	$numOff = mysqli_num_rows($r);
	echo "<span class='offercont'>";
	echo "<section class='offerings'>
		<span class='offerings'>";
	for ($i=0;$i<$numOff;$i++) {
		echo "<div class='thisofferpost' id=$offer[$i]>
			<img src='close.png' class='deloffer'  />
			<img src='$img[$i]' class='offering' />
			<p class='sent'>$sent[$i]</p>
			<p class='sig'>$user[$i]</p>
			<span class='delconf' id=$offer[$i]>
				<h3>Delete Offering?</h3>
				<p class='yes' id=$offer[$i]>Yes</p>
				<p class='no'>No</p>
				</span>
			</div>";
	}
	echo " </span>
		<div class='openoffer'>
		<p>Leave Offering</p>
		</div>
		</section>";
	
	echo "</span>";


	echo "<div class='memleftblock'>";
	echo "<section class='facts'>";
	$mem_id = $_GET['mem_id'];
	$q = "SELECT imgsrc FROM memimgs WHERE (mem_id = $mem_id) AND (profile = 1)";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$profilepic = $row['imgsrc'];
	}
	if ($profilepic) {
		echo "<span class='profilepic'>
			<img src='$profilepic' class='profilepic' />
			</span>";
	}

	$facts = array('First Name' => $firstname,
		'Middle Name' => $midname,
		'Last Name' => $lastname,
		'Date of Birth' => $birthdate,
		'Place of Birth' => $birthplace,
		'Date of Death' => $deathdate,
		'Cause of Death' => $deathcause,
		'Achievements' => $achievements,
		'Career' => $career,
		'Belief' => $belief);
	foreach ($facts as $key => $value) {
			echo "<p class='key'>$key</p>
				<p class='fact'>$value</p>";
	}
	echo "</section>";
	echo "<div class='memcenter'>";
	echo "<section class='membio'>";
	echo "<h3>Biography</h3>";
	echo "<p>$bio</p>";
	echo "</section>";
	echo "<section class='guestbook'>";
	echo "<h3 class='memorial'>Photos, Videos, and Guestbook</h3>";
	echo "<span class='signbook'>";
	echo "<form action='' method='POST' class='sign'>
		<label for='message'>Message</label><br />
		<textarea name='message'></textarea><br />
		<input type='submit' name='submit' value='Sign' class='submit' />
		<input type='hidden' name='mem_id' value='$mem_id' />
		</form>";
	echo "</span>";
	echo "<span class='memimgs'>";
	$q = "SELECT * FROM memimgs WHERE mem_id=$mem_id";
	$r = @mysqli_query($dbc,$q);
	$numImgs = mysqli_num_rows($r);
	while ($row=mysqli_fetch_array($r)) {
		$images[]=$row['imgsrc'];
		$caps[]=$row['cap'];
	}
	$q = "SELECT * FROM guestbook WHERE mem_id = $mem_id ORDER BY msg_id DESC";
	$r = @mysqli_query($dbc,$q);
	$numMsgs = mysqli_num_rows($r);
	while ($row=mysqli_fetch_array($r)) {
		$messages[]=$row['message'];
		$usernames[]=$row['username'];
		$dates[]=$row['date'];
		$users[]=$row['user_id'];
		$msg_id[]=$row['msg_id'];
	}
	$imgcount=0;
	$msgcount=0;
	$number = $numImgs + $numMsgs;
	$switch = 0;
	for ($i=0;$i<=$number;$i++) {
		if ($switch==0 && $imgcount<$numImgs) {
			echo "<span class='msgimg'>";
			echo "<img src='$images[$imgcount]' class='memimg' /><br />";
			echo "<p class='memcap'>$caps[$imgcount]</p>";
			echo "</span>";
			$imgcount++;
			$switch=1;
		} else {
			$switch=1;
		}	
		if ($switch==1 && $msgcount<$numMsgs) {
			echo "<span class='msgimg'>";
			echo "<p class='msg'>$messages[$msgcount]</p>";
			echo "<p class='sig'>-$usernames[$msgcount]</p>";
			echo "<p class='sig'>$dates[$msgcount]</p>";
			if ($user_id==$users[$msgcount]) {
				echo "<form action='includes/deleteguestbook.php' method='POST'>
					<input type='submit' name='submit' value='Delete' />
					<input type='hidden' name='msg_id' value='$msg_id[$msgcount]' />
					<input type='hidden' name='mem_id' value='$mem_id' />
					</form>";	
			}
			echo "</span>";
			$msgcount++;
			$switch=0;
		} else {
			$switch=0;
		}
	}
	echo "</span>";
	echo "</section>";
	echo "</div>";
	echo "</div>";

	echo "<section class='chooseoffering'>";
	echo "<span class='close'>";
	echo "<section class='sentiment'>";
	echo "<h3>Add Sentiment</h3>";
	echo "<textarea name='sent' class='sent'></textarea>";
	echo "<div class='leaveoffering'>
		<p>Leave Offering</p>
		</div>";
	echo "</section>";
	echo "<img src='close.png' class='close' />";
	echo "</span>";
	foreach (scandir('offerings') as $offering) {
		if($offering!='.' && $offering!='..'){
		echo "<div class='thisoffer'>";
		echo "<img src='offerings/$offering' class='offering' />";
		echo "</div>";
		}
	}
		echo "</section>";

	echo "</body>
		</html>";
?>
