<?php require_once(LIB_PATH.DS.'initialize.php');

class Photograph extends DatabaseObject{
	protected static $table_name = "photograph";
	protected static $db_fields = array('id' , 'filename' , 'type' , 'size' , 'caption');
	//Initialized by SQL
	public $id;
	public $filename;
	public $type;
	public $size;
	public $caption;
	//till Here
	private $tmp_path;
	protected $upload_dir = "images";
	public $errors = array();
	protected $upload_error = array(
									UPLOAD_ERR_OK =>			'No Errors',
									UPLOAD_ERR_INI_SIZE =>		'Larger than upload_max_size',
									UPLOAD_ERR_FORM_SIZE =>		'Larger Than Form Max_Size',
									UPLOAD_ERR_PARTIAL =>		'Partial Upload',
									UPLOAD_ERR_NO_FILE=>		'No FIle Uploaded',
									UPLOAD_ERR_NO_TMP_DIR =>	'No Temproray Directory',
									UPLOAD_ERR_CANT_WRITE =>	'Cant Write to Disk' ,
									UPLOAD_ERR_EXTENSION =>		'File Upload Stopped By Extension'
									);
	public function attach_file($file){
			
			if(!$file || empty($file) || !is_array($file)){
				
				$errors[] = "No File Was Uploaded" ; 
				return false;
			}elseif($file['error']!=0){
				$errors[] = $this->upload_error[$file['error']]; 
				return false;
			}else{
				$this->filename = basename($file['name']);
				$this->type = $file['type'];
				$this->size = $file['size'];
				$this->tmp_path = $file['tmp_name'];
				return true;
			}
	}
	
	public function comment(){
		return Comment::find_comments_on($this->id);
	}

	public function save(){
		if(isset($this->id)){
			$this->update();
		}else{
			if(!empty($errors)){
				return false;
			}
			if(strlen($this->caption) >=255){
				$this->errors[] = "File Caption can only be 255 characters Long at Maximum";
				return false;
			}
			//Filename and tmp_dir Name should be available
			if(empty($this->filename) || empty($this->tmp_path)){
				$this->errors[] = "File Location Not Given ";
				return false;
			}

			$target_path = SITE_ROOT.DS."public".DS.$this->upload_dir.DS.$this->filename;

			if(file_exists($target_path)){
				$this->errors[] = "File Name Already Exists in The directory:".$target_path;
				return false;
			}

			if(move_uploaded_file($this->tmp_path, $target_path)){
				if($this->create()){
					unset($this->tmp_dir);
					return true;
				}

			}else{
				$this->errors = "Moveinng Uploaded File Failed possibly due to directory permissions";
				return false;
			}
		}
	}
 	
 	static public function table_name(){
		return self::$table_name;
	}

	public function image_path(){
		return $this->upload_dir.DS.$this->filename;
	}

	public function size_as_text(){
		if($this->size < 1024){
			return $this->size." Bytes";
		}elseif ($this->size < 1048576) {
			return round($this->size/1024)." KB";
		}else{
			return round($this->size/1048576)." MB";	
		}
	}

	public function destroy(){
		global $session;
		if($this->delete()){
			$target_path = SITE_ROOT.DS."public".DS.$this->image_path();
			$session->set_get_message($target_path);
			return unlink($target_path) ? true : false;
		}else{
			return false;
		}
	}
 }
