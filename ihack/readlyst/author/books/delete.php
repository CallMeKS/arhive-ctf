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
		$book_id = $_GET['id'];
		$sql = "SELECT * FROM books WHERE book_id = $book_id AND author_id = $author_id";
		$result = mysqli_query($conn, $sql);
		mysql_debug($result,$conn);
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_assoc($result);
			$book_cover = $row['cover'];
			$sql = "DELETE FROM books WHERE book_id = $book_id AND author_id = $author_id";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result,$conn);
			$_SESSION['message'] = "Book deleted";
			unlink(BASE_PATH . "/cover/$book_cover");
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