<?php require_once('../includes/initialize.php'); ?>
<?php
	if(empty($_GET['id'])){
		$session->set_get_message("No Photograph ID was Provided");
		redirect('index.php');
	}

	$photo = Photograph::find_by_id($_GET['id']);
	if(!$photo){
		$session->set_get_message("The Photo Could Not Be Located");
		redirect('index.php');
	}

	if(isset($_POST['submit'])){
			$author = trim($_POST['author']);
			$body = trim($_POST['body']);
			$comment = Comment::make($_GET['id'],$author,$body);
			if( $comment && $comment->save())
			{
				//comment saved
				//as comment will be shown so no new method needed;
				redirect("photo.php?id={$photo->id}");
			}else{
				$message = "There Was An Error Saving The Comment";
			}
	}else{
		$author = "";
		$body ="";
	}

	$comments =$photo->comment();
?>
<?php include_layout_template('header.php'); ?>

<a href="index.php">&laquo; Back </a>
<br />
<br />

<div style="margin-left: 20px;">
	<img src="<?php echo $photo->image_path(); ?>" />
	<p><?php echo $photo->caption; ?></p>
</div>


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
  		</div>
  	<?php endforeach; ?>
  	<?php if(empty($comments)) {echo "No Comments" ; } ?>
  </div>

  <div class="comment-form">
	<h3> New Comment </h3>
		<?php output_message($message) ;?>
		<form action="photo.php?id=<?php echo $photo->id ; ?>" method="post">
			<table>
			<tbody>
				<tr>
					<td>Your Name:</td>
					<td> <input type="text" name="author" value="<?php echo $author; ?>" /></td>
				</tr>
				<tr>
					<td>Your Comment : </td>
					<td><textarea name="body" cols="40" rows="8"><?php echo $body; ?></textarea></td>
				</tr>
				<tr>
					<td>$nbsp;</td>
					<td><input type="submit" name="submit" /></td>
				</tr>
			</tbody>
		 	</table>
		</form>
</div>

<?php include_layout_template('footer.php'); ?>
