<?php 
	session_start();
	include('includes/mysqli_connect.php');
	$mem_id = $_GET['mem_id'];
	$user_id = $_SESSION['user_id'];
	if(!empty($user_id)) {
	$q = "SELECT username FROM users WHERE user_id=$user_id";
	$r = @mysqli_query($dbc,$q);
	while($row=mysqli_fetch_array($r)) {
		$username = $row['username'];
	}
	}else{
		$user_id = 0;
		$username = 0;
	}
	echo $logged;
	$q = "SELECT * FROM memfacts WHERE mem_id = $mem_id";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$mem_user = $row['user_id'];
		$firstname = $row['firstname'];	
		$midname = $row['midname'];	
		$lastname = $row['lastname'];	
		$birthdate = $row['birthdate'];
		$birthplace = $row['birthplace'];
		$deathdate = $row['deathdate'];
		$deathcause = $row['deathcause'];
		$achievements = $row['achievements'];
		$career = $row['career'];
		$belief = $row['belief'];
		$bio = $row['bio'];
		$headimg = $row['headimg'];
	}
	$name = $firstname." ".$lastname;


	echo "
		<!DOCTYPE html>
		<html>
		<head>
		<title>$name</title>
		<link rel='stylesheet' href='style.css' type='text/css' />
		<link rel='stylesheet' href='profilestyle.css' type='text/css' />
		<script src='includes/jquery.min.js'></script>";
?>
<script>
$(document).ready(function() {
	var mem_id = <?php echo $mem_id ?>;
	var user_id = <?php echo $user_id ?>;
	var username = "<?php echo $username ?>";
	$('div.openoffer').click(function(){
		$('section.chooseoffering').fadeIn(200);
	});
	$('img.close').click(function(){
		$('section.chooseoffering').fadeOut(200);
	});
	$('div.thisoffer').click(function(){
		$('div.thisoffer#current').attr('id','');
		$(this).attr('id','current');
	});
	$('div.leaveoffering').click(function(){
		var imgsrc = $('div.thisoffer#current').children('img').attr('src');
		var sent = $('textarea.sent').val();
		$.ajax({
			type:'GET',
			url:'leaveoffering.php',
			data:{'imgsrc':imgsrc,'mem_id':mem_id,'user_id':user_id,'sent':sent},
			success:function(data){
				$('section.chooseoffering').fadeOut(200);
				window.location.replace('memorial.php?mem_id='+mem_id);

			}
		});
	});
	$('img.deloffer').click(function(){
		var delconf = $(this).parent('div').children('span.delconf');
		$(delconf).slideDown(200);

	});
	$('p.yes').click(function(){
		var deloffer = $(this).attr('id');
		$.ajax({
			type:'GET',
			url:'includes/deleteoffering.php',
			data:{'deloffer':deloffer},
			success: function(data){
				$('div.thisofferpost#'+deloffer).remove();
			}
		});
	});
	$('p.no').click(function(){
		$(this).parent('span.delconf').slideUp(200);
	});
	$('div.contrib').click(function(){
			window.location.href = 'contrib.php?mem_id='+mem_id;
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

	$q = "SELECT * FROM offerings WHERE (mem_id = $mem_id) ORDER BY offer_id DESC";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$img[] = $row['offersrc'];
		$sent[] = $row['sent'];
		$user[] = $row['username'];
		$offer[]= $row['offer_id'];
		$offuser[] = $row['user_id'];
	}
	$numOff = mysqli_num_rows($r);
	echo "<span class='offercont'>";
	echo "<section class='offerings'>
		<span class='offerings'>";
	for ($i=0;$i<$numOff;$i++) {
		echo "<div class='thisofferpost' id=$offer[$i]>";
			if($offuser[$i]==$user_id) {
			 echo "<img src='close.png' class='deloffer'  />";
			}
			echo "<img src='$img[$i]' class='offering' />
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
	<a href='collage.php?mem_id=$mem_id'>Collage</a>
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
		if(!empty($value)){
			echo "<span class='fact'>";
			echo "<p class='key'>$key</p>
				<p class='fact'>$value</p>";
			echo "</span>";
		}
	}
	echo "</section>";
	echo "<div class='memcenter'>";
	echo "<section class='membio'>";
	echo "<h3>Biography</h3>";
	echo "<p>$bio</p>";
	echo "</section>";
	echo "<section class='guestbook'>";
	echo "<h3 class='memorial'>Photos, Videos, and Guestbook</h3>";
	echo "<div class='contrib'>
		<p>Contribute Images</p>
		</div>";
	echo "<span class='signbook'>";
	echo "<form action='includes/postguestbook.php' method='POST' class='sign'>
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

