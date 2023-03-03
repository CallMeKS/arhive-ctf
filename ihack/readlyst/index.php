<?php 
if (!defined('BASE_PATH')) define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
require_once BASE_PATH . '/includes/config.php';

if (!isset($_SESSION)) {
	session_start();
}

?>
<?php include_once BASE_PATH . '/includes/header.php'; ?>
		<div class="p-5 mb-4 bg-light" style="background: url('cover/dull-blue-paint-white.jpg') no-repeat; background-size: cover;">
			<?php include_once BASE_PATH . '/includes/alert.php'; ?>
			<div class="container py-5">
				<h1 class="display-5 fw-bold">Discover awesome books</h1>
				<p class="col-md-8 fs-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. </p>
				<a href="explore.php" class="btn btn-outline-primary btn-lg" type="button">Explore books</a>
			</div>
		</div>
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
			<section class="container-fluid bg-light">
				<div class="container py-5">
					<div class="row">
						<div class="col-5">
							<h2>Deciding what to read next?</h2>
							<p>You’re in the right place. Tell us what titles or genres you’ve enjoyed in the past, and we’ll give you surprisingly insightful recommendations. </p>
							<a href="/explore.php" class="btn btn-outline-secondary">Explore</a>
						</div>
						<div class="col-5">
							<h2>What are your friends reading?</h2>
							<p>Chances are your friends are discussing their favorite (and least favorite) books on ReadLyst.</p>
							<a href="/register.php" class="btn btn-outline-secondary">Register now</a>
						</div>
					</div>
				</div>
			</section>
		</main>
<?php include_once BASE_PATH . '/includes/footer.php'; footer(); ?>