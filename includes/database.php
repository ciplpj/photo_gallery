<?php
require_once(LIB_PATH.DS."config.php");
//Here the code uses mysqli instead of mysql adapter as mysql standing from php b5.0 has been deprecated
class MySqlDatabase{
	private $connection;
	public $last_query;
	private $mysql_real_escape_exists;
	private $magic_quotes_active;

 function __construct(){
  	 $this->open_connection();
  	 $this->mysql_real_escape_exists = function_exists('mysql_real_escape_string');
  	 $this->magic_quotes_active = get_magic_quotes_gpc();
    }

 public function open_connection(){
		$this->connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
		if(!$this->connection){
			die("Database Connection Failed : ".mysql_error());
		}
	}

 public function close_connection(){
  		if(isset($this->connection)){
  			mysqli_close($this->connection);	
  			unset($this->connection);
  		 }
  }

 public function query($sql=""){
  	 $this->last_query = $sql;
  	 $result = mysqli_query($this->connection,$sql);
  	 $this->confirm_query($result);
  		return $result;
  	 }

public function escape_value($value ="") {
  	  	if($this->mysql_real_escape_exists){
  			if($this->magic_quotes_active){
  				$value = stripslashes($value);
  			}
  		$value = mysqli_real_escape_string($this->connection,$value);
  		}else
  		{
  			if(!$this->magic_quotes_active){ $value = addslashes($value);}
  		}
  		return $value;
 }

 public function fetch_array($result_array){
  		return mysqli_fetch_assoc($result_array);
 	 }

 public function num_rows($result){
  		return mysqli_num_rows($result);
 	 }

 public function insert_id(){
  		return mysqli_insert_id($this->connection);
  	 }

 public function affected_rows(){
  		return mysqli_affected_rows($this->connection);
  	 }

 private function confirm_query($query=""){
  		if(!$query){
  			$output = "Database Query Failed : ".mysqli_error($this->connection)."<br />";
  			$output .="Last Sql Query: ".$this->last_query;
  		die($output);
  		}
  	}
 
 }

$database = new MySqlDatabase();


?>