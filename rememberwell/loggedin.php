<?php # loggedin.php 
	session_start();
	include('includes/mysqli_connect.php');

	if(!isset($_SESSION['user_id'])) {
		require_once('includes/login_functions.inc.php');
		$url=absolute_url();
		header("Location: $url");
		exit();
	}

	$page_title = 'Logged In!';
	echo "
		<!DOCTYPE html>
		<html>
			<head>
				<title>Admin Page</title>
				<link rel='stylesheet' href='style.css' type='text/css' />
			</head>
			<body>";
	echo "
		<a href='index.php' class='home'>
		<div class='home'>
		<p>Home</p>
		</div>
		</a>
		<form enctype='multipart/form-data' action='upload.php' method='POST'>
			<input type='hidden' name='max_file_size' value='524288'>
				<fieldset class='upload'><legend>Create New Post</legend>
				<div class='maintags'>
				<p><input type='checkbox' name='tags[]' class='tag' value='Planning Ahead' />Planning Ahead</p>
				<p><input type='checkbox' name='tags[]' class='tag' value='In The Moment' />In The Moment</p>
				<p><input type='checkbox' name='tags[]' class='tag' value='Follow Up' />Follow Up</p>
				</div>
				<div class='imgupload'>
				<p>Title<input type='text' name='title' /></p>
				<p>Thumbnail/Header Image</p><input type='file' name='file[]' multiple /><br />
				<p>Body Image 1</p><input type='file' name='file[]' multiple /><br />
				<p>Body Image 2</p><input type='file' name='file[]' multiple /><br />
				<p>Preview Text</p><textarea rows='10' cols='40' name='caption'></textarea><br />
				<p>Article Text</p><textarea rows='15' cols='50' name='maintext' class='article'></textarea>
				<p class='video'>Video<input type='checkbox' name='video' value=1 /></p>
				
				</div>
				<div class='tags'>
				<span class='tagcol1'>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Art' />Art</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Ash Scattering' />Ash Scattering</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Biodegradable Vessels' />Biodegradable Vessel</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Body Care' />Body Care</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Burial' />Burial</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Cancer' />Cancer</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Caskets' />Caskets</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Coffins' />Coffins</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Celebrants' />Celebrants</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Cemeteries' />Cemeteries</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Ceremonies' />Ceremonies</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Choices for the Dying' />Choices for the Dying</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Conscious Death' />Conscious Death</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Consumer Information' />Consumer Information</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Cremation' />Cremation</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Death Midwives' />Death Midwives</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Death Rights' />Death Rights</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Documentary Film' />Documentary Film</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Dying' />Dying</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Dying Well' />Dying Well</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Eco Coffins' />Eco Coffins</p>
				</span>
				<span class='tagcol2'>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Famous Last Words' />Famous Last Words</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Final Passages' />Final Passages</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Flowers' />Flowers</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='For the Dying' />For the Dying</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Funeral' />Funeral</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Funeral Costs' />Funeral Costs</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Funeral Programs' />Funeral Programs</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Funeral Rituals' />Funeral Rituals</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Gifts' />Gifts</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Green/Eco Burial' />Green/Eco Burial</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Green Burial Council' />Green Burial Council</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Green Burial Conference' />Green Burial Conference</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Green Cemeteries' />Green Cemeteries</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Green Funerals' />Green Funerals</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Grief Support' />Grief Support</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Headstones' />Headstones</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Historic Funeral' />Historic Funeral</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Home Funeral' />Home Funeral</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Hospice' />Hospice</p>
				</span>
				<span class='tagcol3'>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Legal' />Legal</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Living Will' />Living Will</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Memorial Poetry' />Memorial Poetry</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Music' />Music</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Music Thanatology' />Music Thanatology</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Natural Burial' />Natural Burial</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Obituary' />Obituary</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Obituary Writers' />Obituary Writers</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Organizations' />Organizations</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Palliative Care' />Palliative Care</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Post-Death' />Post-Death</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Prayer' />Prayer</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Random' />Random</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Religious Rites' />Religious Rites</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Religious Traditions' />Religious Traditions</p>
				</span>
				<span class='tagcol4'>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Remembrance' />Remembrance</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Shrouds' />Shrouds</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Sympathy' />Sympathy</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Thanatology' />Thanatology</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Urns' />Urns</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Video' />Video</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Wicker Coffins/Caskets' />Wicker Coffins/Caskets</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='Wills' />Wills</p>
				<p class='sub'><input type='checkbox' name='tags[]' class='tag' value='World Burials' />World Burials</p>
				</span>
				</div>
				<p>Place<br /> 
				&#60span class=&#39img1&#39 &#62<br />
					&#60&#47span&#62 
					<br />	where you want to embed the image.
					<br />
					<br />
					&#60a href=&#39&#39 target=&#39_blank&#39&#62&#60&#47a&#62 <br />	
					Place the link between the quotes after href,
					and then again between the &#60a&#62&#60&#47a&#62 tags.
					</p></fieldset>
				<span class='submit'>
			<input type='submit' name='submit' value='Submit' />
			<input type='hidden' name='submitted' value='TRUE' />
			</span><br />
		</form><br />
		<span class='posts'>
		";

	$q = "SELECT * FROM posts ORDER BY post_id DESC";
	$r= @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$post = $row['post_id'];
		$title = $row['title'];
		$img = $row['img'];
		$tags = $row['tags'];
		echo "<fieldset class='post'>";
		echo "<p>".$title."</p><form action='edit.php' method='POST'><input type='hidden' name='post_id' value=".$post." /><input type='submit' name='submit' value='Edit' /></form>";
		echo "<img src='".$img."' class='edit' /><br />";
		echo "<p class='tags'>".$tags."</p><br />";
		echo "<form action='uploads/confirm.php' method='POST'><input type='hidden' name='delpost' value=$post  class='postsend'/><input type='submit' name='submit' value=Delete /></form>";
		echo "</fieldset>";
	}
	echo "</span>";
	echo "</body>
		</html>";
?>
