<!DOCTYPE HTML>
	Landed by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Login</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body>
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header">
					<h1 id="logo"><a href="index.php">Landed</a></h1>
					<nav id="nav">
						<ul>
							<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
							<?php if (isset($_SESSION['ses_data']['full_name'])): ?>
								<li><a href="profile.php">Profile</a></li>
							<?php endif; ?>
							<li>
								<a href="furniture.php">Products</a>
								<ul>
									<li><a href="furniture.php">Furniture</a></li>
									<li><a href="material.php">Material</a></li>
								</ul>
							</li>
							<li><a href="contacts.php">Contacts</a></li>
							<?php if (!isset($_SESSION['ses_data']['full_name'])): ?>
								<li><a href="login.php" class="button primary">Sign In</a></li>
							<?php endif; ?>
						</ul>
					</nav>
				</header>

			<!-- Banner -->
				<section id="banner">
					<div class="content">
						<form method="post" action="assets/php/script.php">
							<div class="row gtr-uniform gtr-50">
								<div class="col-12 col-12-xsmall">
								<input type="text" name="login" id="name" value="" placeholder="Login" />
								</div>
								<div class="col-12 col-12-xsmall">
								<input type="password" name="password" id="name" value="" placeholder="Password" />
								</div>
								<div class="col-12">
								<ul class="actions">
									<li><input type="submit" name="sign_in" value="Sign In" class="primary"></li>
								</ul>
								</div>
								<div class="col-4" style="text-align: left;">
								<p>Don't have an account? <a href="registration.php">Sign Up</a></p>
								</div>
								<?php
									if (isset($_SESSION['message'])) {
										echo '<div class="col-12" style="text-align: center;"><p style="color: red;">' . $_SESSION['message'] . '</p></div>';
										unset($_SESSION['message']);
									}
								?>
							</div>
						</form>
									<li><a type="button" href="face.html" name="" value="Face Recognition" class="primary">Face Recognition</a></li>
					</div>
				</section>
		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
