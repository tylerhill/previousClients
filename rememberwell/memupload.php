<?php 
	include('includes/mysqli_connect.php');
	$mem_id = $_POST['mem_id'];
//	$form = $_POST['form'];
//	$bio = $_POST['bio'];
//	$formdata=array();
//	parse_str($form,$formdata);
	if(!is_dir("uploads/memorials/$mem_id")){
	mkdir("uploads/memorials/$mem_id");
	chmod("uploads/memorials/$mem_id",0775);
	}
	$filecount=0;
	foreach ($_FILES['file']['name'] as $filename) {
		if ($tmp = $_FILES['file']['tmp_name'][$filecount]) {
			$uploaddir = "uploads/memorials/$mem_id/";
			$uploadfile = $uploaddir . basename($_FILES['file']['name'][$filecount]);
			move_uploaded_file($tmp,$uploadfile);
			chmod($uploadfile,0644);
			$q = "INSERT INTO memimgs (mem_id,imgsrc) VALUES ('$mem_id','$uploadfile')";
			$r = @mysqli_query($dbc,$q);
			$filecount++;
		}
	}
	header("Location:newmemorial.php?mem_id=$mem_id");
?>
