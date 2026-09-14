<?php
session_start();
include("assets/php/connection.php");

if (!isset($_SESSION['ses_data']['id']) || $_SESSION['ses_data']['role'] !== 'customers') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['ses_data']['id'];

$query = mysqli_query($connect, "
    SELECT 
        o.order_ID,
        f.name AS furniture_name,
        m.name AS material_name,
        o.address,
        s.order_date,
        s.deadline,
        s.solving_date,
        s.status,
        c.full_name AS craftman_name
    FROM orders o
    JOIN furnitures f ON o.furniture_ID = f.furniture_ID
    JOIN materials m ON o.material_ID = m.material_ID
    JOIN solvings s ON o.order_ID = s.order_ID
    LEFT JOIN craftmen c ON o.craftman_ID = c.craftman_ID
    WHERE o.customer_ID = $user_id
    ORDER BY s.order_date DESC
");

$orders = [];
while ($row = mysqli_fetch_assoc($query)) {
    $orders[] = $row;
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>My Orders</title>
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
                        <li><a href="orders.php" class="active">My Orders</a></li>
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
                        <h2>My Orders</h2>
                        <p>Track the status of your furniture orders.</p>
                    </header>
                </div>
                <a href="#one" class="goto-next scrolly">Next</a>
            </section>

            <!-- Orders -->
            <section id="one" class="wrapper style1 fade-up">
                <div class="container">
                    <header>
                        <h2>Order History</h2>
                        <p>A full list of your submitted orders and their current status.</p>
                    </header>
                    <div class="table-wrapper">
                        <?php if (empty($orders)): ?>
                            <p>You haven't placed any orders yet. <a href="furniture.php">Browse Furniture</a></p>
                        <?php else: ?>
                            <table class="alt">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Furniture</th>
                                        <th>Material</th>
                                        <th>Address</th>
                                        <th>Order Date</th>
                                        <th>Deadline</th>
                                        <th>Solving Date</th>
                                        <th>Status</th>
                                        <th>Craftsman</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($order['order_ID']); ?></td>
                                            <td><?php echo htmlspecialchars($order['furniture_name']); ?></td>
                                            <td><?php echo htmlspecialchars($order['material_name']); ?></td>
                                            <td><?php echo htmlspecialchars($order['address']); ?></td>
                                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                            <td><?php echo htmlspecialchars($order['deadline']); ?></td>
                                            <td><?php echo $order['solving_date'] ? htmlspecialchars($order['solving_date']) : 'Not set'; ?></td>
                                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                                            <td><?php echo $order['craftman_name'] ? htmlspecialchars($order['craftman_name']) : 'Not assigned'; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
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