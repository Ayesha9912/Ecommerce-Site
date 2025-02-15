<?php
session_start();
include_once('./connect.php');
$id = $_GET['pid'];
include_once('wishlist.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quick View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .quick-view-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            background: #f8f8f8;
            border-radius: 10px;
        }

        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .thumbnail-images img {
            width: 70px;
            height: 70px;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .thumbnail-images img:hover,
        .thumbnail-images img.active {
            border-color: black;
        }

        .btn-cart {
            background-color: #0d6efd;
            color: white;
        }

        .btn-wishlist {
            background-color: #f59e0b;
            color: white;
        }
    </style>
</head>

<body>
    <?php include_once('./components/user_header.php') ?>
    <div class="container">
        <h2 class="text-center fw-bold mt-5">QUICK VIEW</h2>
        <div class="quick-view-container shadow">
            <div class="row">
                <?php
                $select_product = $conn->prepare('SELECT * FROM `products` WHERE id = ?');
                $select_product->execute([$id]);
                $row = $select_product->fetch(PDO::FETCH_ASSOC);

                ?>
                <div class="col-md-6">
                    <img id="main-img" src="upload_img/<?php echo $row['image_01']; ?>" alt="<?= $row['name'] ?>"
                        class="product-image w-100">
                    <div class="d-flex mt-3 justify-content-center thumbnail-images">
                        <img src="upload_img/<?php echo $row['image_01']; ?>" onclick="getimg(this)" class="me-2"
                            alt="Thumbnail 1">
                        <img src="upload_img/<?php echo $row['image_02']; ?>" onclick="getimg(this)" class="me-2"
                            alt="Thumbnail 2">
                        <img src="upload_img/<?php echo $row['image_03']; ?>" onclick="getimg(this)" alt="Thumbnail 3">
                    </div>
                </div>
                <div class="col-md-6">

                    <h4><?= $row['name'] ?></h4>
                    <p class="text-danger fw-bold fs-5">$<?= $row['price'] ?>/-</p>
                    <p><?= $row['details'] ?></p>
                    <form method="POST">
                        <input type="hidden" name="pid" value="<?= $row['id'] ?>">
                        <input type="hidden" name="image" value="<?php echo $row['image_01']; ?>">
                        <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                        <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                        <div class="d-flex align-items-center">
                            <input name="qty" id="qty" type="number" class="form-control w-25 me-3 text-center" min="1"
                                max="99" onkeypress="if(this.value.length == 2) return false" value="1">
                        </div>
                        <div class="mt-3">
                            <button name="add_to_cart" class="btn btn-success">Add To Cart</button>
                            <button name="add_to_wishlist" class="btn btn-info">Add To Wishlist</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('./components/user_footer.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function getimg(element) {
            document.getElementById('main-img').src = element.src
        }
    </script>
</body>

</html>