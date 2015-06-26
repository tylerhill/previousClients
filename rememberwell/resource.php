<?php 
	session_start();
	if(isset($_SESSION['user_id'])) {
		$loggedin = 'true';
		$user_id = $_SESSION['user_id'];
	} else {
		$loggedin = 'false';
	}
	include('includes/mysqli_connect.php');
	$post = $_GET['resc'];
	$redir = $_GET['redir'];
	$q = "SELECT * FROM content WHERE post_id=$post";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$main = $row['maintext'];
		$main = str_replace("\\","",$main);
		$bodyimg1 = $row['bodyimg1'];
		$bodyimg2 = $row['bodyimg2'];
	}
	$q = "SELECT * FROM posts WHERE post_id=$post";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$title = $row['title'];
		$lowtitle = strtolower($title);
		$headimg = $row['img'];
		$video = $row['video'];
	}
	echo "
		<html>
		<head>
		<title>View Resource</title>
		<link rel='stylesheet' href='style.css' type='text/css' />
		<link rel='image_src' href='http://rememberwell.net/$headimg' />
		<meta property='og:image' content='http://rememberwell.net/$headimg' />
		<script src='includes/jquery.min.js' type='text/javascript'></script>
		</head>";
?>
<script src='includes/jquery.min.js' type='text/javascript'></script>
<script>
$(document).ready(function(){
	var post = <?php echo $post ?>;
	var loggedin = <?php echo $loggedin ?>;
	var user_id = <?php echo $user_id ?>;
	var saved = "<h3 class='saved'></h3>";
	var notes = "<div class='notes'></div>\
		<div class='postnote'>\
		<textarea name='note' class='note'></textarea><br />\
		<div class='submitnote'>\
		<p>Post Note</p>\
		</div>\
		</div>";
	var share = "<div class='share'>\
		<span class='sharemail'><h3>Send to email:</h3>\
		<input type='text' name='sharemail' class='sharemail' /></span><br />\
		<span class='frommail'><h3>From:</h3>\
		<input type='text' name='frommail' class='frommail' /></span><br />\
		<div class='submitshare'>\
		<p>Share</p>\
		</div>\
		</div>";
$('span.hover').hide();
$('span.notes').prepend(notes);
	var hoverFunc = function() {
	$('span.reschead').hover(
		function() {
			$('span.hover').fadeIn(200);
	},
		function() {
			$('span.hover').fadeOut(200);
		});
	$('img#like').click(function(){
		var thispost = post;
		if (loggedin==true) {
		$.post('includes/like.php',{post_id:thispost,user_id:user_id},function(data) {
			$('h3.saved').text('Resource Saved');
			$('h3.saved').fadeIn(200);
			});
		} else {
			window.location.href = 'accountcreate.php';
		}
	});

	var dataload = 0;
	$('img#notes').click(function(){
		var post_id = post;
		var isshown = $('span.notes').attr('id');
		if(isshown=='shown'){
		$('span.notes').children('div.notes').empty();
		dataload=0;
		$('span.notes').fadeOut(200);
		$('span.notes').attr('id','hidden');
		} else if(isshown=='hidden'){
		$('span.notes').attr('id','shown');
		$('span.notes').fadeIn(200,function(){
		$.ajax({
			type:'GET',
			url:'getnote.php',
			data:{'post_id':post_id,'curuser':user_id},
			success:function(data){
				if(dataload==0){
				$('span.notes').children('div.notes').append(data);
				$('img.delnote').click(function(){
				var thisnote = $(this).parent('span.note').attr('id');
					$.post('deletenote.php',{'note_id':thisnote},function(){
						$('span.note#'+thisnote).remove();
					});
						
				});
				dataload=1;
				}

			}});
		});
		}
	});
	$('div.submitnote').click(function(){
		var post_id = post;
		var note = $(this).parent('div.postnote').children('textarea').val();
		$.post('postnote.php',{'note':note,'user_id':user_id,'post_id':post_id},function(data){
			$('div.notes').children('p').remove();
			$('span.notes').children('div.notes').append(data);
				$('img.delnote').click(function(){
				var thisnote = $(this).parent('span.note').attr('id');
					$.post('deletenote.php',{'note_id':thisnote},function(){
						$('span.note#'+thisnote).remove();
					});
						
				});
		});
	});
	$('img#share').click(function(){
		var post_id = post;
		var isshown = $('span.share').attr('id');
		if(isshown=='shown') {
			$('span.share').fadeOut(200);
			$('span.share').empty();
			$('span.share').attr('id','hidden');
		} else if (isshown=='hidden') {
		$('span.share').attr('id','shown');
		$('span.share').append(share);
		$('span.share').fadeIn(200);
		$('div.submitshare').click(function(){
			var post_id = post;
			var sharemail = $('input.sharemail').val();
			var frommail = $('input.frommail').val();
			$.post('share.php',{'post_id':post_id,'sharemail':sharemail,'frommail':frommail},function(data){
				var thanks = '<p>Message sent! Thanks for sharing!</p>';
				$('span.share').empty();
				$('span.share').append(thanks);
			});
		});
		}
	});

	}

	hoverFunc();
});
</script>
<?php
echo"		<body>";
	include('logobar.php');
	echo "
		<div class='col'>
		<nav>
		<h4>What would you like to do?</h4>
		<a href='findresources.php'>Find Resources</a><br />
		<a href='newmemorial.php'>Commemorate a Loved One</a><br />
		<a href='index.php'>Discover Happenings</a><br />
		<a href='about.php'>About</a><br />
		<span class='social'>
		<a href='https://www.facebook.com/RememberWell' target='_blank'>
		<img src='faceicon.jpg' class='social' />
		</a>
		<a href='http://www.linkedin.com/profile/view?id=13796028&trk=tab_pro' target='_blank'>
		<img src='linkedicon.jpg' class='social' />
		</a>
		<a href='https://plus.google.com/105392463603909325675/posts?hl=en' target='_blank'>
		<img src='googicon.jpg' class='social' />
		</a>
		<a href='https://twitter.com/#!/RememberWell' target='_blank'>
		<img src='twiticon.jpg' class='social' />
		</a>
		</span>
		</nav>
		</div>
		";
	echo "
		<div class='resc'>";
	echo "<h2>".$title."</h2>";
	echo "<h3 class='saved'></h3>";
	if ($video==0) {
		echo "
			<span class='reschead'>
			<span class='hover'>
			<div class='hover'>
			<img src='like.gif' class='hovericon' id='like' />
			<img src='notes.gif' class='hovericon' id='notes' />
			<img src='share.gif' class='hovericon' id='share' />
			<img src='info.gif' class='hovericon' id='info' />
			</div>
			</span>
			<img src='$headimg' class='head'/>
			<span class='share' id='hidden'>
			</span>
			<span class='notes' id='hidden'>
			</span>
			</span>
			";
	}
	if ($video==1) {
		echo "
			<span class='reschead'>
			<span class='hover'>
			<div class='hover'>
			<img src='like.gif' class='hovericon' id='like' />
			<img src='notes.gif' class='hovericon' id='notes' />
			<img src='share.gif' class='hovericon' id='share' />
			<img src='info.gif' class='hovericon' id='info' />
			</div>
			</span>
			$main
			<span class='share' id='hidden'>
			</span>
			<span class='notes' id='hidden'>
			</span>
			</span>";
	} else {

	echo "<p class='resc'>".$main."</p>";
	}
	if($redir=='user'){
	echo "<a href='userhome.php'>Back home</a>";
	} else if ($redir=='find') {
	echo "<a href='findresources.php'>Back to Find Resources</a>";
	} else {
	echo "<a href='index.php'>Back home</a>";
	}
?>

<?php
	echo "</div>
		<section class='related'>
		<h3>Related Resources</h3>";
	$q = "SELECT tags FROM posts WHERE post_id = $post";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$tagstring=$row['tags'];
		if(!empty($tagstring)){
		$currenttags=explode(", ",$row['tags']);
		}
	}
	foreach ($currenttags as $currenttag) {
		$currenttag = str_replace(' ','',$currenttag);
		for ($i=1;$i<=29;$i++) {
			$q = "SELECT post_id FROM tags WHERE tag$i='$currenttag'";
			$r = @mysqli_query($dbc,$q);
			while ($row=mysqli_fetch_array($r)) {
				if ($row['post_id']!==$post) {
			$relatedposts[] = $row['post_id'];
				}
			}
		}
	}
	$relatedposts = array_unique($relatedposts);
	echo "<p class='tags'>$tagstring</p><br />";
	foreach ($relatedposts as $relatedpost) {
		$q = "SELECT title, img FROM posts WHERE post_id = $relatedpost";
		$r = @mysqli_query($dbc,$q);
		while ($row=mysqli_fetch_array($r)) {
			$relpostimg = $row['img'];
			$relposttitle = $row['title'];
		}
		echo "<div class='clip'>";
		echo "<a href='resource.php?resc=$relatedpost'>";
		echo "<img src='$relpostimg' class='relpost' />";
		echo "</a>";
		echo "</div>";
	}
	echo "</section>
		</body>
		</html>";
?>
