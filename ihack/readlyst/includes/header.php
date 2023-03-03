<?php 
if (!defined('BASE_PATH')) define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
require_once BASE_PATH . '/includes/config.php';
include_once BASE_PATH . '/includes/head.php'; ?>

	<body class="d-flex flex-column min-vh-100">
		<nav class="py-2 bg-light border-bottom">
			<div class="container g-1 d-flex flex-wrap">
				<ul class="nav me-auto">
					<li class="nav-item"><a href="/" class="nav-link link-dark px-2 active" aria-current="page">Home</a></li>
					<li class="nav-item"><a href="/explore.php" class="nav-link link-dark px-2">Explore</a></li>
					<li class="nav-item"><a href="#" class="nav-link link-dark px-2">Pricing</a></li>
					<li class="nav-item"><a href="#" class="nav-link link-dark px-2">FAQs</a></li>
					<li class="nav-item"><a href="#" class="nav-link link-dark px-2">About</a></li>
				</ul>
				<ul class="nav">
					<?php 
						if (isset($_SESSION['username'])) {
						$username = $_SESSION['username']; ?>
					<li class="nav-item d-flex d-flex-row">
						<img class="rounded-circle img-fluid" style="height:38px;" src="/avatar.php?name=<?php echo $username; ?>">
						<div class="dropdown">
							<button class="btn btn-transparent dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
							<?php echo $username; ?>
							</button>
							<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
								<li><a class="dropdown-item" href="/profile.php">Visit Profile</a></li>
								<li><a class="dropdown-item" href="/profile.php?p=readlyst">ReadLyst</a></li>
								<li><a class="dropdown-item" href="/profile.php?p=changepasswd">Change Password</a></li>
								<li><a class="dropdown-item" href="/profile.php?p=likedbooks">Liked Books</a></li>
								<?php if ($_SESSION['is_author']) { ?>
								<li><a class="dropdown-item" href="/author/index.php">Author settings</a></li>
								<?php } ?>
							</ul>
						</div>
					</li>
					<li class="nav-item"><a href="/logout.php" class="nav-link link-dark px-2">Log out</a></li>
					<?php } else { ?>
					<li class="nav-item">
						<div class="dropdown">
							<button class="btn btn-transparent dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
							Login
							</button>
							<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1" style="width: 400px">
								<form class="px-4 py-3" method="POST" action="/login.php">
									<div class="mb-3">
										<label for="exampleDropdownFormEmail1" class="form-label">Email address</label>
										<input type="email" name="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
									</div>
									<div class="mb-3">
										<label for="exampleDropdownFormPassword1" class="form-label">Password</label>
										<input type="password" name="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
									</div>
									<button type="submit" class="btn btn-outline-primary">Sign in</button>
								</form>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="/register.php">New around here? Sign up</a>
							</ul>
						</div>
					</li>
					<li class="nav-item"><a href="/register.php" class="nav-link link-dark px-2">Sign up</a></li>
					<?php	} ?>
				</ul>
			</div>
		</nav>
		<header class="py-3 border-bottom">
			<div class="container d-flex flex-wrap justify-content-center">
				<a href="/" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
					<span class="fs-4" style="font-family: 'Dancing Script', cursive;">ReadLyst</span>
				</a>
				<form class="col-12 col-lg-auto mb-3 mb-lg-0" method="GET" action="/search.php">
					<input type="search" name="s" class="form-control" placeholder="Search..." aria-label="Search">
				</form>
			</div>
		</header>