<?php require_once('../../includes/initialize.php'); ?>
<?php if(!$session->is_logged_in()){redirect("login.php");} ?>
<?php
	$max_file_size = 1048576 ; 
	if(isset($_POST['submit'])){
		$photo = new Photograph();
		$photo->caption = $_POST['caption'];
		$photo->attach_file($_FILES['upload_file']);
		if($photo->save()){
			$session->set_get_message("Photograph Uploaded Successfully");
			redirect('view_photograph.php');
		}else{
			$message .= "<br />".join("<br />" , $photo->errors);
		}
	}

?>
<?php include_layout_template("admin_header.php") ;?>
<?php echo output_message($message); ?>
	<h2>Photo Upload</h2>
	<form action="photo_upload.php" enctype="multipart/form-data" method="post" >
		<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
		<p><input type="file" name="upload_file" value="" /></p>
		<p>Caption : <input type="text" name ="caption" value="" /></p>
		<p><input type="submit" name="submit" /></p>
	</form>


<?php include_layout_template("admin_footer.php") ;?>