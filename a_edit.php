<?php
session_start();
if (!isset($_SESSION['ses_data']) || ($_SESSION['ses_data']['role'] ?? '') !== 'managers') {
    header('Location: profile.php');
    exit;
}
include "assets/php/connection.php";
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Edit Order</title>
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
                            <li><a href="admin.php">Admin</a></li>
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
                            <h2>Edit Order</h2>
                            <p>Update order schedule and status from the admin panel.</p>
                        </header>
                    </div>
                    <a href="#one" class="goto-next scrolly">Next</a>
                </section>

            <!-- Edit Form -->
                <section id="one" class="wrapper style2 fade-up">
                    <div class="container">
                        <header>
                            <h2>Order Details</h2>
                        </header>
                        <?php
                            if (isset($_SESSION['ses_data'])) {
                                $order_id = intval($_SESSION['order_ID']);
                                $query = mysqli_query($connect,
                                    "SELECT 
                                        orders.order_ID,
                                        orders.customer_ID,
                                        orders.furniture_ID,
                                        orders.material_ID,
                                        orders.craftman_ID,
                                        orders.address,
                                        orders.request_id,
                                        solvings.order_date,
                                        solvings.deadline,
                                        solvings.solving_date,
                                        solvings.status
                                    FROM orders
                                    JOIN solvings ON orders.order_ID = solvings.order_ID
                                    WHERE orders.order_ID = $order_id"
                                );
                                $data = mysqli_fetch_assoc($query);

                                if ($data) {
                                    echo "<div style='background: white; padding: 2em; border-radius: 8px; margin-bottom: 2em;'>";
                                    echo "<form method='POST' action='assets/php/script.php'>";
                                    echo "<input type='hidden' name='order_ID' value='" . $order_id . "'>";
                                    echo "<div class='table-wrapper'><table class='alt'>";
                                    echo "<thead><tr>";
                                    echo "<th style='color: black;'>Customer ID</th>";
                                    echo "<th style='color: black;'>Furniture ID</th>";
                                    echo "<th style='color: black;'>Material ID</th>";
                                    echo "<th style='color: black;'>Craftman ID</th>";
                                    echo "<th style='color: black;'>Address</th>";
                                    echo "</tr></thead>";
                                    echo "<tbody><tr>";
                                    echo "<td><input type='text' name='customer_ID' value='" . htmlspecialchars($data['customer_ID']) . "' style='color: black; border: 1px solid #ddd; padding: 0.5em; border-radius: 4px;'></td>";
                                    echo "<td><input type='text' name='furniture_ID' value='" . htmlspecialchars($data['furniture_ID']) . "' style='color: black; border: 1px solid #ddd; padding: 0.5em; border-radius: 4px;'></td>";
                                    echo "<td><input type='text' name='material_ID' value='" . htmlspecialchars($data['material_ID']) . "' style='color: black; border: 1px solid #ddd; padding: 0.5em; border-radius: 4px;'></td>";
                                    echo "<td><input type='text' name='craftman_ID' value='" . htmlspecialchars($data['craftman_ID']) . "' style='color: black; border: 1px solid #ddd; padding: 0.5em; border-radius: 4px;'></td>";
                                    echo "<td><input type='text' name='address' value='" . htmlspecialchars($data['address']) . "' style='color: black; border: 1px solid #ddd; padding: 0.5em; border-radius: 4px;'></td>";
                                    echo "</tr></tbody></table></div>";

                                    echo "<div class='table-wrapper' style='margin-top: 2em;'><table class='alt'>";
                                    echo "<thead><tr>";
                                    echo "<th style='color: black;'>Order Date</th>";
                                    echo "<th style='color: black;'>Deadline</th>";
                                    echo "<th style='color: black;'>Solving Date</th>";
                                    echo "<th style='color: black;'>Status</th>";
                                    echo "</tr></thead>";
                                    echo "<tbody><tr>";
                                    echo "<td><input type='date' name='order_date' value='" . $data['order_date'] . "' style='color: black; border: 1px solid #ddd; padding: 0.5em; border-radius: 4px;'></td>";
                                    echo "<td><input type='date' name='deadline' value='" . $data['deadline'] . "' style='color: black; border: 1px solid #ddd; padding: 0.5em; border-radius: 4px;'></td>";
                                    echo "<td><input type='date' name='solving_date' value='" . $data['solving_date'] . "' style='color: black; border: 1px solid #ddd; padding: 0.5em; border-radius: 4px;'></td>";
                                    echo "<td><input type='text' name='status' value='" . htmlspecialchars($data['status']) . "' style='color: black; border: 1px solid #ddd; padding: 0.5em; border-radius: 4px;'></td>";
                                    echo "</tr></tbody></table></div>";
                                    echo "<input style='border: 1px solid #ddd; padding: 0.5em; border-radius: 4px;' type='submit' name='update' value='Update' class='button primary' style='margin-top: 2em;'>";
                                    echo "</form>";
                                    echo "</div>";
                                } else {
                                    echo "<p>No order found for editing.</p>";
                                }
                            } else {
                                header('Location: login.php');
                                exit;
                            }
                        ?>
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
