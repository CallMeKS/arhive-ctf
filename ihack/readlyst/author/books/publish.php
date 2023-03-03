<?php 
if (!defined('BASE_PATH')) define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
require_once BASE_PATH . '/includes/config.php';

if (!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
	$_SESSION['message'] = "Please Login to continue";
	header('Location: /index.php');
	exit();
}

if (isset($_SESSION['id']) && isset($_SESSION['username']) && $_SESSION['is_author']) {
	$user_id = $_SESSION['id'];
	$sql = "SELECT author_id FROM author WHERE user_id = $user_id";
	$result = mysqli_query($conn, $sql);
	mysql_debug($result,$conn);
	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_assoc($result);
		$author_id = $row['author_id'];
	}
	if (isset($_GET['id']) && !empty($_GET['id'])) {
		if (isset($_GET['unpublish']) && $_GET['unpublish'] == 'true') {
			$publish_status = 0;
			$publish_message = "Book unpublished";
		} else {
			$publish_status = 1;
			$publish_message = "Book published";
		}
		$book_id = $_GET['id'];
		$sql = "SELECT * FROM books WHERE book_id = $book_id AND author_id = $author_id";
		$result = mysqli_query($conn, $sql);
		mysql_debug($result,$conn);
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_assoc($result);
			$sql = "UPDATE books SET published = $publish_status WHERE book_id = $book_id";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result,$conn);

			if (!$publish_status) {
				$tables = array("book_likes","book_rating","comments","read_list");
				for($i = 0; $i < count($tables); $i++) {
				  $sql = "DELETE FROM $tables[$i] WHERE book_id = $book_id";
				  $result = mysqli_query($conn, $sql);
				  mysql_debug($result,$conn);
				}
			}

			$_SESSION['message'] = $publish_message;
			header("Location: /author/index.php");
			exit();
		} else {
			echo "You're not the author of this book.";
			exit();
		}
	} else {
		echo "Missing param id";
		exit();
	}
} else {
	echo "You're not an author";
	exit();
}
?>