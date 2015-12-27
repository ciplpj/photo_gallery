<?php require_once('../../includes/initialize.php'); ?>
<?php
	if($session->is_logged_in()){
		redirect("index.php");
	}
	if(isset($_POST['submit'])){

		$username = trim($_POST['username']);
		$password = trim($_POST['password']);

		//check to see if username and password exists
		$found_user=User::authenticate($username,$password);
		if($found_user){
			//log file changed in Session::login()!!
			$session->login($found_user);
			$message = "Succcesfully Logged In";
			redirect("index.php");
		}else{
			//user/pass not found in database
			$message = "Username/Password Combination is Incorrect";
		}

	}else{
		$username = "";
		$password = "";
	}
?>
<?php include_layout_template("admin_header.php") ;?>

		<h2>Staff Login</h2>
		<?php echo isset($message)? output_message($message):"" ;?>

		<form action="login.php" method="post">
			<table>
				<tr>
					<td>Username :</td>
					<td><input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username) ;?>" /></td>
				</tr>
				<tr>
					<td>Password :</td>
					<td><input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password) ;?>" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Log In" /></td>
				</tr>
			</table>

		</form>

<?php include_layout_template("admin_footer.php") ;?>
