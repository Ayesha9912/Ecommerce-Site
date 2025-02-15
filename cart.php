<?php
session_start();
include_once('./connect.php');
include_once('./wishlist.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $qty = $_POST['qty'];
        $update_qty = $conn->prepare('UPDATE `cart` SET quantity = ? WHERE id = ?');
        $update_qty->execute([$qty, $id]);
        $message[] = 'The cart value is updated';
        // header('location:cart.php');
    }
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $delete_cart = $conn->prepare('DELETE FROM `cart` WHERE id = ? ');
        $delete_cart->execute([$id]);
        $message[] = 'Product Successfully Removed';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .image-box {
        width: 100px;
        height: 100px;
    }
</style>
<body>
    <?php include_once('./components/user_header.php') ?>
    <div class="container mt-5 mb-5">
        <h2 class="mb-4">Shopping Cart</h2>
        <table class="table table-bordered text-center mb-5">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $cart_product = $conn->prepare('SELECT * FROM `cart` WHERE user_id = ?');
                $cart_product->execute([$_SESSION['user_id']]);
                $total_price = 0;
                if ($cart_product->rowCount() > 0) {
                    while ($row = $cart_product->fetch(PDO::FETCH_ASSOC)) {
                        $total_price = +($row['price'] * $row['quantity']);
                        ?>
                        <form method="POST">
                            <tr>
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <td><img src="upload_img/<?php echo $row['image'] ?>" alt="Product" class="img-fluid image-box">
                                </td>
                                <td><?= $row['name'] ?></td>
                                <td>$<?= $row['price'] ?>/-</td>
                                <td>
                                    <input type="number" name="qty" class="form-control" value=<?= $row['quantity'] ?> min="1"
                                        max="99" onkeypress="if(this.value.length === 2) return false"
                                        style="width: 70px; margin: auto;">
                                </td>
                                <td>$<?= $total_price ?></td>
                                <td>
                                    <button name="update" class="btn btn-warning btn-sm">Update</button>
                                    <button onclick="return confirm('Do you want to remove the product?')" name="delete"
                                        class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                        </form>
                        <?php
                    }
                } else { ?>
                    <div class="mt-5 mb-5"
                        style="border:solid 2px black;margin:auto; width:300px; padding:0.5rem 2rem; border-radius:10px;"
                        class="empty">
                        <p class="text-secondary">No Products to be found</p>
                    </div>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <div class="text-end">
            <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
        </div>
    </div>
    <?php include_once('./components/user_footer.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>