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
        <title>Manager Requests</title>
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
                            <li><a href="manager_requests.php" class="active">Requests</a></li>
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
                            <h2>Manager Requests</h2>
                            <p>Review and approve customer order requests for production.</p>
                        </header>
                    </div>
                    <a href="#one" class="goto-next scrolly">Next</a>
                </section>

            <!-- Requests -->
                <section id="one" class="wrapper style1 fade-up">
                    <div class="container">
                        <header>
                            <h2>Pending Requests</h2>
                            <p>Approve or reject requests submitted by customers.</p>
                        </header>
                        <?php
                            if (isset($_SESSION["message"])) {
                                echo "<p style='margin-bottom:1.5rem; color:#2d2d2d; font-weight:600;'>" . $_SESSION["message"] . "</p>";
                                unset($_SESSION["message"]);
                            }
                        ?>
                        <div class="table-wrapper">
                            <?php
// ============================================================================
// Fetch pending requests with related customer, furniture, material, and craftsman details for display in the manager dashboard
// ============================================================================
                                $query = mysqli_query($connect,
                                    "SELECT
                                        requests.request_ID,
                                        requests.customer_ID,
                                        requests.furniture_ID,
                                        requests.material_ID,
                                        customers.full_name AS customer_name,
                                        furnitures.name AS furniture_name,
                                        materials.name AS material_name,
                                        requests.address,
                                        requests.return_date,
                                        requests.status
                                    FROM requests
                                    JOIN customers ON requests.customer_ID = customers.customer_ID
                                    JOIN furnitures ON requests.furniture_ID = furnitures.furniture_ID
                                    JOIN materials ON requests.material_ID = materials.material_ID
                                    WHERE requests.status = 'checking'"
                                );

                                $craftmen_result = mysqli_query($connect, "SELECT craftman_ID, full_name FROM craftmen");
                                $craftmen = [];
                                while ($craftman = mysqli_fetch_assoc($craftmen_result)) {
                                    $craftmen[] = $craftman;
                                }

                                if (mysqli_num_rows($query) > 0) {
                                    echo "<table class='alt'>";
                                    echo "<thead><tr>";
                                    echo "<th>Request #</th>";
                                    echo "<th>Customer</th>";
                                    echo "<th>Furniture</th>";
                                    echo "<th>Material</th>";
                                    echo "<th>Address</th>";
                                    echo "<th>Return Date</th>";
                                    echo "<th>Status</th>";
                                    echo "<th>Actions</th>";
                                    echo "</tr></thead><tbody>";

                                    while ($data = mysqli_fetch_assoc($query)) {
                                        echo "<tr>";
                                        echo "<td>" . $data['request_ID'] . "</td>";
                                        echo "<td>" . $data['customer_name'] . "</td>";
                                        echo "<td>" . $data['furniture_name'] . "</td>";
                                        echo "<td>" . $data['material_name'] . "</td>";
                                        echo "<td>" . $data['address'] . "</td>";
                                        echo "<td>" . $data['return_date'] . "</td>";
                                        echo "<td>" . $data['status'] . "</td>";
                                        echo "<td>";
                                        echo "<form method='POST' action='assets/php/script.php' style='display:inline-block; margin-right:0.5em; vertical-align:top;'>";
                                        echo "<input type='hidden' name='request_ID' value='" . $data['request_ID'] . "'>";
                                        echo "<select name='craftman_ID' required>";
                                        echo "<option value=''>Choose craftsman</option>";
                                        foreach ($craftmen as $craftman) {
                                            echo "<option value='" . $craftman['craftman_ID'] . "'>" . $craftman['full_name'] . "</option>";
                                        }
                                        echo "</select>";
                                        echo "<input type='submit' name='accept_request' value='Accept' class='button primary'>";
                                        echo "</form>";
                                        echo "<form method='POST' action='assets/php/script.php' style='display:inline-block;'>";
                                        echo "<input type='hidden' name='request_ID' value='" . $data['request_ID'] . "'>";
                                        echo "<input type='submit' name='reject_request' value='Reject' class='button'>";
                                        echo "</form>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }

                                    echo "</tbody></table>";
                                } else {
                                    echo "<p>No pending requests right now.</p>";
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
