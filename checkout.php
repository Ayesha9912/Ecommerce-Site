<?php
session_start();
include_once('./connect.php');
$grand_total = 0;
$total_product = 0;


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['place_order'])){
      
        $name = $_POST['name'];
        $number = $_POST['number'];
        $email = $_POST['email'];
        $method = $_POST['method'];
        $address = $_POST['address'];
        $total_product = $_POST['total_product'];
        $grand_total = $_POST['grand_total'];

        ////order_items
        $product_name = $_POST['product_name'];
        $product_id = $_POST['product_id'];
        $product_qty = $_POST['product_qty'];
        $product_price = $_POST['product_price'];
        
        $place_order = $conn->prepare('INSERT INTO `orders` (user_id , name, number , email, method, address, total_products, total_price) VALUES (?,?,?,?,?,?,?,?)');
        $place_order->execute([$_SESSION['user_id'], $name, $number , $email, $method , $address, $total_product, $grand_total]);
        
        $order_id = $conn->lastInsertId();
        
        // Insert all products from the cart into order_items
        $order_items = $conn->prepare('INSERT INTO `order_items` (order_id, product_id, product_name, product_price, product_quantity, user_id) VALUES (?, ?, ?, ?, ?, ?)');
        
        for ($i = 0; $i < count($product_id); $i++) {
            $order_items->execute([$order_id, $product_id[$i], $product_name[$i], $product_price[$i], $product_qty[$i], $_SESSION['user_id']]);
        }
        ///Delete the products from the cart
        $cart_delete =  $conn->prepare('DELETE  FROM `cart` WHERE user_id = ?');
        $cart_delete->execute([$_SESSION['user_id']]);
        header('location:thank-you-page.php');
        exit();

    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include_once('./components/user_header.php') ?>
    <div class="container mt-5">
        <h2 class="mb-4">Checkout</h2>
        <form method="POST">
            <div class="row">
                <div class="col-md-6">
                    <h4>Billing Details</h4>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select class="form-control" name="method" required>
                            <option value="cash_on_delivery">Cash on Delivery</option>
                            <option value="paypal">PayPal</option>
                            <option value="card_payment">Card Payment</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4>Order Summary</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cart_pro = $conn->prepare('SELECT * FROM `cart` WHERE user_id = ?');
                            $cart_pro->execute([$_SESSION['user_id']]);
                            $total_price = 0;
                            if ($cart_pro->rowCount() > 0){
                                $total_product = $cart_pro->rowCount();
                                while ($row = $cart_pro->fetch(PDO::FETCH_ASSOC)){
                                    $total_price =+ ($row['price'] * $row['quantity']); 
                                    $grand_total += $total_price;?>
                                <tr>
                                <input type="hidden" name="total_product" value="<?=$total_product?>">
                                <input type="hidden" name="product_name[]" value="<?=$row['name']?>">
                                <input type="hidden" name="product_id[]" value="<?=$row['id']?>">
                                <input type="hidden" name="product_qty[]" value="<?=$row['quantity']?>">
                                <input type="hidden" name="product_price[]" value="<?=$row['price']?>">
                                <td><?=$row['name']?></td>
                                <td><?=$row['quantity']?></td>
                                <td>$<?=$total_price?></td>
                            </tr>
                            <?php
                                }?>  
                            <tr>
                                <td><strong>Total</strong></td>
                                <td></td>
                                <td><strong>$<?=$grand_total?></strong></td>
                                <input type="hidden" name="grand_total" value="<?=$grand_total?>">
                            </tr>
                          <?php
                            }
                            ?>
                        </tbody>
                    </table>
                  
                    <button name="place_order" class="btn btn-primary w-100">Place Order</button>
                </div>
            </div>
        </form>
    </div>
    <?php include_once('./components/user_footer.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>