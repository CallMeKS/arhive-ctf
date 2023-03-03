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

	if (isset($_SESSION['id']) && isset($_SESSION['username']) && $_SESSION['is_author'] != true) {
		$_SESSION['message'] = "You're not an author";
		header('Location: /index.php');
		exit();
	}
?>
<?php include_once BASE_PATH . '/includes/header.php'; ?>
<main class="flex-grow-1 bg-light">
	<div class="container my-5">
		<?php include_once BASE_PATH . '/includes/alert.php'; ?>
		<h3>Author Settings</h3>
		<div class="card mt-4">
			<div class="card-body d-flex" style="min-height: 50vh;">
				<div class="row flex-grow-1">
					<div class="col-3">
						<div class="d-flex flex-column h-100 justify-content-between">
							<div class="list-group list-group-flush">
								<a href="?p=desc" class="list-group-item list-group-item-action">Author Description</a>
								<a href="?p=add" class="list-group-item list-group-item-action">Add books</a>
							</div>
						</div>
					</div>
					<div class="col p-4 pb-0 ms-3 d-flex flex-column">
						<?php
						if (isset($_GET['p'])) {
							include BASE_PATH . "/author/page/" . $_GET['p'] . ".php";
						} else {
							include BASE_PATH . "/author/page/desc.php";
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container my-5">
		<h2 class="mb-4">Books written by author</h2>
		<div class="row">
			<?php
				$sql = "SELECT author_id FROM author WHERE user_id = $user_id";
				$result = mysqli_query($conn, $sql);
				mysql_debug($result,$conn);
				if (mysqli_num_rows($result) == 1) {
					$row = mysqli_fetch_assoc($result);
					$author_id = $row['author_id'];
				} 
				else {
					$sql = "INSERT INTO author (user_id) VALUES ($user_id)";
					$result = mysqli_query($conn, $sql);
					mysql_debug($result,$conn);
				}
					
				$sql = "SELECT * FROM books WHERE author_id = $author_id";
				$result = mysqli_query($conn, $sql);
				mysql_debug($result,$conn);
				if (mysqli_num_rows($result) > 0) {
						while($row = mysqli_fetch_assoc($result)) { ?>
						<div class="col-2">
							<div class="card h-100 bg-light shadow-sm">
								<img src="/cover/<?php echo $row['cover']; ?>" class="card-img-top" alt="<?php echo $row['title']; ?>">
								<div class="card-body">
									<h5 class="card-title"><?php echo $row['title']; ?>
										<?php if($row['published'] == 0){ ?>
											<span class="badge bg-secondary">Unpublished</span>
										<?php } ?>
									</h5>
									<h6 class="card-subtitle mb-2">By <a class="text-muted" href="/author/show.php?id=<?php echo $author_id; ?>"><?php echo $username; ?></a></h6>
									<a href="/show.php?id=<?php echo $row['book_id']; ?>" class="btn btn-outline-secondary">View more</a>
									<a href="/author/books/update.php?id=<?php echo $row['book_id']; ?>" class="btn btn-outline-secondary">Edit</a>
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
<?php include_once BASE_PATH . '/includes/footer.php'; footer(1); ?>