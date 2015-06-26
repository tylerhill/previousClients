<?php
	session_start();
	if(!isset($_SESSION['user_id'])){
		header("location:accountcreate.php");
	}
	include('includes/mysqli_connect.php');
	$user_id =  $_SESSION['user_id'];
	$q = "SELECT mems FROM users WHERE user_id = $user_id";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$memsLeft = $row['mems'];
	}
	$mem_id = $_GET['mem_id'];
	if($mem_id==0 && $memsLeft==0) {
		header("location:nomemsleft.php");
	}
	if($mem_id!=0) {
	$q = "SELECT * FROM memfacts WHERE mem_id = $mem_id";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$mem_user = $row['user_id'];
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
		$bio = str_replace("<br />","",$bio);
		$headimg = $row['headimg'];
	}
	$q = "SELECT imgsrc FROM memimgs WHERE mem_id = $mem_id AND profile = 1";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$profilepic = $row['imgsrc'];
	}
	}
	$q = "SELECT username FROM users WHERE user_id=$user_id";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$username=$row['username'];
	}

	echo "	
		<!DOCTYPE html>
		<html>
		<head>
		<title>Create a New Memorial</title>
		<link rel='stylesheet' href='style.css' type='text/css' />
		<link rel='stylesheet' href='profilestyle.css' type='text/css' />
		<script src='includes/jquery.min.js'></script>";
?>
<script>
$(window).load(function(){
	var headHeight = $('img.curheader').height();
	$('div.chooseheader').height(headHeight);
	$('div.curheader').height(headHeight);
	$('span.chooseheader').height(headHeight);
	$('section.headerimg').height(headHeight+20);
	$('div.chooseheader').fadeIn(200);
});
$(document).ready(function(){
	$('div.chooseheader').hide();
	$(window).resize(function(){
	headHeight = $('img.curheader').height();
	$('div.chooseheader').height(headHeight);
	$('div.curheader').height(headHeight);
	$('span.chooseheader').height(headHeight);
	$('section.headerimg').height(headHeight+20);
	});
	var mem_id = <?php echo $mem_id ?>;
	var user_id = <?php echo $user_id ?>;
	var username = "<?php echo $username ?>";
	$('div.creatememorial').click(function(){
		var form = $('form.memcreate').serialize();
		var bio = $('textarea#bio').val();
		var headimg = $('img.curheader').attr('src');
		$.ajax({
			type:'GET',
			url:'memcreate.php',
			data:{'form':form,'mem_id':mem_id,'user_id':user_id,'headimg':headimg,'bio':bio},
			success: function(data){
			window.location.replace('userhome.php');
			}
		});
	});
	$('div.previewmemorial').click(function(){
		var form = $('form.memcreate').serialize();
		var bio = $('textarea#bio').val();
		var headimg = $('img.curheader').attr('src');
		window.location.href = 'preview.php?'+form+'&bio='+bio+'&headimg='+headimg+'&mem_id='+mem_id;
		

	});
	$('img.headthumb').click(function(){
		var curheader = $(this).attr('src');
		$('img.curheader').attr('src',curheader);
		$('img.curheader').load(function(){
		var headHeight = $('img.curheader').height();
		$('div.chooseheader').height(headHeight);
		$('div.curheader').height(headHeight);
		$('span.chooseheader').height(headHeight);
		$('section.headerimg').height(headHeight+20);
		});

	});
	$('div.makeprofpic').click(function(){
		var img = $(this).attr('id');
		var imgsrc = $(this).parent('div.currentimg').children('img').attr('src');
		$.ajax ({
			type:'GET',
			url:'includes/makeprofpic.php',
			data:{'img':img,'mem_id':mem_id},
			success:function(data){
		$('img.profilepic').attr('src',imgsrc);
			}
		});
	});
		
	$('div.addcaption').click(function(){
		var img = $(this).attr('id');
		var cap = $('textarea#caption'+img).val();
		$.ajax({
			type:'GET',
			url:'includes/addcap.php',
			data:{'img':img,'mem_id':mem_id,'cap':cap},
			success:function(data){
				$('textarea#caption'+img).val(cap);
				$('label#caption'+img).text(cap);

			}
		});
	});

	$('div.deleteimg').click(function(){
		var img = $(this).attr('id');
		$.ajax({
			type:'GET',
			url:'includes/deletememimg.php',
			data:{'img':img},
			success:function(data){
				$('div.currentimg#'+img).remove();	
			}
		});
	});
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
				window.location.replace('newmemorial.php?mem_id='+mem_id);

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
	
});
</script>
<?php		
	echo "</script>
		</head>
		<body>";
	include('logobar.php');
	echo "<section class='headerimg'>";
	echo "<span class='headerimg'>
		<div class='curheader'>";
	if($headimg) {
		echo "<div class='curheaderimg'>";
		echo "<img src='$headimg' class='curheader' />";
		echo "<h1 class='editheadname'>$firstname $midname $lastname</h1>";
		echo "</div>";
	} else {
		echo "<div class='curheaderimg'>";
		echo "<img src='select.png' class='curheader' />";
		echo "</div>";
	}
	echo "
		</div>
		<div class='chooseheader'>";
	foreach(scandir('headers') as $headimg) {
		if($headimg!='.' && $headimg!='..'){
		echo "<img src='headers/$headimg' class='headthumb' /><br />";
		}
	}	
	echo "  </div>
		</span>";
	echo "</section>";
	echo "<div class='editleftblock'>";
	echo "<section class='savepublish'>";
	echo "<div class='creatememorial'>
		<p>Save</p>
		</div>";
	echo "<div class='deletememorial'>";
	echo "<a href='uploads/memorials/memdeleteconfirm.php?mem_id=$mem_id'>
		Delete
		 </a>";
	echo "</div>";
	echo "<div class='previewmemorial'>
		<p>Preview</p>
		</div>";
	if($mem_id==0){
	echo "<p class='direction'>Before uploading photos, please save memorial with first and last name. Thank you.</p>";
	}
	echo "</section>";
	echo "
		<section class='memfacts'>";
	echo "<span class='profilepic'>";
	echo "<h3>Profile Picture</h3>";
	if ($profilepic) {
		echo "<img src='$profilepic' class='profilepic' />";
	} else {
		echo "<img src='' class='profilepic' />";
		echo "<label class='noprof'>No picture selected</label>";
	}
	echo "</span>";
	echo "<span class='memcreate'>";
	echo "	<form action='memcreate.php' method='POST' class='memcreate'>
		<span class='fact'>
		<label for='firstname' id='firstname'>First Name</label>
		<input type='text' id='firstname' class='newprofin' name='firstname' value='$firstname' />
		</span>
		<span class='fact'>
		<label for='midname' id='midname'>Middle Name</label>
		<input type='text' id='midname' class='newprofin' name='midname' value='$midname' />
		</span>
		<span class='fact'>
		<label for='lastname' id='lastname'>Last Name</label>
		<input type='text' id='lastname' class='newprofin' name='lastname' value='$lastname' />
		</span>
		<span class='fact'>
		<label for='birthplace' id='birthplace'>Place of Birth</label>
		<input type='text' id='birthplace' name='birthplace' value='$birthplace' />
		</span>
		<span class='fact'>
		<label id='birthdate'>Birthdate</label>";
		echo "<div class='birthdate'>";
	echo "<select id='birthyear' name='birthyear'>";
	for ($year = 1900; $year <= 2012; $year++) {
		if($year==$birthyear) {
		echo "<option value='$year' selected='selected'>$year</option>";
		
		} else {
		echo "<option value='$year'>$year</option>";
		}
	}
	echo "</select>";
	echo "<select id='birthday' name='birthday'>";
	for ($day = 1; $day <= 31; $day++) {
		if($day==$birthday) {
		echo "<option value='$day' selected='selected'>$day</option>";
		} else {
		echo "<option value='$day'>$day</option>";
		}
	}
	echo "</select>";
	echo "<select id='birthmonth' id='birthmonth' name='birthmonth'>";
		$months=array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		foreach ($months as $month) {
		if($month==$birthmonth) {
		echo "<option value='$month' selected='selected'>$month</option>";
		} else {
		echo "<option value='$month'>$month</option>";
		}
		}
		
	echo "</select>";
	echo "</div>";
	echo "</span>";
	echo "<span class='fact'>";	
	echo "	<label id='deathdate'>Deathdate</label>";
	echo "<div class='deathdate'>";
	echo "<select id='deathyear' name='deathyear'>";
	for ($year = 1900; $year <= 2012; $year++) {
		if($year==$deathyear) {
		echo "<option value='$year' selected='selected'>$year</option>";
		} else {
		echo "<option value='$year'>$year</option>";
		}
	}
	echo "</select>";
	
	echo "<select id='deathday' name='deathday'>";
	for ($day = 1; $day <= 31; $day++) {
		if($day==$deathday) {
		echo "<option value='$day' selected='selected'>$day</option>";
		} else {
		echo "<option value='$day'>$day</option>";
		}
	}
	echo "</select>";

	echo "<select id='deathmonth' name='deathmonth'>";
	foreach ($months as $month) {
		if($month==$deathmonth){
		echo "<option value='$month' selected='selected'>$month</option>";
		} else{
		echo "<option value='$month'>$month</option>";
		}
	}
	echo "</select>";
	echo "</div>";
	echo "</span>";
	echo "<span class='fact'>";
	echo "	<label for='deathcause' id='deathcause'>Cause of Death</label>";
	echo "	<input type='text' id='deathcause' name='deathcause' value='$deathcause' />";
	echo "</span>";
	echo "<span class='fact'>";
	echo "	<label for='career' id='career'>Career</label>";
	echo "	<input type='text' id='career' name='career' value='$career'/>";
	echo "</span>";
	echo "<span class='fact'>";
	echo "	<label for='belief' id='belief'>Belief</label>";
	echo "	<input type='text' id='belief' name='belief' value='$belief' />";
	echo "</span>";

	echo "<label for='achievements' id='achievements'>Achievements</label>
		<textarea id='achievements' name='achievements'>$achievements</textarea><br />";
	echo "</form>
	</span>";
	echo "
	<a href='userhome.php' class='back'>back</a>
	</section>";


	echo "<div class='editcenter'>";
	echo "<section class='editbio'>";
		echo "<h3>Biography</h3>
		<textarea id='bio' name='bio'>$bio</textarea>";
	echo "</section>";

	if($mem_id!=0) {	
	echo "<section class='memimgupload'>";
	echo"   <div class='imgupload'>
		<h3>Upload images for your memorial</h3>
		<form enctype='multipart/form-data' action='memupload.php' method='POST' class='imgupload'>
		<input type='file' name='file[]' multiple />
		<input type='file' name='file[]' multiple />
		<input type='file' name='file[]' multiple />
		<input type='hidden' name='mem_id' value='$mem_id' />
		<input type='submit' name='submit' value='Submit' />
		</form>
		</div>";

	echo "<div class='currentimgs'>";
	echo "<h3>Uploaded Images</h3>";
	$q = "SELECT * FROM memimgs WHERE mem_id = $mem_id";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$img_id = $row['img_id'];
		$imgsrc = $row['imgsrc'];
		$cap = $row['cap'];
		echo "<div class='currentimg' id=$img_id>";
		echo "<img src='$imgsrc' class='memimgedit' />
			<label for='caption' id='caption$img_id'>$cap</label>
			<textarea name='caption' id='caption$img_id'>$cap</textarea>
			<div class='addcaption' id=$img_id>
			<p>Add Caption</p>
			</div>
			";
		echo "<div class='makeprofpic' id=$img_id>
			<p>Make Profile Picture</p>
			</div>";
		echo "<div class='deleteimg' id=$img_id>
			<p>Delete Image</p>
			</div>";
		echo "</div>";
		
	}
	echo "</div>";
	echo "</section>";

	$q = "SELECT imgsrc FROM memimgs WHERE (mem_id = $mem_id) AND (profile = 1)";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$profilepic = $row['imgsrc'];
	}

	
	

	}
	echo "</div>";
	echo "</div>";
	
	$q = "SELECT * FROM offerings WHERE (mem_id = $mem_id) ORDER BY offer_id DESC";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$img[] = $row['offersrc'];
		$sent[] = $row['sent'];
		$user[] = $row['username'];
		$offer[]= $row['offer_id'];
	}
	$numOff = mysqli_num_rows($r);
	if($mem_id!=0) {
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
	}

	echo "</body>";
	echo "</html>";

?>
