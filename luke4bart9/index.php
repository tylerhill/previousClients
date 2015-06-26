<?php
//	include('includes/mysqli_connect.php');
//	include('translate.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8 />
<meta name='description' content='Luke Lucas is a candidate for BART District 9. No more incumbents!' />
<meta name='keywords' content='Luke Lucas, BART, Election, District 9, San Francisco, Bay Area, Bay Area Rapid Transit' />
<title>Luke Lucas for BART District 9</title>
<link rel='stylesheet' href='style.css' type='text/css' />
<script type='text/javascript' src='includes/jquery.min.js'></script>
<script type='text/javascript' src='includes/contains.js'></script>
<script type='text/javascript' src='http://maps.googleapis.com/maps/api/js?key=AIzaSyA7zBxIBoJq6xOCvkiSFuPOTYtv4wU8YJ4&sensor=false'>
<script type='text/javascript' src='http://www.google.com/jsapi'></script>
</script>
<script type='text/javascript'>
$(document).ready(function() {
		$.post('four.php',function(data){
			$('div#content').append(data);
		});
	var token = "<?php echo $accessToken ?>";
	var from='en';
	var to='es';
	var text='hello world';
	var s = document.createElement('script');
	s.src = 'http://api.microsofttranslator.com/V2/Ajax.svc/Translate'+ '?appId=Bearer '+token+'&from='+encodeURIComponent(from)+'&to='+encodeURIComponent(to)+'&text='+encodeURIComponent(text)+'&oncomplete=mycallback';
	document.body.appendChild(s);
	function mycallback(response) {
		alert(response);
	}
	var geocoder;
	var map;
	var distNine;
	function initialize() {
		geocoder = new google.maps.Geocoder();
		var mapOptions = {
			center:new google.maps.LatLng(37.754,-122.435),
			zoom:13,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);
		var polyCoords =  [
			new google.maps.LatLng(37.7214,-122.4482),
			new google.maps.LatLng(37.7283,-122.4436),
			new google.maps.LatLng(37.7283,-122.4488),
			new google.maps.LatLng(37.7330,-122.4488),
			new google.maps.LatLng(37.7331,-122.4443),
			new google.maps.LatLng(37.7345,-122.4443),
			new google.maps.LatLng(37.7346,-122.4429),
			new google.maps.LatLng(37.7362,-122.4444),
			new google.maps.LatLng(37.7395,-122.4427),
			new google.maps.LatLng(37.7469,-122.4586),
			new google.maps.LatLng(37.7538,-122.4637),
			new google.maps.LatLng(37.7603,-122.4639),
			new google.maps.LatLng(37.7598,-122.4769),
			new google.maps.LatLng(37.7713,-122.4796),
			new google.maps.LatLng(37.7731,-122.4718),
			new google.maps.LatLng(37.7758,-122.4465),
			new google.maps.LatLng(37.7785,-122.4470),
			new google.maps.LatLng(37.7794,-122.4411),
			new google.maps.LatLng(37.7821,-122.4415),
			new google.maps.LatLng(37.7827,-122.4427),
			new google.maps.LatLng(37.7876,-122.4439),
			new google.maps.LatLng(37.7904,-122.4224),
			new google.maps.LatLng(37.7956,-122.4234),
			new google.maps.LatLng(37.7964,-122.4167),
			new google.maps.LatLng(37.7939,-122.4162),
			new google.maps.LatLng(37.7947,-122.4097),
			new google.maps.LatLng(37.7920,-122.4091),
			new google.maps.LatLng(37.7927,-122.4028),
			new google.maps.LatLng(37.7887,-122.4020),
			new google.maps.LatLng(37.7866,-122.3995),
			new google.maps.LatLng(37.7871,-122.3988),
			new google.maps.LatLng(37.7838,-122.3944),
			new google.maps.LatLng(37.7749,-122.4057),
			new google.maps.LatLng(37.7650,-122.3933),
			new google.maps.LatLng(37.7500,-122.3924),
			new google.maps.LatLng(37.7493,-122.4032),
			new google.maps.LatLng(37.7351,-122.4068),
			new google.maps.LatLng(37.7241,-122.4015),
			new google.maps.LatLng(37.7235,-122.4040),
			new google.maps.LatLng(37.7209,-122.4030),
			new google.maps.LatLng(37.7192,-122.4112),
			new google.maps.LatLng(37.7237,-122.4130),
			new google.maps.LatLng(37.7230,-122.4158),
			new google.maps.LatLng(37.7222,-122.4155),
			new google.maps.LatLng(37.7221,-122.4166),
			new google.maps.LatLng(37.7228,-122.4169),
			new google.maps.LatLng(37.7226,-122.4179),
			new google.maps.LatLng(37.7237,-122.4184),
			new google.maps.LatLng(37.7234,-122.4193),
			new google.maps.LatLng(37.7246,-122.4198),
			new google.maps.LatLng(37.7236,-122.4239),
			new google.maps.LatLng(37.7157,-122.4272),
			new google.maps.LatLng(37.7166,-122.4312),
			new google.maps.LatLng(37.7132,-122.4337)
		];
		distNine = new google.maps.Polygon({
			paths:polyCoords,
			strokeColor:'#0083d3',
			strokeOpacity:0.8,
			strokeWeight: 2,
			fillColor:'#0083d8',
			fillOpacity:0.35
		});
		distNine.setMap(map);
	}
	function codeAddress() {
		var address= document.getElementById('address').value;
		geocoder.geocode({'address':address},function(results,status) {
			if(status==google.maps.GeocoderStatus.OK) {
				map.setCenter(results[0].geometry.location);
				var marker = new google.maps.Marker({
					map: map,
					position: results[0].geometry.location

				});
				var testPoint=results[0].geometry.location;
				var isWithin = distNine.containsLatLng(testPoint);
			} else {
				alert('Enter Address Above')
			}
		});
	}
	$('img#bio').click(function() {
		$('div#content').empty();
		$.post('bio.php',function(data){
			$('div#content').append(data);
		});
	});
	$('img.title').click(function(){
		$('div#content').empty();
		$.post('four.php',function(data){
			$('div#content').append(data);
		});
	});
	$('img#dist').click(function(){
		$('div#content').empty();
		$.post('dist.php',function(data){
			$('div#content').append(data);
			initialize();
			$('div#submit').click(function() {
				codeAddress();
			});
		});
	});
	$('img#donate').click(function() {
		$('div#content').empty();
		$.post('contact.php',function(data){
			$('div#content').append(data);
		});
	});
	$('img#goals').click(function() {
		$('div#content').empty();
		$.post('issues.php',function(data){
			$('div#content').append(data);
		});
	});


});
</script>
</head>
<body>
<div id='main'>
<span id='title'>
<img src='images/title.png' class='title' />
<img src='images/subtitle.png' class='title' />
</span>

<div id='content'>

</div>
<span id='languages'>
<div class='langbutt' id='eng'>
<p>English</p>
</div>
<div class='langbutt' id='esp'>
<p>Espanol</p>
</div>
<div class='langbutt' id='cn'>
<p>Chinese</p>
</div>
<div class='langbutt' id='tag'>
<p>Tagalog</p>
</div>
</span>

<span id='menu'>
<img src='images/bio.png' class='menu' id='bio'/>
<img src='images/goals.png' class='menu' id='goals'/>
<img src='images/dist.png' class='menu' id='dist'/>
<img src='images/donate.png' class='menu' id='donate'/>
</span>

</div>
</body>
</html>
