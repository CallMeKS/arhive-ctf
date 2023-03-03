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
} else {
	$user_id = $_SESSION['id'];
	$username = $_SESSION['username'];
}

if (isset($_GET['s']) && !empty($_GET['s'])) {
	$search = $_GET['s'];
	$sql = "SELECT COUNT(*) FROM books JOIN author ON books.author_id = author.author_id JOIN users ON author.user_id = users.user_id where books.title LIKE '%$search%'";
	$result = mysqli_query($conn, $sql);
	mysql_debug($result,$conn);
	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_assoc($result);
		$search_count = $row['COUNT(*)'];
	} ?>

<?php include_once BASE_PATH . '/includes/header.php'; ?>
<?php include_once BASE_PATH . '/includes/breadcrumbs.php'; breadcrumbs('Search'); ?>
		<div class="p-5 mb-4 bg-light" style="background: url('cover/dull-blue-paint-white.jpg') no-repeat; background-size: cover;">
<?php include_once BASE_PATH . '/includes/alert.php'; ?>
			<div class="container py-2">
				<h1 class="fw-bold">Search result for:</h1>
				<p class="col-md-8 fs-4"><?php echo $_GET['s'];?></p>
			</div>
		</div>
		<main class="flex-shrink-0">
			<div class="container my-5">
				<h2 class="mb-4">Found <?php echo $search_count; ?> books</h2>
				<div class="row">
					<?php
					$sql = "SELECT books.book_id, books.cover, books.title, books.published, author.author_id, users.username FROM books JOIN author ON books.author_id = author.author_id JOIN users ON author.user_id = users.user_id where books.title LIKE '%$search%'";
					$result = mysqli_query($conn, $sql);
					mysql_debug($result,$conn);
					if (mysqli_num_rows($result) > 0) {
						while($row = mysqli_fetch_assoc($result)) { ?>
					<div class="col-2 mb-4">
						<div class="card h-100 bg-light shadow-sm">
							<img src="/cover/<?php echo $row['cover']; ?>" class="card-img-top" alt="<?php echo $row['title']; ?>">
							<div class="card-body d-flex flex-column">
								<div class="flex-grow-1">
									<h5 class="card-title"><?php echo $row['title']; ?>
									<?php if($row['published'] == 0){ ?>
										<span class="badge bg-secondary">Unpublished</span>
									<?php } ?>
									</h5>
									<h6 class="card-subtitle mb-2">By <a class="text-muted" href="/author/show.php?id=<?php echo $row['author_id']; ?>"><?php echo $row['username']; ?></a></h6>
								</div>
								<a href="/show.php?id=<?php echo $row['book_id']; ?>" class="btn btn-outline-secondary">View more</a>
							</div>
						</div>
					</div>
			<?php  }
					} else {
						echo "<p>No search query found. Try other keywords.</p>";
					} ?>
				</div>
			</div>
		</main>
<?php include_once BASE_PATH .'/includes/footer.php'; footer();
} ?>