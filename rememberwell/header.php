<!DOCTYPE html>
<html>
<head>
<title>Remember Well</title>
<meta name="description" content="Online memorials and end-of-life resources for a conscious transition" />
<link rel='stylesheet' href='style.css' type='text/css' />
<?php
	if(isset($_SESSION['user_id'])) {
		$loggedin = 'true';
		$user_id = $_SESSION['user_id'];
	} else {
		$loggedin = 'false';
		$user_id = 0;
	}
	include('includes/mysqli_connect.php');
	$start=0;
	$q = "SELECT * FROM posts ORDER BY post_id DESC";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$newcap = $row['caption'];
		$cap[] = str_replace("\\","",$newcap);
		$img[] = $row['img'];
		$post[] = $row['post_id'];
		$title[] = $row['title'];
		$tags[] = $row['tags'];
	}
	$q = "SELECT mem_id, imgsrc FROM memimgs WHERE profile=1 ORDER BY mem_id DESC";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$mem_id[] = $row['mem_id'];
		$imgsrc[] = $row['imgsrc'];
	}
	foreach ($mem_id as $curmem) {

		$q = "SELECT firstname, lastname, birthdate, deathdate FROM memfacts WHERE mem_id = $curmem ORDER BY mem_id";
		$r = @mysqli_query($dbc,$q);
		while ($row=mysqli_fetch_array($r)) {
			$firstname[] = $row['firstname'];
			$lastname[] = $row['lastname'];
			$birthdate[] = $row['birthdate'];
			$deathdate[] = $row['deathdate'];
	}
	}
	$q = "SELECT COUNT(post_id) FROM posts";
	$r = @mysqli_query($dbc,$q);
	while ($row =mysqli_fetch_array($r)) {
		$numposts = $row[0];
	}
	$q = "SELECT COUNT(mem_id) FROM memimgs WHERE profile = 1";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$numMems = $row[0];
	}
	$num = $numposts + $numMems;

			?>
<script src='includes/jquery.min.js' type='text/javascript'></script>

<script>
$(document).ready(function(){
	var width = $(window).width();
	var numCols = Math.floor(width/270);
	var column = "<div class='col'></div>";
	for (i=1;i<=numCols;i++) {
	$('body').append($(column).attr('id',i));
	}
	var face = "<figure class='face'><h2>Discover Happenings</h2><div class='fb-like-box' data-href='https://www.facebook.com/RememberWell' data-width='250' data-show-faces='true' data-border-color='#FFFFFF' data-stream='true' data-header='false'></div></figure>"
	$('div#'+numCols).append(face);
	face = $('figure.face');

	var loggedin = <?php echo $loggedin; ?>;
	var user_id = <?php echo $user_id; ?>;

	var i = 0;
	var div = 1;
	var num = <?php echo $num; ?>;
	var numposts = <?php echo $numposts; ?>;
	var numMems = <?php echo $numMems; ?>;
//	var caps = <?php echo json_encode($cap); ?>;
	var src = <?php echo json_encode($img); ?>;
	var post = <?php echo json_encode($post); ?>;
//	var title = <?php echo json_encode($title); ?>;
	var tags = <?php echo json_encode($tags); ?>;
	var mem_id = <?php echo json_encode($mem_id); ?>;
	var firstname = <?php echo json_encode($firstname); ?>;	
	var lastname = <?php echo json_encode($lastname); ?>;
	var birthdate = <?php echo json_encode($birthdate); ?>;
	var deathdate = <?php echo json_encode($deathdate); ?>;
	var profpic = <?php echo json_encode($imgsrc); ?>;
	var fig = "<figure><h2></h2><span class='post'><a href='' class='img'><img class='post' /></a></span><br /><span class='notes' id='hidden'></span><span class='share' id='hidden'></span><span class='tags'></span><p class='cap'></p><a href='' class='resc'>see more</a><span class='fact'></span></figure>";
	var memcount = 0;
	var postcount = 0;

	var hover = "<span class='hover'><img src='like.gif' class='hovericon' id='like' /><img src='notes.gif' class='hovericon' id='notes' /><img src='share.gif' class='hovericon' id='share' /><img src='info.gif' class='hovericon' id='info' /></span>";
	var saved = "<h3 class='saved'></h3>";
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

	var nav = "<nav>\
		<h4>What would you like to do?</h4>\
		<a href='findresources.php'>Find Resources</a><br />\
		<a href='newmemorial.php?mem_id=0'>Commemorate a Loved One</a><br />\
		<a href='happenings.php'>Discover Happenings</a><br />\
		<a href='about.php'>About</a><br />\
		<span class='social'>\
		<a href='https://www.facebook.com/RememberWell' target='_blank'>\
		<img src='faceicon.jpg' class='social' />\
		</a>\
		<a href='http://www.linkedin.com/profile/view?id=13796028&trk=tab_pro' target='_blank'>\
		<img src='linkedicon.jpg' class='social' />\
		</a>\
		<a href='https://plus.google.com/105392463603909325675/posts?hl=en' target='_blank'>\
		<img src='googicon.jpg' class='social' />\
		</a>\
		<a href='https://twitter.com/#!/RememberWell' target='_blank'>\
		<img src='twiticon.jpg' class='social' />\
		</a>\
		</span>\
		<p class='disclaimer'>If you are the rightful owner of any image appearing on this site and object to its use, contact <a href='mailto:rememberwell@gmail.com'>rememberwell@gmail.com</a>, and the image will be removed immediately.</p>\
		</nav>";
	$('div#1').append(nav);
	for (i=0; i<15; i++) {
		$('div#'+div).append(fig);
		if (div<numCols) {
		div++;
		} else {
		div=1;
		}
	}
		$('figure').each(function(i) {
			var thisbox = $(this);
			var thisclass = $(this).attr('class');
			if(thisclass!='face') {

			if (i%5==0 && memcount<numMems) {

				var curmem = mem_id[memcount];
				var curfirst = firstname[memcount];
				var curlast = lastname[memcount];
				var curbirth = birthdate[memcount];
				var curdeath = deathdate[memcount];
				var curprofpic = profpic[memcount];
				thisbox.attr('id',curmem);
				thisbox.children('span.post').children('a.img').children('img').attr('src', curprofpic);
				thisbox.children('p.cap').append(curbirth + " - " + curdeath);
				thisbox.children('span.post').children('a.img').attr('href','memorial.php?mem_id='+curmem);
				thisbox.children('a.resc').attr('href','memorial.php?mem_id='+curmem);
				thisbox.children('h2').append(curfirst + " " + curlast);
				memcount++;
			} else if (postcount<numposts) {
			var curpost = post[postcount];
			var cursrc = src[postcount];
			var curcap = caps[postcount];
			var curtitle = title[postcount];
			var curtags = tags[postcount];
			var taglist = curtags.split(', ');
			thisbox.attr('id', curpost);
			thisbox.children('span.post').children('a.img').children('img').attr('src', cursrc);
			thisbox.children('p.cap').append(curcap);
			thisbox.children('span.post').children('a').attr('href','resource.php?resc='+curpost);
			thisbox.children('a').attr('href','resource.php?resc='+curpost);
			thisbox.children('h2').text(curtitle);
			for (t=0;t<taglist.length;t++) {
				if(taglist[t]){
				var taglink = "<a href='findresources.php?tag="+taglist[t]+"' class='tag'>"+taglist[t]+", </a>";
				thisbox.children('span.tags').append(taglink);
				}
			}
			postcount++;
			}
			$(this).children('span.post').append(hover);
			$(this).children('span.post').children('span.hover').hide();
			$(this).append(saved);
			thisbox.children('span.notes').append(notes);
			}
		});
var hoverFunc = function() {
	$('figure').hover(
		function() {
			$(this).children('span.post').children('span.hover').fadeIn(200);
	},
		function() {
			$(this).children('span.post').children('span.hover').fadeOut(200);
		});

	$('img#like').click(function(){
		var thisbox = $(this).parent('span.hover').parent('span.post').parent('figure');
		var thispost = thisbox.attr('id');
		if (loggedin==true) {
		$.post('includes/like.php',{post_id:thispost,user_id:user_id},function(data) {
			$(thisbox).children('h3.saved').text('Resource Saved');
			$(thisbox).children('h3.saved').fadeIn(200);
			});
		} else {
			window.location.href = 'accountcreate.php';
		}
	});
	$('img#info').click(function(){
		var resc = $(this).parent('span.hover').parent('span.post').parent('figure').attr('id');
		window.location.href = 'resource.php?resc='+resc;
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
			$('figure#'+post_id).children('span.notes').children('div.notes').children('p').remove();
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
				var thanks = '<p>Message sent! Thanks for sharing!</p>';
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
		div = 1;
		postcount=0;
		memcount=0;
		width = $(window).width();
		numCols = Math.floor(width/270);
		column = "<div class='col'></div>";
		for (i=1;i<=numCols;i++) {
		$('body').append($(column).attr('id',i));
		}
		$('div#1').append(nav);
		$('div#'+numCols).append(face);


			for (i=0; i<15; i++) {
			if (i%5==0 && memcount<numMems) {
				$('div#'+div).append($(fig).addClass('current'));
				var curmem = mem_id[memcount];
				var curfirst = firstname[memcount];
				var curlast = lastname[memcount];
				var curbirth = birthdate[memcount];
				var curdeath = deathdate[memcount];
				var curprofpic = profpic[memcount];
				$('figure.current').attr('id',curmem);
				$('figure.current').children('span.post').children('a.img').children('img').attr('src', curprofpic);
				$('figure.current').children('p.cap').append(curbirth + " - " + curdeath);
				$('figure.current').children('span.post').children('a.img').attr('href','memorial.php?mem_id='+curmem);
				$('figure.current').children('a.resc').attr('href','memorial.php?mem_id='+curmem);
				$('figure.current').children('h2').append(curfirst + " " + curlast);
				$('figure.current').children('span.post').append(hover);
				$('figure.current').children('span.post').children('span.hover').hide();
				$('figure.current').append(saved);
				$('figure.current').removeClass('current');
				memcount++;
			} else if (postcount<numposts) {
			$('div#'+div).append($(fig).addClass('current'));
			var curpost = post[postcount];
			var cursrc = src[postcount];
			var curcap = caps[postcount];
			var curtitle = title[postcount];
			var curtags = tags[postcount];
			var taglist = curtags.split(', ');
			$('figure.current').attr('id', curpost);
			$('figure.current').children('span.post').children('a.img').children('img').attr('src', cursrc);
			$('figure.current').children('p.cap').append(curcap);
			$('figure.current').children('span.post').children('a').attr('href','resource.php?resc='+curpost);
			$('figure.current').children('a').attr('href','resource.php?resc='+curpost);
			$('figure.current').children('h2').text(curtitle);
			for (t=0;t<taglist.length;t++) {
				if(taglist[t]){
				var taglink = "<a href='findresources.php?tag="+taglist[t]+"' class='tag'>"+taglist[t]+", </a>";
				$('figure.current').children('span.tags').append(taglink);
				}
			}	
			$('figure.current').children('p.tags').text(curtags);
			$('figure.current').children('span.post').append(hover);
			$('figure.current').children('span.post').children('span.hover').hide();
			$('figure.current').append(saved);
			$('figure.current').children('span.notes').append(notes);
			$('figure.current').removeClass('current');
			postcount++;
			}
			
				if (div<numCols) {
				div++;
				} else {
				div=1;
				}
			}



	hoverFunc();
	});
		var loader = 0;
	$(window).scroll(function(){
		if($(document).scrollTop() == $(document).height() - $(window).height()) {
			for (i=0; i<15; i++) {
			if (i%5==0 && memcount<numMems) {
				$('div#'+div).append($(fig).addClass('current'));
				var curmem = mem_id[memcount];
				var curfirst = firstname[memcount];
				var curlast = lastname[memcount];
				var curbirth = birthdate[memcount];
				var curdeath = deathdate[memcount];
				var curprofpic = profpic[memcount];
				$('figure.current').attr('id',curmem);
				$('figure.current').children('span.post').children('a.img').children('img').attr('src', curprofpic);
				$('figure.current').children('p.cap').append(curbirth + " - " + curdeath);
				$('figure.current').children('span.post').children('a.img').attr('href','memorial.php?mem_id='+curmem);
				$('figure.current').children('a.resc').attr('href','memorial.php?mem_id='+curmem);
				$('figure.current').children('h2').append(curfirst + " " + curlast);
				$('figure.current').children('span.post').append(hover);
				$('figure.current').children('span.post').children('span.hover').hide();
				$('figure.current').append(saved);
				$('figure.current').removeClass('current');
				memcount++;
			} else if (postcount<numposts) {
			$('div#'+div).append($(fig).addClass('current'));
			var curpost = post[postcount];
			var cursrc = src[postcount];
			var curcap = caps[postcount];
			var curtitle = title[postcount];
			var curtags = tags[postcount];
			var taglist = curtags.split(', ');
			$('figure.current').attr('id', curpost);
			$('figure.current').children('span.post').children('a.img').children('img').attr('src', cursrc);
			$('figure.current').children('p.cap').append(curcap);
			$('figure.current').children('span.post').children('a').attr('href','resource.php?resc='+curpost);
			$('figure.current').children('a').attr('href','resource.php?resc='+curpost);
			$('figure.current').children('h2').text(curtitle);
			for (t=0;t<taglist.length;t++) {
				if(taglist[t]){
				var taglink = "<a href='findresources.php?tag="+taglist[t]+"' class='tag'>"+taglist[t]+", </a>";
				$('figure.current').children('span.tags').append(taglink);
				}
			}
			$('figure.current').children('p.tags').text(curtags);
			$('figure.current').children('span.post').append(hover);
			$('figure.current').children('span.post').children('span.hover').hide();
			$('figure.current').append(saved);
			$('figure.current').children('span.notes').append(notes);
			$('figure.current').removeClass('current');
			postcount++;
			}
			
				if (div<numCols) {
				div++;
				} else {
				div=1;
				}
			}

	

	$('img.hovericon').off('click');	
	$('figure').off('hover');	
	$('div.submitnote').off('click');
	hoverFunc();
		}
		if($(document).scrollTop() == $(document).height() - $(window).height() - 1) {
			for (i=0; i<15; i++) {
			if (i%5==0 && memcount<numMems) {
				$('div#'+div).append($(fig).addClass('current'));
				var curmem = mem_id[memcount];
				var curfirst = firstname[memcount];
				var curlast = lastname[memcount];
				var curbirth = birthdate[memcount];
				var curdeath = deathdate[memcount];
				var curprofpic = profpic[memcount];
				$('figure.current').attr('id',curmem);
				$('figure.current').children('span.post').children('a.img').children('img').attr('src', curprofpic);
				$('figure.current').children('p.cap').append(curbirth + " - " + curdeath);
				$('figure.current').children('span.post').children('a.img').attr('href','memorial.php?mem_id='+curmem);
				$('figure.current').children('a.resc').attr('href','memorial.php?mem_id='+curmem);
				$('figure.current').children('h2').append(curfirst + " " + curlast);
				$('figure.current').children('span.post').append(hover);
				$('figure.current').children('span.post').children('span.hover').hide();
				$('figure.current').append(saved);
				$('figure.current').removeClass('current');
				memcount++;
			} else if (postcount<numposts) {
			$('div#'+div).append($(fig).addClass('current'));
			var curpost = post[postcount];
			var cursrc = src[postcount];
			var curcap = caps[postcount];
			var curtitle = title[postcount];
			var curtags = tags[postcount];
			var taglist = curtags.split(', ');
			$('figure.current').attr('id', curpost);
			$('figure.current').children('span.post').children('a.img').children('img').attr('src', cursrc);
			$('figure.current').children('p.cap').append(curcap);
			$('figure.current').children('span.post').children('a').attr('href','resource.php?resc='+curpost);
			$('figure.current').children('a').attr('href','resource.php?resc='+curpost);
			$('figure.current').children('h2').text(curtitle);
			$('figure.current').children('p.tags').text(curtags);
			for (t=0;t<taglist.length;t++) {
				if(taglist[t]){
				var taglink = "<a href='findresources.php?tag="+taglist[t]+"' class='tag'>"+taglist[t]+", </a>";
				$('figure.current').children('span.tags').append(taglink);
				}
			}
			$('figure.current').children('span.post').append(hover);
			$('figure.current').children('span.post').children('span.hover').hide();
			$('figure.current').append(saved);
			$('figure.current').children('span.notes').append(notes);
			$('figure.current').removeClass('current');
			postcount++;
			}
				if (div<numCols) {
				div++;
				} else {
				div=1;
				}
			}

	$('img.hovericon').off('click');	
	$('figure').off('hover');	
	$('div.submitnote').off('click');
	hoverFunc();
		}
	


	});
});
</script>
<!-- Start of StatCounter Code for Dreamweaver -->
<script type="text/javascript">
var sc_project=7841302; 
var sc_invisible=1; 
var sc_security="8bad12d0"; 
</script>
<script type="text/javascript"
src="http://www.statcounter.com/counter/counter.js"></script>
<noscript><div class="statcounter"><a title="counter for
tumblr" href="http://statcounter.com/tumblr/"
target="_blank"><img class="statcounter"
src="http://c.statcounter.com/7841302/0/8bad12d0/1/"
alt="counter for tumblr"></a></div></noscript>
<!-- End of StatCounter Code for Dreamweaver -->
</head>
<body>
<div id="fb-root"></div>
	<script>
	(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	</script>
<?php
	include('logobar.php');
?>
</body>
</html>

