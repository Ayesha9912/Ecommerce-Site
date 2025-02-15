<?php
session_start();
include_once('./connect.php');
include_once('./wishlist.php');
$category = $_GET['category'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
</head>

<body>
    <?php include_once('./components/user_header.php') ?>
    <div class="container">
        <h1 class="text-center mt-5"><?= $category ?></h1>
        <div class="container">
            <div class="row">
                <?php
                $products = $conn->prepare('SELECT * FROM `products` WHERE category = ?');
                $products->execute([$category]);
                if ($products->rowCount() > 0) {
                    while ($row = $products->fetch(PDO::FETCH_ASSOC)) { ?>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <form method="POST">
                                <div class="card p-3 border rounded shadow-sm">
                                <input type="hidden" name="pid" value="<?=$row['id']?>">
                                <input type="hidden" name="image" value="<?php echo $row['image_01']; ?>">
                                <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                                <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                                    <div class="position-relative">
                                        <img src="upload_img/<?= $row['image_01']; ?>" class="img-fluid rounded"
                                            alt="<?= $row['name']; ?>">
                                        <a href="quick_view.php?pid=<?= $row['id'];?>" class="btn text-dark btn-light position-absolute top-0 start-0 m-2 border rounded-circle">
                                             <i class="fas fa-eye"></i></a>
                                        <button name="add_to_wishlist"
                                            class="btn btn-light position-absolute top-0 end-0 m-2 border rounded-circle">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </div>
                                    <div class="text-center mt-3">
                                        <h5><?= $row['name']; ?></h5>
                                        <p class="text-danger fw-bold">$<?= $row['price']; ?>/-</p>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <input id="qty" name="qty" type="number" class="form-control w-25 text-center me-2" value="1" min="1" max="99" onkeypress="if(this.value.length == 2) return false">
                                            <button name="add_to_cart" class="btn btn-success">Add To Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php }
                }
                ?>
            </div>
        </div>

    </div>



</body>

</html>