<?php
	session_start();
	if(!empty($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
	$loggedin = 1;
	} else {
	$loggedin = 0;
	$user_id = 0;
	}
	foreach($_SESSION['clicked'] as $click) {
		$clicked[] = $click;

	}
	include('includes/mysqli_connect.php');
	if(!empty($_GET['tag'])){
	$homeclick = $_GET['tag'];
	$homeclick = str_replace(' ','',$homeclick);
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
	//var fig = "<figure class='newFig'><h2></h2><span class='post'><a href='' class='img'><img class='post' /></a></span><br /><span class='tags'></span><p class='cap'></p><a href='' class='resc'>see more</a></figure>";
	var fig = "<figure class='newFig'><h2></h2><span class='post'><a href='' class='img'><img class='post' /></a></span><br /><span class='notes' id='hidden'></span><span class='share' id='hidden'></span><span class='tags'></span><p class='cap'></p><a href='' class='resc'>see more</a><span class='fact'></span></figure>";
	var hover = "<span class='hover'><img src='like.gif' class='hovericon' id='like' /><img src='notes.gif' class='hovericon' id='notes' /><img src='share.gif' class='hovericon' id='share' /><img src='info.gif' class='hovericon' id='info' /></span>";
	var saved = "<h3 class='saved'></h3>";
	var clicked = new Array();
	var loggedin = <?php echo $loggedin ?>;
	var user_id = <?php echo $user_id ?>;
	var savedClick = <?php echo json_encode($clicked) ?>;


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
		</nav>";


	var div = 1;
	var width = $('span.found').width();
	var numCols = Math.floor(width/270);
	var column = "<div class='col'></div>";
	for (i=1;i<=numCols;i++) {
	$('span.found').append($(column).attr('id',i));
	}
	//$('div#1').append(nav);
	var thistag;
	var hoverFunc = function () {
	$('img.hovericon').off('click');
	$('figure').off('hover');
	$('figure').hover(
		function() {
			$(this).children('span.post').children('span.hover').fadeIn(200);
	},
		function() {
			$(this).children('span.post').children('span.hover').fadeOut(200);
		});
	$('img#info').click(function(){
		var resc = $(this).parent('span.hover').parent('span.post').parent('figure').attr('id');
		window.location.href = 'resource.php?resc='+resc+'&redir=find';
	});
	$('img#like').click(function(){
		var thisbox = $(this).parent('span.hover').parent('span.post').parent('figure');
		var thispost = thisbox.attr('id');
		if (loggedin==1) {
		$.post('includes/like.php',{post_id:thispost,user_id:user_id},function(data) {
			$(thisbox).children('h3.saved').text('Resource Saved');
			$(thisbox).children('h3.saved').fadeIn(200);
			});
		} else {
			window.location.href = 'accountcreate.php';
		}
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
	};
	
	var loadPosts = function() {
		$.ajax({
			type:'GET',
			url:'includes/tagclick.php',
			data:{'thistag':thistag},
			success:function(data){
				var div = 1;
				var width = $('span.found').width();
				var numCols = Math.floor(width/270);
				var json = $.parseJSON(data);
				var newPosts = json[0];
				var newTitles = json[1];
				var newImg = json[2];
				var newCap = json[3];
				var newTags = json[4];
				if($.inArray(thistag,clicked)==-1){
				clicked.push(thistag);
				}
					for (i=0;i<newPosts.length;i++) {
					$('div#'+div).append(fig);
					if (div<numCols) {
					div++;
					} else {
					div=1;
					}
					}
					$('figure.newFig').each(function(n){
						var curpost = newPosts[n];
						var curtitle = newTitles[n];
						var curimg = newImg[n];
						var curcap = newCap[n];
						var curtags = newTags[n];
						$(this).attr('id',curpost);
						$(this).children('h2').text(curtitle);
						$(this).children('p.cap').append(curcap);
						$(this).children('span.post').children('a').children('img').attr('src',curimg);
						$(this).children('span.post').children('a').attr('href','resource.php?resc='+curpost+'&redir=find');
						$(this).children('a').attr('href','resource.php?resc='+curpost+'&redir=find');
						$(this).children('span.tags').append("<p class='tags'>"+curtags+"</p>");
						$(this).children('span.post').append(hover);
						$(this).children('span.post').children('span.hover').hide();
						$(this).append(saved);
						$(this).children('span.notes').append(notes);
						$(this).removeClass('newFig');
						$(this).addClass(thistag);
					});
				hoverFunc();

			}
		});
		};
	if(savedClick!=null) {
	for(i=0;i<savedClick.length;i++) {
		thistag = savedClick[i];
		loadPosts();
		$('p#'+thistag).css({'font-weight':'bold','color':'rgb(169,0,111)'});
		$('p#'+thistag).addClass('clicked');
	}
	}

	hoverFunc();
	$('p.findtag').click(function(){
		thistag = $(this).attr('id');
		if(!$(this).hasClass('clicked')) {
		loadPosts();
			$(this).css({'font-weight':'bold','color':'rgb(169,0,111)'});
			$(this).addClass('clicked');
		} else if ($(this).hasClass('clicked')) {
			$('figure.'+thistag).remove();
			clicked.splice($.inArray(thistag,clicked),1);
			$(this).css({'font-weight':'normal','color':'rgb(100,100,100)'});
			$(this).removeClass('clicked');
		}

	});
	var time;
	var sizeDone = function() {
	$('div.col').remove();
	var width = $('span.found').width();
	var numCols = Math.floor(width/270);
	var column = "<div class='col'></div>";
	for (i=1;i<=numCols;i++) {
	$('span.found').append($(column).attr('id',i));
	}
	for(i=0;i<clicked.length;i++){
		thistag = clicked[i];
		loadPosts();
	}

	};
	$(window).resize(function() {
		clearTimeout(time);
		time = setTimeout(sizeDone,500)
	});
	$(window).unload(function(){
		$.post('resourcehold.php',{'clicked':clicked});
	});


});
</script>
<?php

echo "</head>
<body>";
include('logobar.php');
$tags = array(
	'Art',
	'Ash Scattering',
	'Biodegradable Vessels',
	'Body Care',
	'Burial',
	'Cancer',
	'Caskets',
	'Coffins',
	'Celebrants',
	'Ceremonies',
	'Choices-for-the-Dying',
	'Conscious Death',
	'Consumer Information',
	'Cremation',
	'Death Midwives',
	'Death Rights',
	'Documentary Film',
	'Dying',
	'Dying Well',
	'Eco Coffins',
	'Eco Burial',
	'Famous Last Words',
	'Follow Up',
	'Flowers For the Dying',
	'Funeral',
	'Funeral Costs',
	'Funeral Programs',
	'Funeral Rituals',
	'Gifts',
	'Eco/Green Burial',
	'Green Burial Council',
	'Green Burial Conference',
	'Green Cemeteries',
	'Green Funerals',
	'Grief Support',
	'Headstones',
	'Historic Funeral',
	'Home Funeral',
	'Hospice',
	'In the Moment',
	'Legal',
	'Living Will',
	'Memorial Poetry',
	'Music',
	'Music Thanatology',
	'Natural Burial',
	'Obituary',
	'Obituary Writers',
	'Organizations',
	'Palliatve Care',
	'Planning Ahead',
	'Post-Death',
	'Prayer',
	'Random',
	'Religious Rites',
	'Religious Traditions',
	'Remebrance',
	'Shrouds',
	'Sympathy',
	'Thanatology',
	'Urns',
	'Video',
	'Wicker Caskets',
	'Wills',
	'World Burials'
);
	echo "<span class='findresccenter'>";
	include('includes/navmenu.php');
	echo "<section class='selecttags'>";
	echo "<h3>Resource</h3>";
	echo "<span class='foundresc'>";
	foreach($tags as $tag) {
		$tagid = str_replace(' ','',$tag);
		echo "<p class='findtag' id='$tagid'>$tag</p>";
		}
	echo "</span>";
	echo "</section>";
	echo "</span>";
	echo "<span class='found'>";
	echo "</span>";



?>
