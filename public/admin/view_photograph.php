<?php require_once('../../includes/initialize.php'); ?>
<?php if(!$session->is_logged_in()){redirect("login.php");} ?>
<?php
	
	$page = isset($_GET['page']) ? $_GET['page'] :1;
	$records = 3;
	$total_records = Photograph::count();
	$pagination = new Pagination($page,$records,$total_records);

	$query = "SELECT * FROM photograph ";
	$query .="LIMIT {$records}";
	$query .=" OFFSET {$pagination->offset()}";

	$photos = Photograph::find_by_sql($query);

	// $photo_object = new Photograph();
	// $photos = $photo_object->find_all();
?>
<?php include_layout_template("admin_header.php") ;?>

	<h2>Uploaded Photos</h2>
		<?php echo output_message($message) ; ?>
		<table class="bordered">
			<tr>
				<th>S.No.</th>
				<th>Photograph</th>
				<th>Caption</th>
				<th>Photograph Name</th>
				<th>Type</th>
				<th>Size</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>
			<?php
				$sno =0;
				foreach ($photos as $photo) {
					$sno ++;
					echo "<tr>";
					echo "<td>".$sno."</td>";
					echo "<td><a href=\"../".$photo->image_path()." \" ><img width=\"100\" height = \" 100\"src=\"../".$photo->image_path()."\" /></a></td>";
					echo "<td>".$photo->caption."</td>";
					echo "<td>".$photo->filename."</td>";
					echo "<td>".$photo->type."</td>";
					echo "<td>".$photo->size_as_text()."</td>";
					echo "<td><a href=\"delete_photo.php?id=".$photo->id."\">Delete</a></td>";
					echo "<td><a href=\"photo_comment.php?id=".$photo->id."\">View All ".count($photo->comment())." Comments"."</td>";
					echo "</tr>";
				}
			?>
		</table>
		<div id="pagination">
			<?php
				if($pagination->total_pages() > 1){

					if($pagination->has_prev_page()){
						echo" <a href=\"view_photograph.php?page=".$pagination->previous_page()."\">previous &laquo;</a>";
					}
					for($i=1;$i<=$pagination->total_pages();$i++){
						if($i == $page){
							echo "<span class=\"selected\" >".$i."</span>";
						}else{
							echo "<a href=\"view_photograph.php?page=".$i."\">".$i."</a>";
						}
					}
					if($pagination->has_next_page()){
						echo" <a href=\"view_photograph.php?page=".$pagination->next_page()."\">Next &raquo;</a>";
					}
				}
			?>

		</div>
		<br />
		<a href="photo_upload.php">&raquo Upload A New Photograph</a>
		<hr />
		<br />
		<a href="index.php">&laquo Back</a>
<?php include_layout_template("admin_footer.php") ;?>
