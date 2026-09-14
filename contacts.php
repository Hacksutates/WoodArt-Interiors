<!DOCTYPE HTML>
<html>
	<head>
		<title>Contacts - Landed</title>
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
							<li><a href="contacts.php" class="active">Contacts</a></li>
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
							<h2>Contact Us</h2>
							<p>Get in touch with our team.<br />
							We're here to help with your furniture needs.</p>
						</header>
					</div>
					<a href="#one" class="goto-next scrolly">Next</a>
				</section>

			<!-- One -->
				<section id="one" class="spotlight style1">
					<span class="image fit main"><img src="images/pic02.jpg" alt="" /></span>
					<div class="content" style="top: 50%; left: 50%; transform: translate(-50%, -50%); background: transparent; border: none;">
						<div class="container">
							<div class="row" style="max-width: 50em; margin: 0 auto;">
								<div class="col-12">
									<header>
										<h2 style="font-size: 40px; text-align: center;">Send us a message</h2>
									</header>
									<form method="post" action="assets/php/script.php">
										<div class="row gtr-uniform gtr-50">
											<div class="col-6 col-12-xsmall">
												<input type="text" name="name" id="name" placeholder="Name" required />
											</div>
											<div class="col-6 col-12-xsmall">
												<input type="email" name="email" id="email" placeholder="Email" required />
											</div>
											<div class="col-12">
												<input type="text" name="subject" id="subject" placeholder="Subject" required />
											</div>
											<div class="col-12">
												<textarea name="message" id="message" placeholder="Message" rows="6" required></textarea>
											</div>
											<div class="col-12">
												<ul class="actions">
													<li><input type="submit" name="contact" value="Send Message" class="primary" /></li>
												</ul>
											</div>
										</div>
									</form>
								</div>
							</div>
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