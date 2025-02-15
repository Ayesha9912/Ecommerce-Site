<?php
session_start();
include_once('../connect.php');
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['add_product'])) {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
            $description = filter_var($_POST['detail'], FILTER_SANITIZE_STRING);
            $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
            ;

            $image_folder = '../upload_img';
            // if (!mkdir($image_folder, 0777, true)) {
            //     throw new Exception('Image folder doesnnot form');
            // }

            $image_01 = filter_var($_FILES['image_01']['name'], FILTER_SANITIZE_STRING);
            $image_size_01 = $_FILES['image_01']['size'];
            $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
            $image_type_01 = $_FILES['image_01']['type'];
            $image_folder_01 = '../upload_img/'.$image_01.'';

            $image_02 = filter_var($_FILES['image_02']['name'], FILTER_SANITIZE_STRING);
            $image_size_02 = $_FILES['image_02']['size'];
            $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
            $image_type_02 = $_FILES['image_02']['type'];
            $image_folder_02 = '../upload_img/'.$image_02.'';


            $image_03 = filter_var($_FILES['image_03']['name'], FILTER_SANITIZE_STRING);
            $image_size_03 = $_FILES['image_03']['size'];
            $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
            $image_type_03 = $_FILES['image_03']['type'];
            $image_folder_03 = '../upload_img/'.$image_03.'';

            $image_size = 1024 * 1024 * 2;
            $file_type = ['image/png' , 'image/jpg', 'image/jpeg']; 

            $select_products = $conn->prepare('SELECT * FROM `products` WHERE name = ?');
            $select_products->execute([$name]);

            if($select_products->rowCount() > 0){
                $message[] = 'product name already exist!';
            }else{
                if($image_size_01 > $image_size OR $image_size_02 > $image_size OR $image_size_03 > $image_size){
                    throw new Exception('Image size is too large');
                }
                if(!in_array($image_type_01,$file_type) OR !in_array($image_type_02,$file_type) OR !in_array( $image_type_03, $file_type)){
                  throw new Exception('File type not allowed');
                }
                $insert_product = $conn->prepare('INSERT INTO `products` (name, category, details, price, image_01, image_02, image_03) VALUES (?,?,?,?,?,?,?)');
                $insert_product->execute([$name, $category, $description, $price, $image_01, $image_02, $image_03]);
                $message[] = "Product Uploaded Successfully";

                move_uploaded_file($image_tmp_name_01, $image_folder_01);
                move_uploaded_file($image_tmp_name_02, $image_folder_02);
                move_uploaded_file($image_tmp_name_03, $image_folder_03);
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
   $select_deleted_img =  $conn->prepare('SELECT * FROM `products` WHERE id = ?');
   $select_deleted_img->execute([$delete_id]);
   $fetch_delete_image = $select_deleted_img->fetch(PDO::FETCH_ASSOC);
   unlink('../upload_img/'.$fetch_delete_image['image_01']);
   unlink('../upload_img/'.$fetch_delete_image['image_02']);
   unlink('../upload_img/'.$fetch_delete_image['image_03']);
    $delete_product = $conn->prepare('DELETE FROM `products` WHERE id = ?');
    $delete_product->execute([$delete_id]);
    $product_delete_cart = $conn->prepare('DELETE FROM `cart` WHERE pid=?');
    $product_delete_cart->execute([$delete_id]);
    $product_delete_wishlist = $conn->prepare('DELETE FROM `wishlist` WHERE pid=?');
    $product_delete_wishlist->execute([$delete_id]);
    header('location:products.php');
    $message[] = 'Product has Successfully deleted';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('../components/admin_header.php') ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-4">
                    <h2 class="text-center mb-4">ADD PRODUCT</h2>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Product Name (required)</label>
                                <input name="name" type="text" class="form-control" placeholder="Enter product name"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Product Price (required)</label>
                                <input name="price" type="text" class="form-control" placeholder="Enter product price"
                                    required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Image 01 (required)</label>
                                <input name="image_01" type="file" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Image 02 (required)</label>
                                <input name="image_02" type="file" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Image 03 (required)</label>
                                <input name="image_03" type="file" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Product Details (required)</label>
                                <input name="detail" type="text" class="form-control"
                                    placeholder="Enter product details" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <select class="form-select" name="category">
                                    <option value="">Select Category</option>
                                    <option value="phones">Phones</option>
                                    <option value="watches">Watches</option>
                                    <option value="laptop">laptop</option>
                                    <option value="systems">systems</option>
                                </select>
                            </div>
                        </div>

                        <button name="add_product" type="submit" class="btn btn-primary w-100">Add Product</button>
                    </form>
                </div>
            </div>
        </div>

        <h2 class="text-center mt-4">All PRODUCT</h2>
        <div class="row justify-content-center mb-5">
            <?php
            $select_products = $conn->prepare('SELECT * FROM `products`');
            $select_products->execute();
            if ($select_products->rowCount() > 0) {
                while ($row = $select_products->fetch(PDO::FETCH_ASSOC)) { ?>
                    <div class="col col-md-4 mt-5 mb-5">
                        <div class="card text-center p-3 shadow-sm">
                            <img src="../upload_img/<?= $row['image_01']; ?>" class="card-img-top img-fluid" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title"><?=$row['name']?></h5>
                                <p class="text-primary fw-bold">$<?=$row['price']?>/-</p>
                                <p class="card-text text-muted"><?=$row['details']?></p>
                                <p class="card-text text-muted"><?=$row['category']?></p>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="update_product.php?update=<?=$row['id']?>" class="btn btn-warning px-4">Update</a>
                                    <a href="products.php?delete=<?=$row['id']?>" onclick="return confirm('Do you want to delete the product')" class="btn btn-danger px-4">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else { ?>
                <div class="mt-5"
                    style="border:solid 2px black;margin:auto; width:300px; padding:0.5rem 2rem; border-radius:10px;"
                    class="empty">
                    <p class="text-secondary">No Products to be found</p>
                </div>
                <?php
            }
            ?>

        </div>


    </div>
    <?php include('../components/footer.php') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>