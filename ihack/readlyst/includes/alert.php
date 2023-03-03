<?php if (isset($_SESSION['mysql_error'])){
	foreach($_SESSION['mysql_error'] as $mysql_error) { ?>
		<div class="container mt-3 alert shadow alert-warning alert-dismissible fade show" style="z-index: 1;" role="alert">
			<?php echo $mysql_error; ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	<?php } 
unset($_SESSION['mysql_error']); } ?>

<?php if (isset($_SESSION['message'])){ ?>		
<div class="container mt-3 alert shadow alert-info alert-dismissible fade show" style="z-index: 1;" role="alert">
	<?php 
		echo $_SESSION['message']; 
		unset($_SESSION['message']);
	?>
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php } ?>