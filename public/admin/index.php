<?php require_once('../../includes/initialize.php'); ?>
<?php if(!$session->is_logged_in()){redirect("login.php");} ?>

<?php include_layout_template("admin_header.php") ;?>

	<h2>Menu</h2>
	<?php echo output_message($message) ;?>
	<ul>
		<li><a href="logfile.php">Logfile</a></li>
		<li><a href="view_photograph.php">View All Uploaded Photographs</a></li>
		<li><a href="logout.php">Logout</a></li>

<?php include_layout_template("admin_footer.php") ;?>