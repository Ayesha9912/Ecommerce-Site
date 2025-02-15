<?php
session_start();
include_once('../connect.php');
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['update'])) {
            $pid = $_POST['pid'];
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
            $details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);
            $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
            $update_product = $conn->prepare('UPDATE `products` SET name = ?, category=?, price = ? , details = ? WHERE id = ?');
            $update_product->execute([$name,$category, $price, $details, $pid]);
            $image_01 = filter_var($_FILES['image_01']['name'] , FILTER_SANITIZE_STRING);
            $old_image_01 = $_POST['old_img_01'];
                $image_size = 1024 * 1024 * 2;
                $image_size_01 = $_FILES['image_01']['size'];
                $image_folder_01 = '../upload_img/'.$image_01;
                $image_tmp_01 = $_FILES['image_01']['tmp_name'];
            if(!empty($image_01)){
                if($image_size_01 > $image_size){
                    $message[] = 'Image1 is too large';
                }else{
                    $update_image_01 = $conn->prepare('UPDATE `products` SET image_01 = ? WHERE id = ?');
                    $update_image_01->execute([$image_01, $pid]);
                    unlink('../upload_img/'.$old_image_01);
                    move_uploaded_file($image_tmp_01, $image_folder_01);
                    $message[] = "Image 1 is updated";
                }
            }
            $image_02 = filter_var($_FILES['image_02']['name'] , FILTER_SANITIZE_STRING);
            $old_image_02 = $_POST['old_img_02'];
                $image_size = 1024 * 1024 * 2;
                $image_size_02 = $_FILES['image_02']['size'];
                $image_folder_02 = '../upload_img/'.$image_02;
                $image_tmp_02 = $_FILES['image_02']['tmp_name'];
            if(!empty($image_02)){
                if($image_size_02 > $image_size){
                    $message[] = 'Image1 is too large';
                }else{
                    $update_image_02 = $conn->prepare('UPDATE `products` SET image_02 = ? WHERE id = ?');
                    $update_image_02->execute([$image_02, $pid]);
                    unlink('../upload_img/'.$old_image_02);
                    move_uploaded_file($image_tmp_02, $image_folder_02);
                    $message[] = "Image 2 is updated";
                }
            }
            $image_03 = filter_var($_FILES['image_03']['name'] , FILTER_SANITIZE_STRING);
            $old_image_03 = $_POST['old_img_03'];
                $image_size = 1024 * 1024 * 2;
                $image_size_03 = $_FILES['image_03']['size'];
                $image_folder_03 = '../upload_img/'.$image_03;
                $image_tmp_03 = $_FILES['image_03']['tmp_name'];
            if(!empty($image_03)){
                if($image_size_03 > $image_size){
                    $message[] = 'Image1 is too large';
                }else{
                    $update_image_03 = $conn->prepare('UPDATE `products` SET image_03 = ? WHERE id = ?');
                    $update_image_03->execute([$image_03, $pid]);
                    unlink('../upload_img/'.$old_image_03);
                    move_uploaded_file($image_tmp_03, $image_folder_03);
                    $message[] = "Image 3 is updated";
                }
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .image-preview {
            width: 100%;
            max-height: 250px;
            object-fit: cover;
            border-radius: 5px;
        }

        .thumbnail {
            width: 60px;
            height: 60px;
            object-fit: cover;
            margin: 5px;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .thumbnail:hover {
            border-color: #007bff;
        }
    </style>
</head>

<body>
    <?php include('../components/admin_header.php') ?>
    <div class="container mt-4 mb-5">
        <div class="row justify-content-center mb-5">
            <div class="col-md-6 mt-5">
                <h2 class="text-center">UPDATE PRODUCT</h2>
                <div class="card mt-5 p-4 shadow">
                    <?php
                    $update_id = $_GET['update'];
                    $select_data = $conn->prepare('SELECT * FROM `products` WHERE id = ?');
                    $select_data->execute([$update_id]);
                    $row = $select_data->fetch(PDO::FETCH_ASSOC);
                    if ($select_data->rowCount() > 0) {
                        ?>
                        <form class="mt-3" method="POST" enctype="multipart/form-data">
                            <!-- Image Preview -->
                            <input type="hidden" name="pid" value="<?= $row['id'] ?>">
                            <input type="hidden" name="old_img_01" value="<?= $row['image_01'] ?>">
                            <input type="hidden" name="old_img_02" value="<?= $row['image_02'] ?>">
                            <input type="hidden" name="old_img_03" value="<?= $row['image_03'] ?>">
                            <img src="<?= '../upload_img/' . $row['image_01'] ?>" class="image-preview img-fluid mb-2"
                                id="mainImage">

                            <!-- Thumbnails -->
                            <div class="d-flex justify-content-center">
                                <img src="<?= '../upload_img/' . $row['image_01'] ?>" class="thumbnail"
                                    onclick="updateMainImage(this)">
                                <img src="<?= '../upload_img/' . $row['image_02'] ?>" class="thumbnail"
                                    onclick="updateMainImage(this)">
                                <img src="<?= '../upload_img/' . $row['image_03'] ?>" class="thumbnail"
                                    onclick="updateMainImage(this)">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Update Name</label>
                                <input name="name" type="text" class="form-control" value="<?= $row['name'] ?>">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Update Price</label>
                                <input name="price" type="number" class="form-control" value=<?= $row['price'] ?>>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Update Details</label>
                                <textarea name="details" class="form-control" rows="3"><?= $row['details'] ?></textarea>
                            </div>
                            <div class="mb-2">
                                <p>Current: <?=$row['category']?></p>
                            </div>
                            <div class="mb-2">
                            <select class="form-select" name="category">
                                    <option value="">Update Category</option>
                                    <option value="phones">Phones</option>
                                    <option value="watches">Watches</option>
                                    <option value="laptop">laptop</option>
                                    <option value="systems">systems</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Update Image 01</label>
                                <input type="file"  name="image_01" class="form-control">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Update Image 02</label>
                                <input name="image_02" type="file" class="form-control">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Update Image 03</label>
                                <input name="image_03" type="file" class="form-control">
                            </div>
                            <!-- Buttons -->
                            <div class="d-flex justify-content-between mt-3">
                                <button name="update" type="submit" class="btn btn-primary">Update</button>
                                <a href="products.php" type="button" class="btn btn-warning">Go Back</a>
                            </div>
                        </form>
                    </div>
                <?php } else { ?>
                    <div class="mt-5"
                        style="border:solid 2px black;margin:auto; width:300px; padding:0.5rem 2rem; border-radius:10px;"
                        class="empty">
                        <p class="text-secondary">No Products to be found</p>
                    </div>

                <?php }
                    ?>
            </div>
        </div>
    </div>
    <?php include_once('../components/footer.php') ?>

    <script>
        function updateMainImage(element) {
            document.getElementById('mainImage').src = element.src;
        }

    </script>

</body>

</html>