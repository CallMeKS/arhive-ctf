<?php 
if (!defined('BASE_PATH')) define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
require_once BASE_PATH . '/includes/config.php';

if (!isset($_SESSION)) {
	session_start();
}

if (isset($_SESSION['id']) && isset($_SESSION['username']) && $_SESSION['is_author']) {
	$user_id = $_SESSION['id'];

	if (isset($_POST['author_desc'])) {
		$author_desc = $_POST['author_desc'];
		$author_desc = str_replace("'","\'",$author_desc);
		$sql = "UPDATE author SET description = '$author_desc' WHERE user_id = $user_id";
		$result = mysqli_query($conn, $sql);
		mysql_debug($result,$conn);
		$_SESSION['message'] = "Author description changed successfuly"; 
		header("Location: /author/index.php");
		exit();
	}
?>

<h4>Change Author description</h4>
<p class="mb-4 text-muted">This will be shown at your author page.</p>
<form method="POST" action="" class="d-flex flex-fill flex-column justify-content-between">
	<div class="form-floating mb-3">
		<textarea class="form-control" name="author_desc" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
		<label for="floatingTextarea2">Share something about yourself</label>
	</div>
	<button type="submit" class="btn col-3 btn-outline-primary">Submit</button>
</form>

<?php 
} else {
	header("Location: /index.php");
	exit();
}
?>