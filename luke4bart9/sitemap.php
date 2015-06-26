<?php
	header('content-type:text/xml;charset=UTF-8');
	echo "<?xml version='1.0' encoding='UTF-8'?>
		<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";
	include('includes/mysqli_connect.php');
	$q = "SELECT time FROM posts ORDER BY time DESC";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$date = $row['time'];
	}
	$year = substr($date,0,4);
	$mon = substr($date,5,2);
	$day = substr($date,8,2);
	$displaydate = ''.$year.'-'.$mon.'-'.$day.'';
	echo "
		<url>
		<loc>http://lukelucas4bart.com</loc>
		<lastmod>$displaydate</lastmod>
		<changefreq>daily</changefreq>
		</url>
		</urlset>";
?>
