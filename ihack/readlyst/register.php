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

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
	function validate($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	$username = validate($_POST['username']);
	$password = validate($_POST['password']);
	$email = validate($_POST['email']);

	if (empty($username)) {
		$_SESSION['message'] = "User Name is required"; 
		header("Location: /register.php");
		exit();
	} else if(empty($password)) {
		$_SESSION['message'] = "Password is required"; 
		header("Location: /register.php");
		exit();
	} else if(empty($email)) {
		$_SESSION['message'] = "Email is required"; 
		header("Location: /register.php");
		exit();
	} else {
		$sql = "SELECT username, email FROM users WHERE username = '$username' OR email = '$email'";
		$result = mysqli_query($conn, $sql);
		mysql_debug($result,$conn);
		if (mysqli_num_rows($result) >= 1) {
			$_SESSION['message'] = "Username or email already taken"; 
			header("Location: /register.php");
			exit();
		} else {
			$password_hashed = sha1($password);				
			$sql = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$password_hashed', '$email', 0)";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result,$conn);
			$_SESSION['message'] = "Account Created!"; 
			header('Location: /index.php');
			exit();
		}
	}
}
?>
<?php include_once BASE_PATH . '/includes/head.php'; ?>
	<body class="bg-light d-flex flex-column min-vh-100">
		<div class="container mt-5 w-25">
			<?php include_once BASE_PATH . '/includes/alert.php'; ?>
			<h1 class="text-nowrap mt-5 mb-4">Sign up to ReadLyst</h1>
			<form method="POST" action="register.php" class="mb-3">
				<div class="mb-3">
					<label for="emailInput" class="form-label">Email</label>
					<input type="text" name="email" value="" placeholder="Enter your email" class="form-control" id="emailInput" aria-describedby="emailNotes">
					<div id="emailNotes" class="form-text">We'll not share your email with anyone else</div>
				</div>
				<div class="mb-3">
					<label for="usernameInput" class="form-label">Username</label>
					<input type="text" name="username" value="" placeholder="Enter your username" class="form-control" id="usernameInput">
				</div>
				<div class="mb-3">
					<label for="passwordInput" class="form-label">Password</label>
					<input type="password" name="password" value="" placeholder="Enter your password" class="form-control" id="passwordInput">
				</div>
				<div class="d-grid gap-2 col mx-auto">
					<button type="submit" class="btn btn-outline-primary">Register account</button>
				</div>
			</form>
			<small class="text-muted fw-light mt-4"><em>Already have an account? <a href="index.php" class="text-reset">Login</a> now</em></small>
		</div>
<?php include_once BASE_PATH . '/includes/footer.php'; footer(1); ?>