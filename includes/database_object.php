<?php
require_once(LIB_PATH.DS."database.php");
//How to make static private and then access the $table_name?
class DatabaseObject{

	static private $table_name;

	static public function find_all(){
		global $database;
		$query ="SELECT * FROM ".static::table_name();
		$user = self::find_by_sql($query);
		return $user;
	}

	static public function find_by_id($id=0){
		global $database;
		$id = $database->escape_value($id);
		$query ="SELECT * FROM ".static::table_name();
		$query .=" WHERE id = {$id} LIMIT 1";
		$user = self::find_by_sql($query);
		return !empty($user) ? array_shift($user) : false ;
	}

	static public function find_by_sql($query=""){
		global $database;
		$users = $database->query($query);
		$object_array = array();
		while($user=$database->fetch_array($users)){
			$object_array[] = static::instantiate($user);
		}
		return $object_array;
	}

	private static function instantiate($record=array()){
		//Simple, Long-apprach for users
		// $object->id         =  $record['id'];
		// $object->username   =  $record['username'];
		// $object->password   =  $record['password'];
		// $object->first_name =  $record['first_name'];
		// $object->last_name  =  $record['last_name'];
		// return $object;
		//Dynamic, short-approach
		$class_name = get_called_class();
		$object = new $class_name;
		foreach($record as $attribute =>$val){
			if($object->has_attribute($attribute)){
				$object->$attribute = $val;
			}
		}
		return $object;
	}

	public function has_attribute($att){
		$defined_vars = get_object_vars($this);
		return array_key_exists($att, $defined_vars);
	}
	protected function attribute(){

	 // 	$array_vars = get_object_vars($this);
	 // 	unset($array_vars['$table_name']);
	 // 	return $array_vars;
	  //Check prroperty_exists works or not
		$attribute = array();
		foreach(static::$db_fields as $fields){
			if(property_exists($this, $fields)){
				$attribute[$fields] = $this->$fields;
			}
		}
		return $attribute;
	}

	protected function escaped_attribute(){
		global $database;
		$clean_attr = array();
		foreach($this->attribute() as $key => $value){
			if($key =='table_name'){
				continue;
			}
			$clean_attr[$key] = $database->escape_value($value);
		}
		return $clean_attr;
	}

	protected function create(){
		global $database;
		$attributes = $this->escaped_attribute();
		$query = "INSERT INTO ".static::$table_name." (";
		$query .= join(" , " , array_keys($attributes))." ) VALUES ( '";
		$query .= join("' , '" , array_values($attributes))."' );";
		if ($database->query($query)){
			$this->id = $database->insert_id();
			return true;
		}else{
			return false;
		}
	}

	protected function update(){
		global $database;
		$attributes = $this->escaped_attribute();
		$pair = array();
		foreach($attributes as $key=>$value){
			if($key == "id" || $key == "table_name"){
				continue;
			}
			$pair[] = "{$key} = '{$value}'";
		}
		$query = "UPDATE ".static::$table_name." SET ";
		$query .=join(" , ",$pair);
		$query .= " WHERE id= ".$database->escape_value($this->id)." ;";
		$database->query($query);
		if($database->affected_rows() == 1){
			return true;
		}else{
			return false;
		}
	}

	public function delete(){
		global $database;
		if(isset($this->id)){
			$query = "DELETE FROM ".static::$table_name." WHERE id = ".$database->escape_value($this->id);
			$query .=" LIMIT 1";
			$database->query($query);
			if($database->affected_rows() == 1){
				return true;
			}else{
			return false;
			}
	    }else{
		return false;
		}
	}

	public static function count(){
		global $database;
		$query = "SELECT COUNT(*) FROM ".static::$table_name;
		$result_set = $database->query($query);
		$result = $database->fetch_array($result_set);
		return array_shift($result);
	}
}