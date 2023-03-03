<?php 
if (!defined('BASE_PATH')) define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
require_once BASE_PATH . '/includes/config.php';

if(isset($_GET['action']) && isset($_GET['id'])) {
	if (!empty($_GET['action']) && !empty($_GET['id'])) {
		$book_id = $_GET['id'];
		$action = $_GET['action'];
		if ($action == 'remove') {
			$sql = "DELETE FROM read_list WHERE user_id = $user_id AND book_id = $book_id";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result,$conn);
			if (mysqli_affected_rows($conn)) {
				$_SESSION['message'] = "Removed from ReadLyst";
				header("Location: /profile.php?p=readlyst");
				exit();
			} else {
				$_SESSION['message'] = "Book not found in your ReadLyst";
				header("Location: /profile.php?p=readlyst");
				exit();
			}
		}
	}
}
?>

<h4>ReadLyst</h4>
<p class="mb-4 text-muted">Books that you want to read</p>
<table class="table table-hover">
	<thead class="table-light">
		<tr>
			<td>Title</td>
			<td colspan="2">Author</td>
		</tr>
	</thead>
	<tbody>
		<?php 
			$sql = "SELECT books.title, books.book_id, users.username FROM users INNER JOIN author ON users.user_id = author.user_id INNER JOIN books ON books.author_id = author.author_id INNER JOIN read_list ON read_list.book_id = books.book_id WHERE read_list.user_id = $user_id";
			$result = mysqli_query($conn, $sql);
			mysql_debug($result,$conn);
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) { 
				$book_id = $row['book_id'];
				$book_title = $row['title']; ?>
					<tr>
						<td><a class="text-muted" href="/show.php?id=<?php echo $book_id; ?>"><?php echo $book_title; ?></a></td>
						<td><?php echo $row['username']; ?></td>
						<td class="text-end"><a href="?p=readlyst&id=<?php echo $book_id; ?>&action=remove" class="btn btn-sm btn-outline-danger"><i class="bi bi-x"></i> remove</a></td>
					</tr>
 <?php  }
			} ?>
	</tbody>
</table>
