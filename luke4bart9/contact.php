<?php
	include('includes/mysqli_connect.php');
echo "
	<span id='contTitle'>
	<h1>Contact Information</h1>
	</span>
	<div id='bio'>
		<ul>
		<h3>Luke Lucas</h3><br />
		<h3>BART District 9 Candidate</h3>
		<h4>2261 Market Street, Suite 1000<br />
		San Francisco, CA 94114</h4>
		<h4>(415) 612-6000</h4>
		<h4>email: LukeLucas4BART@gmail.com</h4>
		</ul>
		<span id='button'>
		<h3>Support the Campaign!</h3>
		<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>
		<input type='hidden' name='cmd' value='_s-xclick'>
		<input type='hidden' name='hosted_button_id' value='2HUDG7XJ2RLGC'>
		<input type='image' src='https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif' border='0' name='submit' alt='PayPal - The safer, easier way to pay online!'>
		<img alt='' border='0' src='https://www.paypalobjects.com/en_US/i/scr/pixel.gif' width='1' height='1'>
		</form>
		</span>	
		<span class='img'>
		<img src='images/bart-sign.jpg' />
		</span>
		</div>";

?>
