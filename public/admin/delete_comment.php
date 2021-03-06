<?php require_once('../../includes/initialize.php'); ?>
<?php if(!$session->is_logged_in()){redirect("login.php");} ?>
<?php

if(!isset($_GET['commentid'])){
	redirect('index.php');
}

if($comment = Comment::find_by_id($_GET['commentid'])){	
	if($comment && $comment->delete()){
		$session->set_get_message('Comment Was Deleted Successfully');
		redirect("photo_comment.php?commentid={$comment->photograph_id}");
	}else{
		$session->set_get_message('Comment Was Not Deleted');
		redirect('view_photograph.php');
	}
}

