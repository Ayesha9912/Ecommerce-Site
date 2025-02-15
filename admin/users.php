<?php
session_start();
include_once('../connect.php');
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:login.php');
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_admin = $conn->prepare('DELETE FROM `users` WHERE id = ?');
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
                <h2 class="mb-5">Users Accounts</h2>
            </div>
        </div>
        <div class="row">
            <?php
            $choose_users = $conn->prepare('SELECT * FROM `users`');
            $choose_users->execute();
            if ($choose_users->rowCount() > 0) {
                while ($fetch_users = $choose_users->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="card shadow-lg card-custom">
                            <div class="card-body">
                                <h5 class="card-title">user-id: <span><?= $fetch_users['id'] ?></span></h5>
                                <p class="card-text">user-name: <span><?= $fetch_users['name']; ?></span></p>
                                <div class="d-flex" style="gap:20px;">
                                    <a onclick="return confirm('Do you want to delete the user')"
                                        href="users.php?delete=<?= $fetch_users['id'] ?>" class="btn btn-danger">Delete</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else { ?>
                <div style="border:solid 2px black;margin:auto; width:300px; padding:0.5rem 2rem; border-radius:10px;" class="empty">
                    <p class="text-secondary">No Users to be found</p>
                </div>
                <?php
            }

            ?>
        </div>
    </div>
    </div>
    <?php include_once('../components/footer.php') ?>
</body>

</html>