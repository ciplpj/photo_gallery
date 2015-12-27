<?php require_once('initialize.php') ?>
<?php
	defined('LOG_FILE') ? NULL : define('LOG_FILE',SITE_ROOT.DS."logs/logs.txt");
	class Log{
		var $filepath ;

		public function __construct(){
			$this->filepath = LOG_FILE;
		}
		public function log_action ($action, $message=""){
			if(file_exists($this->filepath)){
				//File exists
					$handle = fopen($this->filepath,'a');
			}else {
				//File doesnt exist
					$handle = fopen($this->filepath,'w');
			}
			if(!is_writable($this->filepath)){
				echo "Log Is Write Protected, Kindly Check For Server User Permissions";
				return 0 ;
			}
				$content = $this->create_entry($action,$message);
				fwrite($handle,$content);
				fclose($handle);
			}
		

		private function create_entry($action, $message=""){
				$time = strftime(" %Y-%m-%d %H:%M:%S ");
				$content = $time." | ".$action." : ".$message."   IP Address : ".$_SERVER['REMOTE_ADDR']."\n";
				return $content;
		}

		public function read_log(){
			if(file_exists($this->filepath) && is_readable($this->filepath)){
				$handle = fopen($this->filepath , 'r');
			}else{
				echo "Error Reading Log - Log Doesn't Exist".$this->filepath ;
				return 0;
			}
			echo "Log File Content : <br />";
			echo "<table class=\"logtable\" border=1px padding=20px> 
					<tr>
						<th>S No\.</th>
						<th>Date</th>
						<th>Action</th>
						<th>Message</th>
						<th>IP Address</th>
					</tr>";
					$s = 1;
			while($content = fgets($handle)){
				$date = substr($content,0,strpos($content, "|") -1);
				$action = substr($content,strpos($content, " | ")+3,strpos($content, " : ") - (strpos($content, " | ")+3));
				$message = substr($content,strpos($content, " : ")+3,strpos($content, "IP Address") -1 -(strpos($content, " : ")+3));
				$ip = substr($content,strpos($content, "IP Address"),strlen($content));
				echo "<tr>";
				echo "<td>".$s."</td>";
				echo "<td>".$date."</td>";
				echo "<td>".$action."</td>";
				echo "<td>".$message."</td>";
				echo "<td>".$ip."</td>";
				echo"</tr>";
				$s++;
			//echo htmlentities($content)."<br />";
			}
			echo "</table>";
			fclose($handle);
		}

		public function clear($user="Unknown"){
			$handle = fopen($this->filepath,'w');
			if(!is_writable($this->filepath)){
				echo "Log Is Write Protected, Kindly Check For Server User Permissions";
				return 0 ;
			}
			$message = $user." Cleared the Log";
			$action = "Log Clear";
			$content = $this->create_entry($action,$message);
			fwrite($handle,$content);
			fclose($handle);
		}
	}

	$log = new Log();

?>