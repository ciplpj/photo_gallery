<?php require_once('../../includes/initialize.php'); ?>
<?php
	if(empty($_GET['id'])){
		$session->set_get_message("No Photograph ID was Provided");
		redirect('view_photograph.php');
	}

	$photo = Photograph::find_by_id($_GET['id']);
	if(!$photo){
		$session->set_get_message("The Photo Could Not Be Located");
		redirect('index.php');
	}

	$comments =$photo->comment();
?>
<?php include_layout_template('admin_header.php'); ?>

<a href="view_photograph.php">&laquo; Back </a>
<br />
<br />
<h2>Comments on <?php echo $photo->filename; ?> </h2>
<?php echo output_message($message); ?>
  <div id="comments">
  	<?php foreach($comments as $comment) : ?>
  		<div class="comment" style="margin-bottom: 2em;">
  			<div class="author">
  				<?php echo htmlentities($comment->author) ;?> wrote:
  			</div>
  			<div class="body">
  				<?php echo strip_tags($comment->body,"<strong><em><p>"); ?>
  			</div>
  			<div class="meta-info" style="font-size:0.8em;" >
  				<?php echo datetime_to_text($comment->created) ;?>
  			</div>
  			<div style="color:red;">
  				<a href="delete_comment.php?commentid=<?php echo $comment->id ; ?>">Delete Comment</a>
  			</div>
  			<hr />
  		</div>
  	<?php endforeach; ?>
  	<?php if(empty($comments)) {echo "No Comments" ; } ?>
  </div>
</div>

<?php include_layout_template('footer.php'); ?>
