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
 
		if (isset($_POST['title']) && isset($_POST['book_desc']) && isset($_FILES['cover']) && isset($_GET['id'])) {
			if (!empty($_POST['title']) && !empty($_POST['book_desc']) && !empty($_FILES['cover']) &&  !empty($_GET['id'])) {
				$book_id = $_GET['id'];
				$dir = BASE_PATH . '/cover/';
				$sql = "SELECT cover FROM books WHERE book_id = $book_id AND author_id = $author_id";
				$result = mysqli_query($conn, $sql);
				mysql_debug($result,$conn);
				if (mysqli_num_rows($result) == 1) {
					$row = mysqli_fetch_assoc($result);
					$old_book_cover = $row['cover'];
				}
				unlink("$dir$old_book_cover");
				$file = basename($_FILES['cover']['name']);
				$file = strtolower(str_replace(' ', '-', $file));
				if(move_uploaded_file($_FILES['cover']['tmp_name'], $dir . $file)) {
					$book_title = $_POST['title'];
					$book_desc = $_POST['book_desc'];
					$sql = "UPDATE books SET title = '$book_title', description = '$book_desc', cover = '$file' WHERE book_id = $book_id AND author_id = $author_id";
					$result = mysqli_query($conn, $sql);
					mysql_debug($result,$conn);
					$_SESSION['message'] = "Successful edit book"; 
					header("Location: /author/index.php");
					exit();
				} else { 	
					$_SESSION['message'] = "cover upload failed"; 
					header("Location: /author/books/update.php?id=$book_id");
					exit();
				}
			} else {
				$_SESSION['message'] = "Missing something?"; 
				header("Location: /author/books/update.php?id=$book_id");
				exit();
			}
		}

		if (isset($_GET['id']) && !empty($_GET['id'])){
			$book_id = $_GET['id'];
			$sql = "SELECT * FROM books WHERE book_id = $book_id AND author_id = $author_id";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result,$conn);
			if (mysqli_num_rows($result) == 1) {
				$row = mysqli_fetch_assoc($result);
				$book_title = $row['title'];
				$book_desc = $row['description'];
				$book_cover = $row['cover'];  ?>
<?php include_once BASE_PATH . '/includes/header.php'; ?>

<main class="flex-grow-1 bg-light">
	<div class="container my-5">
		<h3>Edit book</h3>
		<div class="card mt-4">
			<div class="card-body d-flex" style="min-height: 50vh;">
				<div class="row flex-grow-1">
					<div class="col-2">
						<div class="d-flex flex-column h-100 justify-content-between">
							<div class="card pt-4 ps-4 bg-transparent h-100" style="border: none">
								<img src="/cover/<?php echo $book_cover; ?>" class="card-img-top shadow" alt="<?php echo $book_title; ?>">
							</div>
							<button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete Book</button>
						</div>
					</div>
					<form method="POST" action="" enctype="multipart/form-data" class="col p-4 pb-0 ms-3 d-flex flex-column justify-content-between">
						<div>
							<h4>Edit book</h4>
							<div class="mb-3">
								<label for="exampleFormControlInput1" class="form-label">Title</label>
								<input type="text" name="title" class="form-control" id="exampleFormControlInput1" value="<?php echo $book_title; ?>">
							</div>
							<div class="mb-3">
								<label for="exampleFormControlTextarea1" class="form-label">Book description</label>
								<textarea class="form-control" type="text" name="book_desc" id="exampleFormControlTextarea1" rows="3"><?php echo $book_desc; ?></textarea>
							</div>
							<div class="mb-3">
								<label for="formFile" class="form-label">Upload new book cover</label>
								<input class="form-control" name="cover" type="file"  id="formFile">
							</div>
							
						</div>
						<div class="row">
							<button type="submit" class="btn col-3 btn-outline-primary">Update</button>
							<?php if($row['published'] == 0){ ?>
							<a href="/author/books/publish.php?id=<?php echo $book_id; ?>" type="button" class="ms-3 btn col-3 btn-outline-success">Publish book</a>
							<?php } else { ?>
							<button type="button" class="ms-3 btn col-3 btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#publishModal">Unpublish</button>
							<?php } ?>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</main>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				Are you sure you want to delete this book?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<a href="/author/books/delete.php?id=<?php echo $book_id; ?>" type="button" class="btn btn-danger">Delete</a>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="publishModal" tabindex="-1" aria-labelledby="publishModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Unpublish book confirmation</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				Marking book as unpublish will remove all data associate with the book. Likes, comment, etc. Are you sure?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<a href="/author/books/publish.php?id=<?php echo $book_id; ?>&unpublish=true" type="button" class="btn btn-danger">Unpublish</a>
			</div>
		</div>
	</div>
</div>

<?php include_once BASE_PATH . '/includes/footer.php'; footer(1); ?>
<?php	} else {
				echo "not found";
			}
		} else {
			echo "param id missing";
		}
	} else {
		echo "You're not an author";
	}	
?>