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

include_once BASE_PATH . '/includes/header.php';
include_once BASE_PATH . '/includes/breadcrumbs.php'; ?>

		<main class="flex-shrink-0">
			<div class="container my-5">
				<h2 class="mb-4">New Release</h2>
				<div class="row">
					<?php 
						$sql = "SELECT * FROM books JOIN author ON books.author_id = author.author_id JOIN users ON author.user_id = users.user_id where books.published = 1 ORDER BY book_id DESC LIMIT 6";
						$result = mysqli_query($conn, $sql);
						mysql_debug($result,$conn);
						if (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) { ?>
								<div class="col-2">
									<div class="card h-100 bg-light shadow-sm">
										<img src="/cover/<?php echo $row['cover']; ?>" class="card-img-top" alt="<?php echo $row['title']; ?>">
										<div class="card-body d-flex flex-column">
											<div class="flex-grow-1">
												<h5 class="card-title"><?php echo $row['title']; ?></h5>
												<h6 class="card-subtitle mb-2">By <a class="text-muted" href="/author/show.php?id=<?php echo $row['author_id']; ?>"><?php echo $row['username']; ?></a></h6>
											</div>
											<a href="/show.php?id=<?php echo $row['book_id']; ?>" class="btn btn-outline-secondary">View more</a>
										</div>
									</div>
								</div>
			<?php   }
						} ?>
				</div>
			</div>
			<div class="container my-5">
				<h2 class="mb-4">All Books</h2>
				<div class="row">
					<?php 
						$sql = "SELECT * FROM books JOIN author ON books.author_id = author.author_id JOIN users ON author.user_id = users.user_id where books.published = 1 ORDER BY book_id DESC";
						$result = mysqli_query($conn, $sql);
						mysql_debug($result,$conn);
						if (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) { ?>
								<div class="col-2 mb-4">
									<div class="card h-100 bg-light shadow-sm">
										<img src="/cover/<?php echo $row['cover']; ?>" class="card-img-top" alt="<?php echo $row['title']; ?>">
										<div class="card-body  d-flex flex-column">
											<div class="flex-grow-1">
												<h5 class="card-title"><?php echo $row['title']; ?></h5>
												<h6 class="card-subtitle mb-2">By <a class="text-muted" href="/author/show.php?id=<?php echo $row['author_id']; ?>"><?php echo $row['username']; ?></a></h6>
											</div>
											<a href="/show.php?id=<?php echo $row['book_id']; ?>" class="btn btn-outline-secondary">View more</a>
										</div>
									</div>
								</div>
			<?php   }
						} ?>
				</div>
			</div>
		</main>
<?php include_once BASE_PATH . '/includes/footer.php'; footer(); ?>