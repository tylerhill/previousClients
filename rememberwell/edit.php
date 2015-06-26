<?php 
	
	include('includes/mysqli_connect.php');
	if (!empty($_POST['post_id'])) {
	$current = $_POST['post_id'];
	} else {
		$current = $_GET['post'];
	}

	$q = "SELECT * FROM posts WHERE post_id=$current";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$title = $row['title'];
		$post =$row['post_id'];
		$thumb =$row['img'];
		$cap = $row['caption'];
		$tags = $row['tags'];
	}
	$curtags = explode(", ",$tags);
	echo "
		<html>
		<head>
		<title>Admin Page</title>
		<link rel='stylesheet' href='style.css' type='text/css' />
		<script src='includes/jquery.min.js' type='text/javascript'></script>";
?>
<script>
$(document).ready(function(){
	var curtags = <?php echo json_encode($curtags) ?>;
	for(i=0;i<curtags.length;i++) {
		$('input.tag').each(function(){
		var thistag = $(this);
		var tagname = $(this).val();
		if(tagname==curtags[i]){
			thistag.prop('checked',true);
		}
		});
	}
	var tags = [];
	var post = <?php echo $current ?>;
	$('div.editsave').click(function(){
		$('input:checked').each(function(){
			var thistag = $(this).val();
			tags.push(thistag);
		});
		var form = $('form.edit').serialize();
		$.ajax({
			type:'GET',
			url:'update.php',
			data:{'tags':tags,'post':post,'form':form},
			success:function(data){
				window.location.replace('edit.php?post='+post);
			}
		});	

	});
});
</script>
<?php
	echo "</head>
		<body>";
	echo "<a href='loggedin.php'>Back</a>";
	
	$q = "SELECT * FROM content WHERE post_id=$current";
	$r = @mysqli_query($dbc,$q);
	while ($row=mysqli_fetch_array($r)) {
		$maintext = $row['maintext'];
	}
	$maintext = str_replace("<br />","",$maintext);
	$maintext = str_replace("\\","",$maintext);
	$cap = str_replace("\\","",$cap);
	echo "<fieldset class='edit'>";
	echo "<div class='edittext'>";
	echo "
		<form action='update.php' method='POST' class='edit'>
		<p>Title</p>
		<input type='text' name='title' value='$title' />";
	echo "<p>Preview Text</p>
		<textarea type='text' name='caption' cols='30' rows='20'>$cap</textarea>";
	echo "<p>Article Text</p>
		<textarea rows='15' cols='50' name='maintext'>$maintext</textarea><p class='maincap'>Place<br /> 
											&#60span class=&#39img1&#39 &#62<br />
											&#60&#47span&#62 
											<br />	where you want to embed the image.
											<br />
											<br />
											&#60a href=&#39 &#39 target=&#39_blank&#39&#62&#60&#47a&#62 <br />	
											Place the link between the quotes after href,
											and then again between the &#60a&#62&#60&#47a&#62 tags.
											</p> 
	</form>
	<p class='tags'>Tags: ".$tags."</p><br />
	</div>";	
	echo "
				<div class='edittags'>
			<div class='editmaintags'>
				<p><input type='checkbox' name='tags[]' class='tag' value='Planning Ahead' />Planning Ahead</p>
				<p><input type='checkbox' name='tags[]' class='tag' value='In The Moment' />In The Moment</p>
				<p><input type='checkbox' name='tags[]' class='tag' value='Follow Up' />Follow Up</p>
				</div>
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
				<div class='editsave'>
				<p>Save Changes</p>
				</div>
				<div class='editimgupload'>
				<form enctype='multipart/form-data' action='uploads/multiload.php' method='POST'>
 		<p>Article Images</p><br />
		<p>Thumb/Header Image</p><input type='file' name='file[]' multiple /><br />
		<img src='$thumb' />
		<p>Body Image 1</p><input type='file' name='file[]' multiple /><br />
		<p>Body Image 2</p><input type='file' name='file[]' multiple /><br />
		<input type='hidden' name='post' value='$post' />
		<input type='submit' name='submit' value='Submit'/>
		</form>
		</div>
		</body>
		</html>";
	
?>
