<?php
session_start();
if (!isset($_SESSION['ses_data']) || ($_SESSION['ses_data']['role'] ?? '') !== 'craftmen') {
    header('Location: profile.php');
    exit;
}
include "assets/php/connection.php";
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Craftman Status Updates</title>
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
                        <li><a href="craftman_status.php" class="active">My Orders</a></li>
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
                        <h2>My Orders Status</h2>
                        <p>Update the status and completion dates of your assigned orders.</p>
                    </header>
                </div>
                <a href="#one" class="goto-next scrolly">Next</a>
            </section>

            <!-- Orders Section -->
            <section id="one" class="wrapper style1 fade-up">
                <div class="container">
                    <header>
                        <h2>Your Assigned Orders</h2>
                        <p>Edit the deadline, completion date, and status for each order.</p>
                    </header>
                    
                    <div class="table-wrapper">
                        <?php
// ============================================================================
// Fetch orders assigned to the logged-in craftsman with related customer, furniture, and solving details
// ============================================================================
                            $craftman_ID = $_SESSION['ses_data']['id'] ?? null;
                            
                            if (!$craftman_ID) {
                                echo "<p>Error: Craftman ID not found in session.</p>";
                            } else {
                                $query = mysqli_query($connect,
                                    "SELECT 
                                        orders.order_ID, 
                                        customers.full_name AS customer_name,
                                        furnitures.name AS furniture_name, 
                                        solvings.order_date,
                                        solvings.deadline, 
                                        solvings.solving_date, 
                                        solvings.status
                                    FROM orders
                                    JOIN solvings ON orders.order_ID = solvings.order_ID
                                    JOIN customers ON orders.customer_ID = customers.customer_ID
                                    JOIN furnitures ON orders.furniture_ID = furnitures.furniture_ID
                                    WHERE orders.craftman_ID = $craftman_ID
                                    ORDER BY solvings.deadline ASC"
                                );

                                if (mysqli_num_rows($query) > 0) {
                                    echo "<table class='alt' style='width: 100%;'>";
                                    echo "<thead><tr>";
                                    echo "<th style='color: white;'>Order ID</th>";
                                    echo "<th style='color: white;'>Customer</th>";
                                    echo "<th style='color: white;'>Furniture</th>";
                                    echo "<th style='color: white;'>Ordered</th>";
                                    echo "<th style='color: white;'>Deadline</th>";
                                    echo "<th style='color: white;'>Completion</th>";
                                    echo "<th style='color: white;'>Status</th>";
                                    echo "<th style='color: white;'>Action</th>";
                                    echo "</tr></thead><tbody>";

                                    while ($data = mysqli_fetch_assoc($query)) {
                                        echo "<tr>";
                                        echo "<td style='color: white;'>" . htmlspecialchars($data['order_ID']) . "</td>";
                                        echo "<td style='color: white;'>" . htmlspecialchars($data['customer_name']) . "</td>";
                                        echo "<td style='color: white;'>" . htmlspecialchars($data['furniture_name']) . "</td>";
                                        echo "<td style='color: white;'>" . htmlspecialchars($data['order_date']) . "</td>";
                                        echo "<td style='color: white;'>" . htmlspecialchars($data['deadline']) . "</td>";
                                        echo "<td style='color: white;'>" . ($data['solving_date'] ? htmlspecialchars($data['solving_date']) : '—') . "</td>";
                                        echo "<td style='color: white;'><strong>" . htmlspecialchars($data['status']) . "</strong></td>";
                                        echo "<td>";
                                        echo "<form method='POST' action='#' style='display: inline-block;'>";
                                        echo "<input type='hidden' name='order_ID' value='" . $data['order_ID'] . "'>";
                                        echo "<button type='button' onclick='openEditModal(" . $data['order_ID'] . ", \"" . htmlspecialchars($data['deadline']) . "\", \"" . htmlspecialchars($data['solving_date']) . "\", \"" . htmlspecialchars($data['status']) . "\")' class='button' style='cursor: pointer; font-size: 0.8em; padding: 0.5em 1em;'>Edit</button>";
                                        echo "</form>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }

                                    echo "</tbody></table>";
                                } else {
                                    echo "<p style='text-align: center; padding: 2em; color: black;'>No orders assigned to you yet.</p>";
                                }
                            }
                        ?>
                    </div>
                </div>
            </section>

        </div>

        <!-- Edit Modal -->
        <div id="editModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
            <div style="background-color: #fefefe; margin: 5% auto; padding: 2em; border: 1px solid #888; width: 90%; max-width: 500px; border-radius: 8px;">
                <span style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;" onclick="closeEditModal()">&times;</span>
                <h2 style="margin-bottom: 1.5em; color: black;">Update Order Status</h2>
                <form method="POST" action="assets/php/script.php">
                    <input type="hidden" id="modalOrderID" name="order_ID">
                    
                    <div style="margin-bottom: 1.5em;">
                        <label style="display: block; margin-bottom: 0.5em; font-weight: bold; color: black;">Deadline</label>
                        <input type="date" id="modalDeadline" name="deadline" style="width: 100%; padding: 0.75em; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; color: black; box-sizing: border-box;">
                    </div>

                    <div style="margin-bottom: 1.5em;">
                        <label style="display: block; margin-bottom: 0.5em; font-weight: bold; color: black;">Completion Date</label>
                        <input type="date" id="modalSolvingDate" name="solving_date" style="width: 100%; padding: 0.75em; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; color: black; box-sizing: border-box;">
                    </div>

                    <div style="margin-bottom: 1.5em;">
                        <label style="display: block; margin-bottom: 0.5em; font-weight: bold; color: black;">Status <span style="color: red;">*</span></label>
                        <select id="modalStatus" name="status" required style="width: 100%; padding: 0.75em; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; color: black; box-sizing: border-box;">
                            <option value="">-- Select Status --</option>
                            <option value="Not Started">Not Started</option>
                            <option value="In Progress">In Progress</option>
                            <option value="On Hold">On Hold</option>
                            <option value="Completed">Completed</option>
                            <option value="Delayed">Delayed</option>
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1em;">
                        <input type="submit" name="update_status" value="Update" class="button primary" style="cursor: pointer;">
                        <button type="button" onclick="closeEditModal()" class="button" style="cursor: pointer;">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Scripts -->
        <script>
            function openEditModal(orderID, deadline, solvingDate, status) {
                document.getElementById('modalOrderID').value = orderID;
                document.getElementById('modalDeadline').value = deadline;
                document.getElementById('modalSolvingDate').value = solvingDate;
                document.getElementById('modalStatus').value = status;
                document.getElementById('editModal').style.display = 'block';
            }

            function closeEditModal() {
                document.getElementById('editModal').style.display = 'none';
            }

            window.onclick = function(event) {
                const modal = document.getElementById('editModal');
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            }
        </script>

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
