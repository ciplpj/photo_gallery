<?php require_once("../../includes/initialize.php") ;?>
<?php 

	if(!$session->is_logged_in()){
			redirect("login.php");
		}

	$session->logout();
	redirect("login.php"); 

?>
