<?php
require_once(LIB_PATH.DS."database.php");

class User extends DatabaseObject {

	static protected $table_name = "user";
	public $id;
	public $username;
	public $first_name;
	public $last_name;
	public $password;
	protected static $db_fields = array('username' , 'id' , 'first_name' , 'last_name' , 'password');

	public function full_name(){
		if(isset($this->first_name) && isset($this->last_name)){
			return $this->first_name." ".$this->last_name;
		}else{
			return "";
		}
	}

	static public function authenticate($user="",$pass=""){
		global $database;
		$user = $database->escape_value($user);
		$pass = $database->escape_value($pass);
		$query = "SELECT * FROM user ";
		$query .= "WHERE username = '{$user}' AND password = '{$pass}' LIMIT 1";
		$user = static::find_by_sql($query);
		return !empty($user) ? array_shift($user) : false ;
	}

	static public function table_name(){
		return self::$table_name;
	}
	public function save(){
		isset($this->id) ? $this->update() : $this->create();
	}

}


?>