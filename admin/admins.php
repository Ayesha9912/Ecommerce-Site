<?php
session_start();
include_once('../connect.php');
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
}
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $delete_admin = $conn->prepare('DELETE FROM `admins` WHERE id = ?');
    $delete_admin->execute([$id]);
    $message[] = "The admin is successfully Deleted";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <!-- css link -->
    <link rel="stylesheet" href='../css/style.css'>
</head>

<body>
    <?php include_once('../components/admin_header.php') ?>
    <div class="container mb-5 mt-5">
        <div class="row text-center">
            <div class="col-12">
                <h2 class="mb-5">Admin Accounts</h2>
            </div>
        </div>
        <div class="row">

            <div class="col-md-3 col-sm-6">
                <div class="card shadow-lg card-custom">
                    <div class="card-body">
                        <h5 class="card-title"><span></span></h5>
                        <p class="card-text">Add new Admin</p>
                        <a href="register.php" class="btn btn-success">Register Now</a>
                    </div>
                </div>
            </div>

            <?php
            $choose_admin = $conn->prepare('SELECT * FROM `admins`');
            $choose_admin->execute();
            if ($choose_admin->rowCount() > 0){
                while ($fetch_admins = $choose_admin->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="card shadow-lg card-custom">
                            <div class="card-body">
                                <h5 class="card-title">admin-id: <span><?=$fetch_admins['id'] ?></span></h5>
                                <p class="card-text">admin-name: <span><?= $fetch_admins['name']; ?></span></p>
                                <div class="d-flex" style="gap:20px;">
                                    <a onclick="return confirm('Do you want to delete the admin')" href="admins.php?delete=<?=$fetch_admins['id']?>" class="btn btn-danger">Delete</a>
                                    <?php 
                                    if($admin_id == $fetch_admins['id']){
                                    ?>
                                    <a href="update_profile.php" class="btn btn-success">Update</a>
                                    <?php
                                    }?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }else{ ?>
                <div class="empty"><p>No Admin to be found</p></div>
                <?php
            }

            ?>
        </div>
    </div>
    </div>
    <?php include_once('../components/footer.php') ?>
</body>

</html>