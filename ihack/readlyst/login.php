<?php 
if (!defined('BASE_PATH')) define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
require_once BASE_PATH . '/includes/config.php';

if (!isset($_SESSION)) {
	session_start();
}

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
	header('Location: /index.php');
	exit();
}
if (isset($_POST['email']) && isset($_POST['password'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];
	if (empty($email)) {
		$_SESSION['message'] = "Email is required";
		header('Location: /index.php');
		exit();
	} else if(empty($password)) {
		$_SESSION['message'] = "Password is required";
		header('Location: /index.php');
		exit();
	} else {
		$password_hashed = sha1($password);
		$sql = "SELECT * FROM users WHERE email='$email' AND password='$password_hashed'";
		$result = mysqli_query($conn, $sql);
		mysql_debug($result,$conn);
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_assoc($result);
			if ($row['role'] == 1) {
				$_SESSION['is_author'] = True;
			} else {
				$_SESSION['is_author'] = False;
			}
			if ($row['email'] == $email || $row['password'] == $password_hashed) {
				$_SESSION['username'] = $row['username'];
				$_SESSION['id'] = $row['user_id'];
				$_SESSION['email'] = $row['email'];
				
				$_SESSION['message'] = "Welcome " . $_SESSION['username'];
				header("Location: /index.php");
				exit();
			} else {
				unset($_SESSION['is_author']);
				$_SESSION['message'] = "Incorect email or password";
				header("Location: /index.php");
				exit();
			}
		} else {
			$_SESSION['message'] = "Incorect email or password";
			header("Location: /index.php");
			exit();
		}
	}
} else {
	echo "lulz";
}
?>