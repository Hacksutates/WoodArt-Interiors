<?php
session_start();
if (!isset($_SESSION['ses_data'])) {
	header('Location: login.php');
	exit;
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Materials</title>
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
						<header>
							<h2>Materials Collection</h2>
							<p>Explore our wide range of materials.<br />
							Choose the best for your furniture.</p>
						</header>
					</div>
					<a href="#one" class="goto-next scrolly">Next</a>
				</section>

			<!-- Materials List -->
				<section id="one" class="wrapper style1 fade-up">
					<div class="container">
						<header>
							<h2>Available Materials</h2>
						</header>
						<div class="row">
							<?php
								include "assets/php/connection.php";
								$query = mysqli_query($connect, "SELECT * FROM materials");
								while($data = mysqli_fetch_assoc($query)) {
									echo '<div class="col-4 col-6-medium col-12-small">';
									echo '<div style="border: 1px solid #ddd; padding: 1em; margin-bottom: 1em; text-align: center;">';
									echo '<h3>' . $data['name'] . '</h3>';
									echo '<h3>' . $data['price'] . '₸</h3>';
									echo '</div>';
									echo '</div>';
								}
							?>
						</div>
					</div>
				</section>

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