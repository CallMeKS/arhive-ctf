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

if (isset($_GET['delete'])) {
	$sql = "DELETE FROM users WHERE user_id = $user_id";
	$result = mysqli_query($conn, $sql);
	mysql_debug($result,$conn);
	header("Location: /logout.php");
	exit();
} ?>

<?php include_once BASE_PATH . '/includes/header.php'; ?>
		<main class="flex-grow-1 bg-light">
			<div class="container my-5">
				<?php include_once BASE_PATH . '/includes/alert.php'; ?>
				<h3>Profile Settings</h3>
				<div class="card mt-4">
					<div class="card-body d-flex" style="min-height: 50vh;">
						<div class="row flex-grow-1">
							<div class="col-3">
								<div class="d-flex flex-column h-100 justify-content-between">
									<div class="list-group list-group-flush">
										<a href="?p=changepasswd" class="list-group-item list-group-item-action">Edit Profile</a>
										<a href="?p=likedbooks" class="list-group-item list-group-item-action">Liked Books</a>
										<a href="?p=readlyst" class="list-group-item list-group-item-action">ReadLyst</a>
									</div>
									<button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete Account</button>
								</div>
							</div>
							<div class="col p-4 pb-0 ms-3">
								<?php
									if (isset($_GET['p'])) {
										$page = preg_replace('/\.\.\//',"",$_GET['p']);
										include_once BASE_PATH . '/page/'.$page.'.php';
									} else {
										include_once BASE_PATH . '/page/changepasswd.php';
									}
								?>
							</div>
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
						Are you sure you want to delete your account?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<a href="?delete" type="button" class="btn btn-danger">Delete</a>
					</div>
				</div>
			</div>
		</div>

		<?php include_once BASE_PATH . '/includes/footer.php'; footer(1); ?>