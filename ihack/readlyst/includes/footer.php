<?php function footer($small=0) { ?>
	<footer class="footer mt-auto py-3" style="background-color:#eff1f2;">
<?php if (!$small) { ?>
		<section class="container-fluid">
				<div class="container py-5">
					<div class="row">
						<div class="col-2">
							<p class="fw-bold mb-3">ReadLyst</p>
							<ul class="list-unstyled">
								<li>About Us</li>
								<li>Terms</li>
								<li>Privacy</li>
								<li>Preference</li>
							</ul>
						</div>
						<div class="col-2">
							<p class="fw-bold mb-3">Work With Us</p>
							<ul class="list-unstyled">
								<li>Sign Up</li>
								<li>Login</li>
							</ul>
						</div>
						<div class="col">
							<p class="fw-bold mb-3">Links</p>
							<ul class="list-unstyled">
								<li>Home</li>
								<li>Browse</li>
								<li>Features</li>
								<li>Price</li>
							</ul>
						</div>
					</div>
				</div>
			</section>
<?php  } ?>
	<div class="container">
				<small class="text-muted">This fictitious web is brought to you by NetByteSEC</small>
			</div>
		</footer>
		<script src="/assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>
	</body>
</html>
<?php } ?>