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

	function isOwnedByAuthor($conn,$current_author_id, $book_id) {
		$sql = "SELECT * FROM books WHERE author_id = $current_author_id AND book_id = $book_id";
		$result = mysqli_query($conn, $sql);
		mysql_debug($result,$conn);
		if (mysqli_num_rows($result) == 1) {
			return True;
		} else {
			return False;
		}
	}

	if (isset($_SESSION['id']) && isset($_SESSION['username'])  && $_SESSION['is_author']) {
		$user_id = $_SESSION['id'];
		$username = $_SESSION['username'];
		$sql = "SELECT author_id FROM author WHERE user_id = $user_id";
		$result = mysqli_query($conn, $sql);
		mysql_debug($result,$conn);
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_assoc($result);
			$is_current_author_id = $row['author_id'];
		}
	}

	if (isset($_GET['id'])) {
		$author_id = $_GET['id'];
		$sql = "SELECT users.username, author.description FROM users JOIN author ON users.user_id = author.user_id WHERE author.author_id = $author_id";
		$result = mysqli_query($conn, $sql);
		mysql_debug($result,$conn);
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_assoc($result);
			$author_name = $row['username'];
			$author_desc = $row['description'];

			include_once BASE_PATH . '/includes/header.php'; ?>
			
		<main class="flex-grow-1 bg-light">
			<?php include_once BASE_PATH . '/includes/alert.php'; ?>
			<div class="container my-5">
				<h3><?php echo $author_name; ?></h3>
				<small class="text-muted">Top rated author</small>
				<div class="card mt-4">
					<div class="card-body">
						<?php echo $author_desc; ?>
					</div>
				</div>
			</div>
			<div class="container my-5">
				<h2 class="mb-4">Books written by author</h2>
				<div class="row">
					<?php 
						$sql = "SELECT * FROM books WHERE author_id = $author_id";
						$result = mysqli_query($conn, $sql);
						mysql_debug($result,$conn);
						if (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) { ?>
								<div class="col-2">
									<div class="card h-100 bg-light shadow-sm">
										<img src="/cover/<?php echo $row["cover"]; ?>" class="card-img-top" alt="<?php echo $row["title"]; ?>">
										<div class="card-body">
											<h5 class="card-title"><?php echo $row["title"]; ?></h5>
											<h6 class="card-subtitle mb-2">By <a class="text-muted" href="/author/show.php?id=<?php echo $author_id; ?>"><?php echo $author_name; ?></a></h6>
											<a href="/show.php?id=<?php echo $row["book_id"]; ?>" class="btn btn-outline-secondary">View more</a>
											<?php 
												if ($_SESSION['is_author']) {
													if (isOwnedByAuthor($conn,$is_current_author_id,$row['book_id'])) { ?>
											<a href="/author/books/update.php?id=<?php echo $row['book_id']; ?>" class="btn btn-outline-secondary">Edit</a>
												<?php }
												} ?>
										</div>
									</div>
								</div>
						<?php  }
						} else {
							echo "<p>0 results</p>";
						}
					?>

				</div>
			</div>
		</main>

<?php include_once BASE_PATH . '/includes/footer.php'; footer(1);
		} else {
			echo "Author you're looking for is not found";
		}
	} else {
		echo "Missing param id";
	}
	
?>