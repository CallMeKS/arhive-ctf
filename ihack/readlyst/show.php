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

if (isset($_GET['id']) && !empty($_GET['id'])) {
	$book_id = $_GET['id'];
	$sql = "SELECT * FROM books WHERE book_id = $book_id";
	$result = mysqli_query($conn, $sql);
	mysql_debug($result, $conn);
	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_assoc($result);
		$book_title = $row['title'];
		$book_desc = $row['description'];
		$book_cover = $row['cover'];
		$author_id = $row['author_id'];
		$published = $row['published'];

		$sql = "SELECT users.username FROM users JOIN author ON users.user_id = author.user_id WHERE author.author_id = $author_id";
		$result = mysqli_query($conn, $sql);
		mysql_debug($result, $conn);
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_assoc($result);
			$author_name = $row['username'];
		}

		function readlyst($conn, $user_id, $book_id) {
			$sql = "SELECT * FROM read_list WHERE user_id = $user_id AND book_id = $book_id";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result, $conn);
			if (mysqli_num_rows($result) == 1) {
				return True;
			} else {
				return False;
			}
		}

		function likes($conn, $user_id, $book_id) {
			$sql = "SELECT * FROM book_likes WHERE user_id = $user_id AND book_id = $book_id";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result, $conn);
			if (mysqli_num_rows($result) == 1) {
				return True;
			} else {
				return False;
			}
		}

		function countLikes($conn, $book_id) {
			$sql = "SELECT COUNT(*) FROM book_likes where book_id = $book_id";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result, $conn);
			if (mysqli_num_rows($result) == 1) {
				$row = mysqli_fetch_assoc($result);
				return $row['COUNT(*)'];
			}
		}

		function countComents($conn, $book_id) {
			$sql = "SELECT COUNT(*) from comments WHERE book_id = $book_id";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result, $conn);
			if (mysqli_num_rows($result) == 1) {
				$row = mysqli_fetch_assoc($result);
				return $row['COUNT(*)'];
			}
		}

		function isYourComment($conn, $user_id, $comment_id) {
			$sql = "SELECT * FROM comments WHERE user_id = $user_id AND comment_id = $comment_id";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result, $conn);
			if (mysqli_num_rows($result) == 1) {
				return True;
			} else {
				return False;
			}
		}

		function yourRating($conn, $user_id, $book_id) {
			$sql = "SELECT * FROM book_rating WHERE user_id = $user_id AND book_id = $book_id";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result, $conn);
			if (mysqli_num_rows($result) == 1) {
				$row = mysqli_fetch_assoc($result);
				return $row['rating'];
			} else {
				return False;
			}
		}

		function avgRating($conn, $book_id) {
			$sql = "SELECT AVG(rating) FROM book_rating WHERE book_id = $book_id";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result, $conn);
			if (mysqli_num_rows($result) == 1) {
				$row = mysqli_fetch_assoc($result);
				return round($row['AVG(rating)']);
			} else {
				return "None";
			}
		}

		function totalRating($conn, $book_id) {
			$sql = "SELECT COUNT(*) FROM book_rating WHERE book_id = $book_id";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result, $conn);
			if (mysqli_num_rows($result) == 1) {
				$row = mysqli_fetch_assoc($result);
				return $row['COUNT(*)'];
			} else {
				return "0";
			}
		}

		function isAuthor($conn, $user_id) {
			$sql = "SELECT * FROM author WHERE user_id = $user_id";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result, $conn);
			if (mysqli_num_rows($result) == 1) {
				return True;
			} else {
				return False;
			}
		}

		if (isset($_POST['rate']) && !empty($_POST['rate'])) {
			$rating = $_POST['rate'];
			$sql = "SELECT * FROM book_rating WHERE user_id = $user_id AND book_id = $book_id";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result, $conn);
			if (mysqli_num_rows($result) == 1) {
				$sql = "UPDATE book_rating SET rating = '$rating' WHERE user_id = $user_id AND book_id = $book_id";
				$result = mysqli_query($conn, $sql);
				mysql_debug($result, $conn);
				$_SESSION['message'] = "rating updated";
				header("Location: /show.php?id=$book_id");
				exit();
			} else {
				$sql = "INSERT INTO book_rating (book_id, user_id, rating) VALUES ($book_id, $user_id, $rating)";
				$result = mysqli_query($conn, $sql);
				mysql_debug($result, $conn);
				$_SESSION['message'] = "you rate $rating stars";
				header("Location: /show.php?id=$book_id");
				exit();
			}
		}

		if (isset($_GET['action']) && !empty($_GET['action'])) {
			$action = $_GET['action'];
			if ($action == 'readlyst') {
				if (readlyst($conn, $user_id, $book_id)) {
					$sql = "DELETE FROM read_list WHERE user_id = $user_id AND book_id = $book_id";
					$result = mysqli_query($conn, $sql);
					mysql_debug($result, $conn);
					$_SESSION['message'] = "Removed from ReadLyst";
					header("Location: /show.php?id=$book_id");
					exit();
				} else {
					$sql = "INSERT INTO read_list (book_id, user_id) VALUES ($book_id, $user_id)";
					$result = mysqli_query($conn, $sql);
					mysql_debug($result, $conn);
					$_SESSION['message'] = "Added to ReadLyst";
					header("Location: /show.php?id=$book_id");
					exit();
				}
			} else if ($action == 'likes') {
				if (likes($conn, $user_id, $book_id)) {
					$sql = "DELETE FROM book_likes WHERE user_id = $user_id AND book_id = $book_id";
					$result = mysqli_query($conn, $sql);
					mysql_debug($result, $conn);
					$_SESSION['message'] = "Removed from Likes";
					header("Location: /show.php?id=$book_id");
					exit();
				} else {
					$sql = "INSERT INTO book_likes (book_id, user_id) VALUES ($book_id, $user_id)";
					$result = mysqli_query($conn, $sql);
					mysql_debug($result, $conn);
					$_SESSION['message'] = "Added to Likes";
					header("Location: /show.php?id=$book_id");
					exit();
				}
			}
		}

		if (isset($_GET['cid']) && isset($_GET['c_action'])) {
			if (!empty($_GET['cid']) && !empty($_GET['c_action'])) {
				$action = $_GET['c_action'];
				$comment_id = $_GET['cid'];
				$sql = "SELECT * FROM comments WHERE user_id = $user_id AND comment_id = $comment_id";
				$result = mysqli_query($conn, $sql);
				mysql_debug($result, $conn);
				if (mysqli_num_rows($result) == 1) {
					$row = mysqli_fetch_assoc($result);
					$comment = $row['comment'];
				}

				if ($action == 'edit') {
					if (isYourComment($conn, $user_id, $comment_id)) {
						if (isset($_POST['comment']) && !empty($_POST['comment'])) {
							$comment = $_POST['comment'];
							$sql = "UPDATE comments SET comment = '$comment', timestamp = NOW() WHERE comment_id = $comment_id";
							$result = mysqli_query($conn, $sql);
							mysql_debug($result, $conn);
							$_SESSION['message'] = "comment updated";
							header("Location: /show.php?id=$book_id");
							exit();
						}
					} else {
						$_SESSION['message'] = "You cannot edit other people comment";
						header("Location: /show.php?id=$book_id");
						exit();
					}
				} else if ($action == 'delete') {
					if (isYourComment($conn, $user_id, $comment_id)) {
						$sql = "DELETE FROM comments WHERE comment_id = $comment_id";
						$result = mysqli_query($conn, $sql);
						mysql_debug($result, $conn);
						$_SESSION['message'] = "comment deleted";
						header("Location: /show.php?id=$book_id");
						exit();
					} else {
						$_SESSION['message'] = "You cannot delete other people comment";
						header("Location: /show.php?id=$book_id");
						exit();
					}
				}
			}
		}

		if (isset($_POST['comment']) && !empty($_POST['comment'])) {
			$comment = $_POST['comment'];
			$sql = "INSERT INTO comments (user_id,book_id,comment) VALUES ($user_id,$book_id,'$comment')";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result, $conn);
			$_SESSION['message'] = "comment submitted";
			header("Location: /show.php?id=$book_id");
			exit();
		}

		?>
		<?php	include BASE_PATH . '/includes/header.php';?>
		<div class="bg-light" style="position:relative;">
			<?php include BASE_PATH . '/includes/alert.php';?>
			<div class="cover-backdrop" style="background-image: url('cover/<?php echo $book_cover; ?>');"></div>
			<div class="container my-5">
				<div class="row">
					<div class="col-2">
						<div class="card bg-transparent h-100" style="border: none">
							<img src="cover/<?php echo $book_cover; ?>" class="card-img-top shadow" alt="<?php echo $book_title; ?>">
							<div class="mt-3 d-flex justify-content-between">
								<a href="/show.php?id=<?php echo $book_id; ?>&action=readlyst" style="font-size: .875em !important" class="flex-fill btn btn-outline-light <?php if (readlyst($conn, $user_id, $book_id)) {?>active">Added to ReadLyst</a><?php } else {?>">Add to ReadLyst</a><?php }?>
								<a href="/show.php?id=<?php echo $book_id; ?>&action=likes" style="font-size: .875em !important" class="ms-1 btn btn-outline-light <?php if (likes($conn, $user_id, $book_id)) {?> active"><i class="bi bi-hand-thumbs-up-fill text-info"></i></a><?php } else {?>"><i class="bi bi-hand-thumbs-up"></i></a><?php }?>
							</div>
						</div>
					</div>
					<div class="col ms-2" style="z-index: 1;">
						<h2 class="mb-4"><?php echo $book_title; ?>
						<?php if($published == 0){ ?>
							<span class="badge bg-secondary">Unpublished</span>
						<?php } ?>
						</h2>
						<p class="mb-0">By <a class="text-dark" href="/author/show.php?id=<?php echo $author_id; ?>"><?php echo $author_name; ?></a></p>
						<div class="d-flex flex-row">
							<form method="POST" action="" class="rate">
								<?php
									$avgRating = avgRating($conn, $book_id);
									for ($x = 5; $x >= 1; $x--) {
										if ($x == $avgRating) {
											echo "<input type=\"radio\" id=\"star$x\" name=\"rate\" value=\"$x\" checked onclick=\"this.form.submit();\" />";
										} else {
											echo "<input type=\"radio\" id=\"star$x\" name=\"rate\" value=\"$x\" onclick=\"this.form.submit();\" />";
										}
										echo "<label for=\"star$x\" title=\"text\">$x stars</label>";
									} ?>
							</form>
							<small style="line-height: 2.5;"><?php echo totalRating($conn, $book_id); ?> Ratings</small>
							<?php if (yourRating($conn, $user_id, $book_id)) { ?>
									<small class="ms-1" style="line-height: 2.5;">(You rated <?php echo yourRating($conn, $user_id, $book_id); ?> stars)</small>
							<?php	}?>
							<div class="ms-3" style="line-height: 2.2;">
								<i class="bi bi-hand-thumbs-up-fill"></i> <?php echo countLikes($conn, $book_id); ?> likes
							</div>
						</div>
						<p class="mt-3"><?php echo $book_desc; ?></p>
					</div>
				</div>
			</div>
		</div>
		<main class="flex-shrink-0 bg-light">
			<div class="container my-5">
				<h4 class="mb-4">Community Reviews <?php echo "(" . countComents($conn, $book_id) . ")"; ?></h4>
				<form method="POST" action="">
					<div class="form-floating mb-3">
						<textarea class="form-control" name="comment" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"><?php if (isset($comment)) {echo $comment;}?></textarea>
						<label for="floatingTextarea2">Share your thoughts</label>
					</div>
					<button type="submit" class="btn btn-outline-primary"><?php if (isset($comment)) {echo "Update";} else {echo "Submit";}?></button>
				</form>
				<hr>
				<div class="d-flex flex-column">
				<?php
					$sql = "SELECT comments.comment_id, comments.user_id, users.username, comments.comment, comments.timestamp from comments JOIN users ON comments.user_id = users.user_id WHERE book_id = $book_id ORDER BY comment_id";
					$result = mysqli_query($conn, $sql);
					mysql_debug($result, $conn);
					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							$username = $row['username'];
							$user_id = $row['user_id'];
							$timestamp = $row['timestamp'];
							$comment_id = $row['comment_id'];
							$comment = $row['comment'];?>
							<div class="card shadow-sm mb-3">
								<div class="card-body">
									<div class="card-title mb-3">
										<div class="d-flex align-items-center">
											<img class="rounded-circle" src="/avatar.php?name=<?php echo $username; ?>">
											<div class="ms-3">
												<div class="fw-bold"><?php echo $username; ?></div>
												<?php
													if (isAuthor($conn, $user_id)) { ?>
												<div class="text-muted small d-flex">
													<p class="fw-lighter me-1 mb-0">ReadLyst Author</p>
													<i class="bi bi-patch-check-fill"></i>
												</div>
												<?php }?>
												<div class="text-muted small"><?php echo $timestamp; ?></div>
											</div>
										</div>
									</div>
									<p><?php echo $comment; ?></p>
								</div>
								<?php if (isYourComment($conn, $_SESSION['id'], $comment_id)) {?>
								<div class="card-footer text-muted bg-transparent">
									<a href="?id=<?php echo $book_id; ?>&cid=<?php echo $comment_id; ?>&c_action=edit" class="btn btn-outline-secondary">Edit</a>
									<a href="?id=<?php echo $book_id; ?>&cid=<?php echo $comment_id; ?>&c_action=delete" class="btn btn-outline-danger">Delete</a>
								</div>
							<?php } ?>
							</div>
			<?php }
					} else {
						echo "<p>Be the first to comment.</p>";
					}
		?>
				</div>
			</div>
		</main>
		<section class="bg-white">
			<div class="container my-5">
				<h2 class="mb-4">You might also like</h2>
				<div class="row">
				<?php
					$sql = "SELECT r1.book_id, r1.cover, r1.published, r1.title, author.author_id, users.username FROM books AS r1 JOIN author ON r1.author_id = author.author_id JOIN users ON author.user_id = users.user_id JOIN (SELECT CEIL(RAND() * (SELECT MAX(book_id) FROM books)) AS id) AS r2 WHERE r1.published = 1 AND r1.book_id >= r2.id AND r1.book_id <> $book_id ORDER BY r1.book_id ASC LIMIT 3";
					$result = mysqli_query($conn, $sql);
					mysql_debug($result, $conn);
					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) { ?>
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
			<?php }
					} ?>
				</div>
			</div>
		</section>
<?php include_once BASE_PATH . '/includes/footer.php'; footer();
	} else {
		echo "Book not found";
		exit();
	}
} else {
	echo "Missing param id";
	exit();
}
?>
