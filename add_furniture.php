<?php
session_start();
if (!isset($_SESSION['ses_data']) || ($_SESSION['ses_data']['role'] ?? '') !== 'managers') {
    header('Location: profile.php');
    exit;
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Add Furniture</title>
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
                                <li><a href="add_furniture.php">Add Furniture</a></li>
                                <li><a href="add_material.php">Add Material</a></li>
                            </ul>
                        </li>
                        <li><a href="contacts.php">Contacts</a></li>
                        <li><a href="admin.php">Admin</a></li>
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
                        <h2>Add New Furniture</h2>
                        <p>Create and add a new furniture item to the catalog.</p>
                    </header>
                </div>
                <a href="#one" class="goto-next scrolly">Next</a>
            </section>

            <!-- Form Section -->
            <section id="one" class="wrapper style1 fade-up">
                <div class="container">
                    <div style="max-width: 600px; margin: 0 auto; background: #323232; padding: 2em; border: 1px solid #ddd; border-radius: 8px;">
                        <form method="POST" action="assets/php/script.php">
                            <div style="margin-bottom: 1.5em;">
                                <label for="furniture_name" style="display: block; margin-bottom: 0.5em; font-weight: bold;">Furniture Name <span style="color: red;">*</span></label>
                                <input type="text" id="furniture_name" name="furniture_name" required style="width: 100%; padding: 0.75em; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; box-sizing: border-box;">
                            </div>

                            <div style="margin-bottom: 1.5em;">
                                <label for="price" style="display: block; margin-bottom: 0.5em; font-weight: bold;">Price (₸) <span style="color: red;">*</span></label>
                                <input type="number" id="price" name="price" required step="0.01" min="0" style="width: 100%; padding: 0.75em; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; box-sizing: border-box; color: black;">
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1em; margin-bottom: 1.5em;">
                                <div>
                                    <label for="length" style="display: block; margin-bottom: 0.5em; font-weight: bold;">Length (cm) <span style="color: red;">*</span></label>
                                    <input type="number" id="length" name="length" required step="0.1" min="0" style="width: 60%; padding: 0.75em; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; box-sizing: border-box; color: black;">
                                </div>

                                <div>
                                    <label for="width" style="display: block; margin-bottom: 0.5em; font-weight: bold;">Width (cm) <span style="color: red;">*</span></label>
                                    <input type="number" id="width" name="width" required step="0.1" min="0" style="width: 60%; padding: 0.75em; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; box-sizing: border-box; color: black;">
                                </div>

                                <div>
                                    <label for="height" style="display: block; margin-bottom: 0.5em; font-weight: bold;">Height (cm) <span style="color: red;">*</span></label>
                                    <input type="number" id="height" name="height" required step="0.1" min="0" style="width: 60%; padding: 0.75em; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; box-sizing: border-box; color: black;">
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1em;">
                                <input type="submit" name="add_furniture" value="Add Furniture" class="button primary" style="cursor: pointer;">
                                <a href="furniture.php" class="button" style="text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center;">Back to Furniture</a>
                            </div>
                        </form>
                    </div>
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
