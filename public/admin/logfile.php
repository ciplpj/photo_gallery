<?php require_once('../../includes/initialize.php');
	  require_once(LIB_PATH.DS."log.php"); ?>
<?php if(!$session->is_logged_in()){redirect("login.php");} 
	  if(isset($_GET['clear'])){
	  	$user_log = User::find_by_id($_SESSION['user_id']);
	  	$log->clear($user_log->username);
	  	redirect('logfile.php');
	   }
?>
<?php include_layout_template("admin_header.php") ;?>
<a href="index.php">&laquo Back</a>
<br />
<?php
	$log->read_log();
?>
<br />
<hr />
<a href="logfile.php?clear=true" onclick="return confirm('Are You Sure You Want To Clear The Log Contents');">Clear Log File </a>

<?php include_layout_template("admin_footer.php") ;?>
