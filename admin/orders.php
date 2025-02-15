<?php
session_start();
include_once('../connect.php');
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_order'])) {
        $payment_status = filter_var($_POST['payment_status'], FILTER_SANITIZE_STRING);
        $order_id = $_POST['id'];
        $update_status = $conn->prepare('UPDATE `orders` SET payment_status = ? WHERE id = ?');
        $update_status->execute([$payment_status, $order_id]);
        $message[] = 'Payment_status is updated';
    }

    if (isset($_POST['delete_order'])) {
        $id = $_POST['id'];
        $delete_order = $conn->prepare('DELETE FROM `orders` WHERE id = ?');
        $delete_order->execute([$id]);
        $message[] = "order is deleted successfully";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Placed Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .order-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            background: #fff;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .blue-text {
            color: #007bff;
            font-weight: 500;
        }
    </style>
</head>

<body class="bg-light">
    <?php include('../components/admin_header.php') ?>
    <div class="container py-5">
        <h2 class="text-center mb-4">PLACED ORDERS</h2>
        <div class="row justify-content-center">
            <?php
            $select_orders = $conn->prepare('SELECT * FROM `orders`');
            $select_orders->execute();
            if ($select_orders->rowCount() > 0) {
                while ($result = $select_orders->fetch(PDO::FETCH_ASSOC)) { ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="order-card">
                            <form method="POST">
                                <p><strong>Placed on:</strong> <span class="blue-text"><?= $result['placed_on'] ?></span></p>
                                <p><strong>Name:</strong> <span class="blue-text"><?= $result['name']; ?></span></p>
                                <p><strong>Number:</strong> <span class="blue-text"><?= $result['number']; ?></span></p>
                                <p><strong>Address:</strong> <span class="blue-text"><?= $result['address']; ?></span></p>
                                <p><strong>Total Products:</strong> <span
                                        class="blue-text"><?= $result['total_products']; ?></span>
                                </p>
                                <p><strong>Total Price:</strong> <span class="blue-text"><?= $result['total_price']; ?></span>
                                </p>
                                <p><strong>Payment Method:</strong> <span class="blue-text"><?= $result['method']; ?></span></p>
                                <p><strong>Payment Status:</strong> <span
                                        class="blue-text"><?= $result['payment_status']; ?></span></p>
                                <?php if ($result['payment_status'] === 'delivered') { ?>


                                    <?php

                                } else if ($result['payment_status'] === 'shipped') { ?>
                                        <select class="form-select mb-3" name="payment_status">
                                            <option value="shipped">Shipped</option>
                                            <option value="delivered">Delivered</option>
                                        </select>


                                    <?php

                                } else { ?>
                                  <select class="form-select mb-3" name="payment_status">
                                           <option value="pending">Pending</option>
                                            <option value="shipped">Shipped</option>
                                            <option value="delivered">Delivered</option>
                                        </select>


                                    <?php

                                } ?>


                                <input type="hidden" name="id" values="<?= $result['id'] ?>">


                                <div class="d-flex justify-content-between">
                                    <input type="hidden" name="id" value="<?= $result['id'] ?>">
                                    <button name="update_order" class="btn btn-warning">Update</button>
                                    <button name="delete_order" class="btn btn-danger">Delete</button>

                                </div>
                            </form>
                        </div>
                    </div>


                    <?php
                }
            } else { ?>
                <div class="mt-5"
                    style="border:solid 2px black;margin:auto; width:300px; padding:0.5rem 2rem; border-radius:10px;"
                    class="empty">
                    <p class="text-secondary">No orders to be found</p>
                </div>

                <?php

            }
            ?>

        </div>
    </div>
    <?php include_once('../components/footer.php') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>