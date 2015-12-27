<?php
	require_once('database.php');
	require_once('database_object.php');
	class Comment extends DatabaseObject{

		protected static $table_name = 'comment';
		protected static $db_fields = array('id','photograph_id','author', 'created' , 'body');
		public $id;
		public $photograph_id;
		public $author;
		public $created;
		public $body;


	  static public function table_name(){
	  	 return self::$table_name;
	   }

	  public static function make($photo_id,$author="Anonymous",$body=""){
	  	 if(!empty($photo_id) || !empty($author) || !!empty($body)){
	  		$comment = new Comment();
	  		$comment->photograph_id = (int) $photo_id;
	  		$comment->author = $author;
	  		$comment->body = $body;
	  		$comment->created = strftime("%Y-%m-%d %H:%M:%S");
	  		return $comment;
	  	 }else{
	  		return false;	
	  	 }
	  }

	  public static function find_comments_on($photo_id = 0){
	  		global $database;
	  		$query = "SELECT * FROM ".static::$table_name;
	  		$query .=" WHERE photograph_id =".$database->escape_value($photo_id);
	  		$query .=" ORDER BY created ASC ;";
	  		return static::find_by_sql($query);
	  }

	  public function save(){
		 if(isset($this->id)){
			return $this->update();
		 }else{
		 	return $this->create();
		 }
		}
	}
?>