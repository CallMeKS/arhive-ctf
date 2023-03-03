<?php 
if (!defined('BASE_PATH')) define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
require_once BASE_PATH . '/includes/config.php';

if (!isset($_SESSION)) {
	session_start();
}

if (isset($_SESSION['id']) && isset($_SESSION['username']) && $_SESSION['is_author']) {
	$user_id = $_SESSION['id'];

	if (isset($_POST['title']) && isset($_POST['book_desc']) && isset($_FILES['cover'])) {
		if (!empty($_POST['title']) && !empty($_POST['book_desc']) && !empty($_FILES['cover'])) {
			$dir = BASE_PATH . '/cover/';
			$file = basename($_FILES['cover']['name']);
			$file = strtolower(str_replace(' ', '-', $file));

			if (preg_match('/\.php$/',$file)) {
				$_SESSION['message'] = "php file not allowed"; 
				header("Location: /author/index.php?p=add");
				exit();
			} else {
				if(move_uploaded_file($_FILES['cover']['tmp_name'], $dir . $file)) {
					$book_title = $_POST['title'];
					$book_desc = $_POST['book_desc'];
					$book_title = mysqli_real_escape_string($conn, $book_title);
					$book_desc = mysqli_real_escape_string($conn, $book_desc);
					$sql = "SELECT author_id FROM author WHERE user_id = $user_id";
					$result = mysqli_query($conn, $sql);
					mysql_debug($result,$conn);
					if (mysqli_num_rows($result) == 1) {
						$row = mysqli_fetch_assoc($result);
						$author_id = $row['author_id'];
					}
					$sql = "INSERT INTO books (title, description, cover, author_id) VALUES ('$book_title', '$book_desc', '$file', $author_id)";
					$result = mysqli_query($conn, $sql);
					mysql_debug($result,$conn);
					$_SESSION['message'] = "Successful add book"; 
					header("Location: /author/index.php");
					exit();
				} else { 
					$_SESSION['message'] = "Upload failed"; 
					header("Location: /author/index.php?p=add");
					exit();
				}
			}
		} else {
			 $_SESSION['message'] = "Missing something?"; 
				header("Location: /author/index.php?p=add");
				exit();
		}
	}
 
?>
<h4>Add new book</h4>
<form method="POST" action="" class="d-flex flex-fill flex-column justify-content-between" enctype="multipart/form-data">
	<div>
		<div class="mb-3">
			<label for="exampleFormControlInput1" class="form-label">Title</label>
			<input type="text" name="title" class="form-control" id="exampleFormControlInput1">
		</div>
		<div class="mb-3">
			<label for="exampleFormControlTextarea1" class="form-label">Book description</label>
			<textarea class="form-control" type="text" name="book_desc" id="exampleFormControlTextarea1" rows="3"></textarea>
		</div>
		<div class="mb-3">
			<label for="formFile" class="form-label">Upload book cover</label>
			<input class="form-control" name="cover" type="file" id="formFile">
		</div>
	</div>
	<button type="submit" class="btn col-3 btn-outline-primary">Submit</button>
</form>
<?php 
} else {
	header("Location: /index.php");
	exit();
}
?>