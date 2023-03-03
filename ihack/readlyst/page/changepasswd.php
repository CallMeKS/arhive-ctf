<?php 
if (!defined('BASE_PATH')) define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
require_once BASE_PATH . '/includes/config.php';

if (!isset($_SESSION)) {
	session_start();
}

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
	$user_id = $_SESSION['id'];
	$username = $_SESSION['username'];
	$email = $_SESSION['email'];
	$page_title = "Change Password";

	if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
	$new_password = $_POST['new_password'];
	$confirm_password = $_POST['confirm_password'];

		if($new_password != $confirm_password) {
			$_SESSION['message'] = "Confirm password not match"; 
			header("Location: profile.php");
			exit();
		} else {
			$hashed_new_password = sha1($new_password);
			$data = "";
			foreach($_POST as $key => $value) {
				if(strpos($key, 'password') === false) {					
					$data .= ", $key = '$value'";
				}
			}
			$sql = "UPDATE users SET password = '$hashed_new_password'".$data." WHERE user_id = $user_id";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result,$conn);
			$_SESSION['message'] = "Password changed successfuly"; 
			header("Location: profile.php");
			exit();
		}
	}
?>
<div class="d-flex h-100 flex-column">
<h4 class="mb-4">Profile</h4>
<form method="POST" action="" class="d-flex flex-fill flex-column justify-content-between">
	<div>
		<div class="mb-3">
			<label for="exampleInputEmail1" class="form-label">Email address</label>
			<input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" disabled value="<?php echo $email; ?>">
			<div id="emailHelp" class="form-text">Email address cannot be changed</div>
		</div>
		<div class="mb-3">
			<label for="exampleInputPassword1" class="form-label">Password</label>
			<input type="password" name="new_password" class="form-control" id="exampleInputPassword1">
		</div>
		<div class="mb-3">
			<label for="exampleInputPassword1" class="form-label">Confirm Password</label>
			<input type="password" name="confirm_password" class="form-control" id="exampleInputPassword1">
		</div>
	</div>
	<button type="submit" class="btn col-3 btn-outline-primary">Submit</button>
</form>
</div>
<?php 
} else {
	header("Location: /index.php");
	exit();
}
?>