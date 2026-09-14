<?php
// ============================================================================
// Admin dashboard page - displays current orders and pending requests for managers, with options to edit or delete orders
// ============================================================================
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
        <title>Admin Dashboard</title>
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
                            <li><a href="admin.php" class="active">Admin</a></li>
                            <?php if (isset($_SESSION['ses_data']['role']) && $_SESSION['ses_data']['role'] === 'managers'): ?>
                                <li><a href="registration_m.php">Registration</a></li>
                                <li><a href="add_furniture.php">Add Furniture</a></li>
                                <li><a href="add_material.php">Add Material</a></li>
                                <li><a href="manager_requests.php">Manager Requests</a></li>
                            <?php endif; ?>
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
                            <h2>Admin Dashboard</h2>
                            <p>Manage orders, update statuses, and keep production on track.</p>
                        </header>
                    </div>
                    <a href="#one" class="goto-next scrolly">Next</a>
                </section>

            <!-- Orders -->
                <section id="one" class="wrapper style1 fade-up">
                    <div class="container">
                        <header>
                            <h2>Current Orders</h2>
                            <p>Review incoming orders and choose edit or delete actions.</p>
                        </header>
                        <div class="table-wrapper">
                            <?php
// ============================================================================
//  Fetch orders with related customer, craftsman, furniture, and solving details   
// ============================================================================
                                $query = mysqli_query($connect,
                                    "SELECT 
                                        orders.order_ID, 
                                        customers.full_name AS customer_name,
                                        craftmen.full_name AS craftman_name,
                                        furnitures.name AS furniture_name, 
                                        solvings.order_date,
                                        solvings.deadline, 
                                        solvings.solving_date, 
                                        solvings.status
                                    FROM orders
                                    JOIN solvings ON orders.order_ID = solvings.order_ID
                                    JOIN customers ON orders.customer_ID = customers.customer_ID
                                    JOIN craftmen ON orders.craftman_ID = craftmen.craftman_ID
                                    JOIN furnitures ON orders.furniture_ID = furnitures.furniture_ID"
                                );

                                if (mysqli_num_rows($query) > 0) {
                                    echo "<table class='alt'>";
                                    echo "<thead><tr>";
                                    echo "<th>Order ID</th>";
                                    echo "<th>Customer</th>";
                                    echo "<th>Craftsman</th>";
                                    echo "<th>Furniture</th>";
                                    echo "<th>Ordered</th>";
                                    echo "<th>Deadline</th>";
                                    echo "<th>Solved</th>";
                                    echo "<th>Status</th>";
                                    echo "<th>Actions</th>";
                                    echo "</tr></thead><tbody>";

                                    while ($data = mysqli_fetch_assoc($query)) {
                                        echo "<tr>";
                                        echo "<td>" . $data['order_ID'] . "</td>";
                                        echo "<td>" . $data['customer_name'] . "</td>";
                                        echo "<td>" . $data['craftman_name'] . "</td>";
                                        echo "<td>" . $data['furniture_name'] . "</td>";
                                        echo "<td>" . $data['order_date'] . "</td>";
                                        echo "<td>" . $data['deadline'] . "</td>";
                                        echo "<td>" . ($data['solving_date'] ? $data['solving_date'] : '—') . "</td>";
                                        echo "<td>" . $data['status'] . "</td>";
                                        echo "<td>";
                                        echo "<form method='POST' action='assets/php/script.php' style='display:inline-block; margin-right:0.5em;'>";
                                        echo "<input type='hidden' name='order_ID' value='" . $data['order_ID'] . "'>";
                                        echo "<input type='submit' name='edit' value='Edit' class='button'>";
                                        echo "</form>";
                                        echo "<form method='POST' action='assets/php/script.php' style='display:inline-block;'>";
                                        echo "<input type='hidden' name='order_ID' value='" . $data['order_ID'] . "'>";
                                        echo "<input type='submit' name='delete' value='Delete' class='button'>";
                                        echo "</form>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }

                                    echo "</tbody></table>";
                                } else {
                                    echo "<p>No orders found.</p>";
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
