<?php require_once('../includes/initialize.php'); ?>

<?php include_layout_template("header.php") ;?>
<?php
	
	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

	$record_no = 3;

	$total_records = Photograph::count();

	// $photo_object = new Photograph();
	// $photos = $photo_object->find_all();

	$pagination = New Pagination($page,$record_no,$total_records);

	$sql_query = "SELECT * FROM photograph ";
	$sql_query .="LIMIT {$record_no} ";
	$sql_query .="OFFSET {$pagination->offset()} ";
	$photos = Photograph::find_by_sql($sql_query);
?>
	<h2>Photos</h2>
	<?php echo output_message($session->set_get_message()); ?>
		<?php foreach($photos as $photo) : ?>
		   <div style="float:left;margin-left: 20px; display:inline;">
		   	<a href="photo.php?id=<?php echo $photo->id; ?>">
		   		<img src="<?php echo $photo->image_path(); ?>" width="200"  />
		   	</a>
		   	<p><?php echo $photo->caption; ?></p>
		   </div>
		<?php endforeach; ?>


<!-- <table class="bordered">
			<tr>
				<th>S.No.</th>
				<th>Photograph</th>
				<th>Caption</th>
				<th>Photograph Name</th>
				<th>Type</th>
				<th>Size</th>
			</tr>
			<?php
				$sno =0;
				foreach ($photos as $photo) {
					$sno ++;
					echo "<tr>";
					echo "<td>".$sno."</td>";
					echo "<td><a href=\"".$photo->image_path()." \" ><img width=\"100\" height = \" 100\"src=\"".$photo->image_path()."\" /></a></td>";
					echo "<td>".$photo->caption."</td>";
					echo "<td>".$photo->filename."</td>";
					echo "<td>".$photo->type."</td>";
					echo "<td>".$photo->size_as_text()."</td>";
					echo "</tr>";
				}
			?>
</table> -->


		<div id="pagination" style="clear:both;">
			<?php
				if($pagination->total_pages() > 1){

					if($pagination->has_prev_page()){
						echo" <a href=\"index.php?page=".$pagination->previous_page()."\">previous &laquo;</a>";
					}
					for($i=1;$i<=$pagination->total_pages();$i++){
						if($i == $page){
							echo "<span class=\"selected\" >".$i."</span>";
						}else{
							echo "<a href=\"index.php?page=".$i."\">".$i."</a>";
						}
					}
					if($pagination->has_next_page()){
						echo" <a href=\"index.php?page=".$pagination->next_page()."\">Next &raquo;</a>";
					}
				}

			?>
		<br />
		<br />
		<hr />
		<a href="admin/login.php">&raquo Upload A New Photograph</a>
		<hr />
		<a href="index.php">&laquo Back</a>
		</div>
<?php include_layout_template("admin_footer.php") ;?>
