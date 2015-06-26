<?php
	session_start();
	include('includes/mysqli_connect.php');
	$mem_id = $_GET['mem_id'];
	$user_id = $_SESSION['user_id'];
	if(!isset($_SESSION['user_id'])){
		header("location:accountcreate.php");
	}
	$collab = 0;
	$q = "SELECT user_id FROM collabs WHERE mem_id = $mem_id";
	$r = @mysqli_query($dbc,$q);
	while($row=mysqli_fetch_array($r)){
		$contribs[] = $row['user_id'];
	}
	if(isset($contribs)){
	foreach($contribs as $contrib) {
		if($contrib = $user_id) {
			$collab = 1;
		}
	}
	$q = "SELECT username FROM users WHERE user_id = $user_id";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$username = $row['username'];
	}
	}
	echo "
		<html>
		<head>
		<link rel='stylesheet' href='style.css' type='text/css' />
		<link rel='stylesheet' href='profilestyle.css' type='text/css' />
		<title>Commemoration - Upload Images</title>
		<script src='includes/jquery.min.js'></script>";
?>
<script>
	$(document).ready(function(){
		var user_id = <?php echo $user_id; ?>;
		var mem_id = <?php echo $mem_id ?>;
		var username = "<?php echo $username ?>";

		$('div.sendreq').click(function(){
			var msg = $('textarea.reqmsg').val();
			$.post('sendreq.php',{'user_id':user_id,'mem_id':mem_id,'msg':msg,'username':username},function(data){
				if(data==1){
					alert('You have already sent a request to contribute to this memorial.');
					window.location.replace('memorial.php?mem_id='+mem_id);
				} else {
				$('span.request').empty();
				var sent = "<h3>Request Sent!</h3><p>Once the owner approves you as a contributor, you'll be able to upload images to this memorial.</p>";
				$('span.request').append(sent);
				}


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
	});
</script>
<?php
echo "
		</head>
		<body>";
	include('logobar.php');
	include('includes/navmenu.php');
	echo "<section class='account'>";
	if($collab==0) {
		echo "<span class='request'>";
		echo "<h3>You are not yet a contributor to this memorial.</h3>";
		echo "<p>Would you like to send a request to contribute images to this memorial?</p>";
		echo "<label>Message to Memorial Admin:</label>";
		echo "<textarea name ='reqmsg' class='reqmsg'></textarea>";
		echo "<div class='sendreq'>
			<p>Send Request</p>
			</div>";
		echo "</span>";

	} else if ($collab==1) {
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
	}

	echo "</section>";
	echo "</body>
		</html>";
?>
