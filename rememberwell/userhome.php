<?php
	session_start();
	include('includes/mysqli_connect.php');
	if(!isset($_SESSION['user_id'])) {
		header("Location:index.php");
		exit();
	}
	$user_id = $_SESSION['user_id'];
	$q = "SELECT username FROM users WHERE user_id = $user_id";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$username = $row['username'];
	}	

	$q = "SELECT post_id FROM favorites WHERE user_id = $user_id";
	$r = @mysqli_query($dbc,$q);
	$numposts = mysqli_num_rows($r);
	while ($row=mysqli_fetch_array($r)) {
		echo "$post_id";
		$posts[] = $row['post_id'];
	}
	foreach($posts as $post_id) {
		$q = "SELECT * FROM posts WHERE post_id = $post_id";
		$r = @mysqli_query($dbc,$q);
		$row = mysqli_fetch_array($r);
		$post[] = $row['post_id'];
		$title[] = $row['title'];
		$img[] = $row['img'];
		$caption[] = $row['caption'];
		$tags[] = $row['tags'];
	}
	echo "<html>
		<head>
		<title>Welcome!</title>
		<link rel='stylesheet' href='style.css' type='text/css' />
		<link rel='stylesheet' href='profilestyle.css' type='text/css' />
		<script src='includes/jquery.min.js' type='text/javascript'></script>";
?>
<script>
$(document).ready(function(){
	var numposts = <?php echo $numposts ?>;
	var title = <?php echo json_encode($title) ?>;
	var img = <?php echo json_encode($img) ?>;
	var cap = <?php echo json_encode($caption) ?>;
	var post = <?php echo json_encode($post) ?>;
	var tags = <?php echo json_encode($tags) ?>;
	var user_id = <?php echo $user_id ?>;

	var width = $('span.favorites').width();
	var numCols = Math.floor(width/270);
	var column = "<div class='col'></div>";
	var div = 1;
	var thisbox;
	var fig = "<figure><h2></h2><span class='post'><a href='' class='img'><img class='post' /></a></span><br /><span class='notes' id='hidden'></span><span class='share' id='hidden'></span><p class='tags'></p><p class='cap'></p><a href='' class='resc'>see more</a></figure>";
	var hover = "<span class='hover'><img src='delete.gif' class='hovericon' id='delete' /><img src='notes.gif' class='hovericon' id='notes' /><img src='share.gif' class='hovericon' id='share' /><img src='info.gif' class='hovericon' id='info' /></span>";
	var notes = "<div class='notes'></div>\
		<div class='postnote'>\
		<textarea name='note' class='note'></textarea>\
		<div class='submitnote'>\
		<p>Post Note</p>\
		</div>\
		</div>";

	var share = "<div class='share'>\
		<h3>Send to email:</h3>\
		<input type='text' name='sharemail' class='sharemail' />\
		<h3>From:</h3>\
		<input type='text' name='frommail' class='frommail' />\
		<div class='submitshare'>\
		<p>Share</p>\
		</div>\
		</div>";
	for (i=1;i<=numCols;i++) {
	$('span.favorites').append($(column).attr('id',i));
	}
	for (i=0; i<numposts; i++) {
		$('div#'+div).append(fig);
		if (div<numCols) {
		div++;
		} else {
		div=1;
		}
	}
	$('figure').each(function(postcount){
		thisbox = $(this);
		curtitle = title[postcount];
		curimg = img[postcount];
		curcap = cap[postcount];
		curpost = post[postcount];
		curtags = tags[postcount];
		thisbox.attr('id',curpost);
		thisbox.children('h2').text(curtitle);
		thisbox.children('p.cap').append(curcap);
		thisbox.children('span.post').children('a').children('img').attr('src',curimg);
		thisbox.children('span.post').children('a').attr('href','resource.php?resc='+curpost+'&redir=user');
		thisbox.children('a').attr('href','resource.php?resc='+curpost+'&redir=user');
		thisbox.children('p.tags').text(curtags);
		thisbox.children('span.post').append(hover);
		thisbox.children('span.post').children('span.hover').hide();
		thisbox.children('span.notes').append(notes);

	});
var hoverFunc = function() {
	$('figure').hover(
		function() {
			$(this).children('span.post').children('span.hover').fadeIn(200);
	},
		function() {
			$(this).children('span.post').children('span.hover').fadeOut(200);
		});
	$('img#info').click(function(){
		var resc = $(this).parent('span.hover').parent('span.post').parent('figure').attr('id');
		window.location.href = 'resource.php?resc='+resc+'&redir=user';
	});
	$('img#delete').click(function(){
		var resc = $(this).parent('span.hover').parent('span.post').parent('figure').attr('id');
		$.post('deletesaved.php',{'resc':resc,'user_id':user_id},function(){
			window.location.href = 'userhome.php';
		});
	});
	var dataload = 0;
	$('img#notes').click(function(){
		var thisbox = $(this).parent('span.hover').parent('span.post').parent('figure');
		var post_id = $(thisbox).attr('id');
		var isshown = $(thisbox).children('span.notes').attr('id');
		if(isshown=='shown'){
		$(thisbox).children('span.notes').children('div.notes').empty();
		dataload=0;
		$(thisbox).children('span.notes').fadeOut(200);
		$(thisbox).children('span.notes').attr('id','hidden');
		} else if(isshown=='hidden'){
		$(thisbox).children('span.notes').attr('id','shown');
		$(thisbox).children('span.notes').fadeIn(200,function(){
		$.ajax({
			type:'GET',
			url:'getnote.php',
			data:{'post_id':post_id,'curuser':user_id},
			success:function(data){
				if(dataload==0){
				$(thisbox).children('span.notes').children('div.notes').append(data);
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
		var post_id = $(this).parent('div.postnote').parent('span.notes').parent('figure').attr('id');
		var note = $(this).parent('div.postnote').children('textarea').val();
		$.post('postnote.php',{'note':note,'user_id':user_id,'post_id':post_id},function(data){
			$('figure#'+post_id).children('span.notes').children('div.notes').append(data);
				$('img.delnote').click(function(){
				var thisnote = $(this).parent('span.note').attr('id');
					$.post('deletenote.php',{'note_id':thisnote},function(){
						$('span.note#'+thisnote).remove();
					});
						
				});
		});
	});
	$('img#share').click(function(){
		var thisbox = $(this).parent('span.hover').parent('span.post').parent('figure');
		var post_id = $(thisbox).attr('id');
		var isshown = $(thisbox).children('span.share').attr('id');
		if(isshown=='shown') {
			$(thisbox).children('span.share').fadeOut(200);
			$(thisbox).children('span.share').empty();
			$(thisbox).children('span.share').attr('id','hidden');
		} else if (isshown=='hidden') {
		$(thisbox).children('span.share').attr('id','shown');
		$(thisbox).children('span.share').append(share);
		$(thisbox).children('span.share').fadeIn(200);
		$('div.submitshare').click(function(){
			var thisbox = $(this).parent('div.share').parent('span.share').parent('figure');
			var post_id = thisbox.attr('id');
			var sharemail = thisbox.children('span.share').children('div.share').children('input.sharemail').val();
			var frommail = thisbox.children('span.share').children('div.share').children('input.frommail').val();
			$.post('share.php',{'post_id':post_id,'sharemail':sharemail,'frommail':frommail},function(data){
				var thanks = 'Message sent! Thanks for sharing!';
				$(thisbox).children('span.share').empty();
				$(thisbox).children('span.share').append(thanks);
			});
		});
		}
	});

}
hoverFunc();


	$(window).resize(function() {
	$('div.col').remove();
	 width = $('span.favorites').width();
	 numCols = Math.floor(width/270);

	for (i=1;i<=numCols;i++) {
	$('span.favorites').append($(column).attr('id',i));
	}
	for (i=0; i<numposts; i++) {
		$('div#'+div).append(fig);
		if (div<numCols) {
		div++;
		} else {
		div=1;
		}
	}
	$('figure').each(function(postcount){
		thisbox = $(this);
		curtitle = title[postcount];
		curimg = img[postcount];
		curcap = cap[postcount];
		curpost = post[postcount];
		curtags = tags[postcount];
		thisbox.attr('id',curpost);
		thisbox.children('h2').text(curtitle);
		thisbox.children('p.cap').append(curcap);
		thisbox.children('span.post').children('a').children('img').attr('src',curimg);
		thisbox.children('span.post').children('a').attr('href','resource.php?resc='+curpost+'&redir=user');
		thisbox.children('a').attr('href','resource.php?resc='+curpost+'&redir=user');
		thisbox.children('p.tags').text(curtags);
		thisbox.children('span.post').append(hover);
		thisbox.children('span.post').children('span.hover').hide();
			thisbox.children('span.notes').append(notes);

	});
	hoverFunc();
	


	});
	$('span.approve').click(function(){
		var req_id = $(this).attr('id');
		var answer = 1;
		$.post('processrequest.php',{'req_id':req_id,'answer':answer},function(data){
			alert('User approved!');
			$('span.req#'+req_id).remove();
		});
	});
	$('span.deny').click(function(){
		var req_id = $(this).attr('id');
		var answer = 0;
		$.post('processrequest.php',{'req_id':req_id,'answer':answer},function(data){
			alert('User denied. They will not be able to upload images.');
			$('span.req#'+req_id).remove();
		});
	});



});
</script>
<?php
	echo "	</head>
		<body>";
	include('logobar.php');
	$q = "SELECT mems FROM users WHERE user_id=$user_id";
	$r = @mysqli_query($dbc,$q);
	while($row=mysqli_fetch_array($r)) {
		$memsLeft = $row['mems'];
	}
	$q = "SELECT * FROM reqs WHERE own_id = $user_id";
	$r = @mysqli_query($dbc,$q);
	while($row=mysqli_fetch_array($r)) {
		$req_id[]= $row['req_id'];
		$ask[] = $row['username'];
		$memcontrib[]=$row['mem_id'];
		$msg[] = $row['msg'];
	}
	$reqNum = count($memcontrib);
	if($reqNum!=0) {
	foreach($memcontrib as $memContribId) {
		$q = "SELECT firstname, lastname FROM memfacts WHERE mem_id = $memContribId";
		$r = @mysqli_query($dbc,$q);
		while ($row=mysqli_fetch_array($r)) {
			$askFirst[]=$row['firstname'];
			$askLast[]=$row['lastname'];
		}
	}
	}
	echo "<div class='userhomeleft'>";
	echo "<section class='stats'>";
	echo "<p>Welcome $username!</p>";
	echo "<p>Memorials remaining:</p>";
	echo "<p>$memsLeft</p>";

	echo "</section>";
	echo "<section class='memorials'>";
	echo "<p>Memorials</p>";
	$q = "SELECT firstname, lastname, mem_id FROM memfacts WHERE user_id = $user_id";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$firstname = $row['firstname'];
		$lastname = $row['lastname'];
		$mem_id = $row['mem_id'];
		echo "<p><a href='memorial.php?mem_id=$mem_id' class='mem'>$firstname $lastname</a><a href='newmemorial.php?mem_id=$mem_id' class='edit'>- Edit</a></p>";
	}
	echo "<p>Contributor Requests:</p>";
	for($i=0;$i<$reqNum;$i++) {
		$thisreq = $req_id[$i];
		echo "<span class='req' id = $thisreq>";
		echo "<p class='req'>$ask[$i] wants to contribute to $askFirst[$i] $askLast[$i]'s Memorial.</p>
			<p class='req'>Message from $ask[$i]:</p>
		       <p class='reqmsg'>'$msg[$i]'</p>";
		echo "<span class='approve' id='$thisreq'>
			<p>Approve User</p>
			</span>
			<span class='deny' id='$thisreq'>
			<p>Deny User</p>
			</span>";
		echo "</span>";
	}
	echo "<a href='newmemorial.php?mem_id=0' class='newmem'>Create Memorial</a>";
	echo "<a href='purchase.php' class='newmem'>Purchase Memorials</a>";
?>	


<?php	
	echo "</section>";
	echo "</div>";
	echo "<span class='favorites'>";
	echo "</span>";
	
	
	echo "</body>
		</html>";
?>
