<?php
session_start();
include_once('./connect.php');
$pending_orders = 0;
$completed_orders = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
        }

        .dashboard-container {
            max-width: 1100px;
            margin: auto;
            padding: 20px;
        }

        .welcome-card {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            padding: 30px;
            border-radius: 12px;
        }

        .stat-card {
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: 0.3s;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .icon-box {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .recent-orders {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <?php include_once('./components/user_header.php') ?>
    <div class="dashboard-container mb-5 mt-5">

        <!-- Welcome Card -->
        <!-- <div class="welcome-card mb-4">
            <h2>Welcome Back, <span>User</span> 👋</h2>
            <p>Check your latest orders, wishlist, and profile details.</p>
        </div> -->

        <!-- Order Summary Cards -->
        <!-- <?php $get_orders = $conn->prepare('SELECT * FROM `order_items` WHERE user_id = ?');
        $get_orders->execute([$_SESSION['user_id']]);
        $total_orders = $get_orders->rowCount();
        $row = $get_orders->fetch(PDO::FETCH_ASSOC);

        $order_status = $conn->prepare('SELECT * FROM `orders` WHERE id = ?');
        $order_status->execute([$row['order_id']]);
        $result = $order_status->fetch(PDO::FETCH_ASSOC);

        if ($result) {  // Check if order data exists
            if ($result['payment_status'] === 'pending') {
                $pending_orders = $get_orders->rowCount();  // Increase pending orders count
            } elseif ($result['payment_status'] === 'delivered') {
                $completed_orders = $get_orders->rowCount();  // Increase completed orders count
            }
        }
        



        ?>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-box text-primary">📦</div>
                    <h5>Total Orders</h5>
                    <h3><?= $total_orders ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-box text-warning">⌛</div>
                    <h5>Pending Orders</h5>
                    <h3><?=$pending_orders?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-box text-success">✅</div>
                    <h5>Completed Orders</h5>
                    <h3><?=$completed_orders?></h3>
                </div>
            </div>
        </div> -->

        <div class="row g-3 mt-3">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-box text-info">📜</div>
                    <h5>My Orders</h5>
                    <a href="#orders" class="btn btn-outline-primary btn-sm mt-2">View</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-box text-danger">❤️</div>
                    <h5>Wishlist</h5>
                    <a href="wishlist_pro.php" class="btn btn-outline-danger btn-sm mt-2">View</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon-box text-secondary">👤</div>
                    <h5>Profile</h5>
                    <a href="user_profile.php" class="btn btn-outline-dark btn-sm mt-2">Edit</a>
                </div>
            </div>
        </div>
        <!-- Recent Orders -->
        <div id="orders" class="recent-orders mt-4">
            <h4>Recent Orders</h4>
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>#Order</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $get_orders = $conn->prepare('SELECT * FROM `order_items` WHERE user_id = ?');
                    $get_orders->execute([$_SESSION['user_id']]);

                    if ($get_orders->rowCount() > 0) {
                        while ($row = $get_orders->fetch(PDO::FETCH_ASSOC)) { ?>
                            <tr>
                                <td>#<?= $row['order_id'] ?></td>
                                <td><?= $row['product_name'] ?></td>
                                <td><?= $row['product_quantity'] ?></td>
                                <td><?= $row['product_price'] ?></td>
                                <?php
                                $order_status = $conn->prepare('SELECT * FROM `orders` WHERE id = ?');
                                $order_status->execute([$row['order_id']]);
                                $result = $order_status->fetch(PDO::FETCH_ASSOC);
                                $btn_class = '';
                                if ($result['payment_status'] === 'delivered') {
                                    $btn_class = 'btn btn-success';
                                } else if ($result['payment_status'] === 'shipped') {
                                    $btn_class = 'btn btn-warning';
                                } else if ($result['payment_status'] === 'pending') {
                                    $btn_class = 'btn btn-primary';
                                }
                                ?>
                                <td><span class="<?= $btn_class ?>"><?= $result['payment_status'] ?></span></td>
                            </tr>

                            <?php

                        }


                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    <?php include_once('./components/user_footer.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>