<?php require_once('../../includes/initialize.php'); ?>
<?php if(!$session->is_logged_in()){redirect("login.php");} ?>
<?php
	if(empty($_GET['id'])){
		$session->set_get_message("Photo's Id Not Selected");
		redirect('index.php');
	}

	$photo = Photograph::find_by_id($database->escape_value($_GET['id']));
	if($photo && $photo->destroy()){
		$session->set_get_message("Photograph {$photo->filename} Deleted Successfully");
		redirect('view_photograph.php');
	}else{
		$session->set_get_message("Photograph Couldn't Be Deleted");
		redirect('view_photograph.php');
	}
?>
