<?php
session_start();
if (!isset($_SESSION['ses_data'])) {
	header('Location: login.php');
	exit;
}
if(isset($_POST["select"])){
    $_SESSION["furniture_ID"] = $_POST["furniture_ID"];
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Furniture</title>
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
							<h2>Furniture Collection</h2>
							<p>Explore our wide range of furniture.<br />
							Find the perfect piece for your home.</p>
						</header>
					</div>
					<a href="#one" class="goto-next scrolly">Next</a>
				</section>

			<!-- Furniture List -->
				<section id="one" class="wrapper style1 fade-up">
					<div class="container">
						<header>
							<h2>Available Furniture</h2>
						</header>
						<form method="POST" action="" style="text-align: center; margin-bottom: 2em;">
							<input type="text" name="find" value="" placeholder="Search by name" style="padding: 0.5em; width: 300px;">
							<input type="submit" name="filter" value="Filter" class="button" style="margin-left: 1em;">
							<input type="submit" name="reset" value="Reset" class="button" style="margin-left: 1em;">
							<?php
// ============================================================================
// Handle filter and reset actions, fetch furniture data, and display count of unique furniture items
// ============================================================================
								include "assets/php/connection.php";
								$query = mysqli_query($connect, "SELECT * FROM furnitures");
								$items = [];
								while($row = mysqli_fetch_assoc($query)) {
									$items[] = $row;
								}
								$filtered = [];
								if(isset($_POST["filter"]) && $_POST["find"]){
									$target = strtolower($_POST["find"]);
									$filtered = array_filter($items, function($row) use ($target) {
										return str_contains(strtolower($row["name"]), $target);
									});
								} else {
									$filtered = $items;
								}
								$count = count(array_unique(array_column($filtered, 'name')));
								echo "<p style='margin-top: 1em;'>Number of unique furniture: <b>$count</b></p>";
							?>
						</form>
						<div class="row">
							<?php
								foreach($filtered as $data) {
									echo '<div class="col-4 col-6-medium col-12-small">';
									echo '<form method="POST" action="" style="border: 1px solid #ddd; padding: 1em; margin-bottom: 1em; text-align: center;">';
									echo '<input type="hidden" name="furniture_ID" value="' . $data['furniture_ID'] . '">';
									echo '<h3>' . $data['name'] . '</h3>';
									echo '<p>Price: ' . $data['price'] . '₸</p>';
									echo '<p>Size: ' . $data['length'] . 'x' . $data['width'] . 'x' . $data['height'] . ' cm</p>';
									echo '<input type="submit" name="select" value="Select" class="button primary">';
									echo '</form>';
									echo '</div>';
								}
							?>
						</div>
					</div>
				</section>

			<!-- Order Form -->
				<section id="two" class="wrapper style2 fade-up">
					<div class="container">
						<header>
							<h2>Place Your Order</h2>
						</header>
						<form method="POST" action="assets/php/script.php" style="max-width: 600px; margin: 0 auto;">
							<div class="row gtr-uniform">
								<div class="col-6 col-12-medium">
									<label>Furniture Code(ID):</label>
									<input type="text" name="furniture_ID" value="<?php echo isset($_SESSION['furniture_ID']) ? $_SESSION['furniture_ID'] : ''; ?>" placeholder="Enter Code" required>
								</div>
								<div class="col-6 col-12-medium">
									<label>Material:</label>
									<select name="material" required>
										<option value="">Choose Material</option>
										<?php
											$query1 = mysqli_query($connect, "SELECT material_ID, name FROM materials");
											while($mat = mysqli_fetch_assoc($query1)) {
												echo "<option value='" . $mat['material_ID'] . "'>" . $mat['name'] . "</option>";
											}
										?>
									</select>
								</div>
								<div class="col-12">
									<label>Address to deliver:</label>
									<input type="text" name="address" placeholder="Enter Address" required>
								</div>
								<div class="col-12">
									<label>Return Date:</label>
									<input style="color: black" type="date" name="return_date" required>
								</div>
								<div class="col-12">
									<input type="submit" name="order" value="Order" class="button primary">
								</div>
							</div>
						</form>
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