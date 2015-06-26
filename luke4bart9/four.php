<?php
	include('includes/mysqli_connect.php');
	echo "

	<span id='intro'>
	<iframe width='640' height='360' src='http://www.youtube.com/embed/a6ONqXMGhaY' frameborder='0' allowfullscreen></iframe>
	</span>
	<div id='four'>
		<h4>Leadership</h4>
		<h4>System Reliability</h4>
		<h4>Public Safety/Wireless</h4>
		<h4>Revenue and Ridership</h4>
	</div>

	<span id='blog'>
	<div id='blog'>";
		$q = "SELECT * FROM posts ORDER BY time DESC";
		$r = @mysqli_query($dbc,$q);
		$num = mysqli_num_rows($r);
		while ($row=mysqli_fetch_array($r)) {
			$posts[] = $row['post_id'];
			$title[] = $row['title'];
			$body[] = $row['body'];
			$stamp = $row['time'];
			$year = substr($stamp,0,4);
			$mon = substr($stamp,5,2);
			$day = substr($stamp,8,2);
			$date[] = $mon . '/' . $day . '/' . $year;
		}
		for($i=0;$i<$num;$i++) {
			$clean = utf8_encode($body[$i]);
			echo "
			<div class='post' id=$posts[$i]>
			<h3 id='titlepost'>$title[$i]</h3>
			<h3 id='datepost'>$date[$i]</h3>
			<p>$clean</p>
			</div>";
		}
		echo "
</div>
</span>";
?>
