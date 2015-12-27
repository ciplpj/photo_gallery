<?php require_once(LIB_PATH.DS."log.php");?>
<?php
	
	class Session{
		private $logged_in = false;
		public $user_id;
		public $message ;

		function __construct(){
			session_start();
			$this->check_login();
			$this->check_message();
		}

		function check_login(){
			if(isset($_SESSION['user_id'])){
				$this->user_id = $_SESSION['user_id'];
				$this->logged_in = true;
			}else{
				unset($user_id);
				$this->logged_in = false;
			}
		}

		public function is_logged_in(){
			return $this->logged_in;
		}

		public function login($user){
			//Check if the user exists
			global $log;

			if($user){
				$this->user_id = $_SESSION['user_id']=$user->id;
				$this->logged_in = true;
				$message = $user->username." Logged In ";
				$log->log_action("Login",$message);

			}
		}

		public function logout(){
			unset($this->user_id);
			unset($_SESSION['user_id']);
			$logged_in = false;
		}

		public function check_message(){
			if(isset($_SESSION['message'])){
				$this->message = $_SESSION['message'];
				unset($_SESSION['message']);
			}else{
				$this->message ="";
			}
		}

		public function set_get_message($msg=""){
			if(!empty($msg)){
				$_SESSION['message'] = $msg;
			}else{
				return $this->message;
			}
		}
	}

$session = new Session();
$message = $session->set_get_message();
?>