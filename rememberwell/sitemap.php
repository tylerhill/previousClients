<?php
	header('content-type:text/xml;charset=iso-8859-1');	
	echo "<?xml version='1.0' encoding='UTF-8'?>
		<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";
	include('includes/mysqli_connect.php');
	$q = "SELECT * FROM posts WHERE timestamp < CURRENT_TIMESTAMP";
	$r = @mysqli_query($dbc,$q);
	$num = mysqli_num_rows($r);
	while($row=mysqli_fetch_array($r)){
		$date[] = $row['timestamp'];
		$post[] = $row['post_id'];
	}
	for($i=0;$i<$num;$i++){
	$year = substr($date[$i],0,4);
	$mon = substr($date[$i],5,2);
	$day = substr($date[$i],8,2);
	$displaydate = ''.$year.'-'.$mon.'-'.$day.'';
	$url = "http://www.rememberwell.net/resource.php?resc=".$post[$i];
	echo "
		<url>
		<loc>$url</loc>
		<lastmod>$displaydate</lastmod>
		<changefreq>monthly</changefreq>
		</url>
		";
	}
	$q = "SELECT * FROM memfacts WHERE timestamp < CURRENT_TIMESTAMP";
	$r = @mysqli_query($dbc,$q);
	$num = mysqli_num_rows($r);
	while ($row=mysqli_fetch_array($r)) {
		$memdate[] = $row['timestamp'];
		$mem[] = $row['mem_id'];
	}
	for($i=0;$i<$num;$i++){
	$year = substr($memdate[$i],0,4);
	$mon = substr($memdate[$i],5,2);
	$day = substr($memdate[$i],8,2);
	$displaydate = ''.$year.'-'.$mon.'-'.$day.'';
	$url = "http://www.rememberwell.net/memorial.php?mem_id=".$mem[$i];
	echo "
		<url>
		<loc>$url</loc>
		<lastmod>$displaydate</lastmod>
		<changefreq>monthly</changefreq>
		</url>
		";
	}
	echo "</urlset>";

	?>
