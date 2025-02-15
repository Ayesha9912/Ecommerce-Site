<?php
session_start();
include_once('../connect.php'); 
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
  header('location:login.php');
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
        <h2 class="mb-5">Dashboard</h2>
      </div>
    </div>
    <div class="row">
      <!-- Welcome Card -->
      <div class="col-md-3 col-sm-6">
        <div class="card shadow-lg card-custom">
          <div class="card-body">
            <h5 class="card-title">Welcome!</h5>
            <p class="card-text"><?=  $fetch_profile['name']; ?></p>
            <a href="update_profile.php" class="btn btn-primary">Update Profile</a>
          </div>
        </div>
      </div>
      <!-- Total Pendings Card -->
      <div class="col-md-3 col-sm-6">
        <div class="card shadow-lg card-custom">
          <div class="card-body">
            <h5 class="card-title"><?php $pending_price = $conn->prepare('SELECT * FROM `orders` WHERE payment_status = "Pending"');
            $pending_price->execute();
            $total_pendings = 0;
            if($pending_price->rowCount() > 0){
              while($row = $pending_price->fetch(PDO::FETCH_ASSOC)){
                $total_pendings += $row['total_price'];
              }
            }
            ?>$<span><?= $total_pendings;?></span>/</h5>
            <p class="card-text">Total Pendings</p>
            <a href="orders.php" class="btn btn-primary">See Orders</a>
          </div>
        </div>
      </div>
      <!-- Completed Orders Card -->
      <div class="col-md-3 col-sm-6">
        <div class="card shadow-lg card-custom">
          <div class="card-body">
          <h5 class="card-title"><?php $pending_price = $conn->prepare('SELECT * FROM `orders` WHERE payment_status = "delivered" OR payment_status = "shipped" ');
            $pending_price->execute();
            $total_completes = 0;
            if($pending_price->rowCount() > 0){
              while($row = $pending_price->fetch(PDO::FETCH_ASSOC)){
                $total_completes += $row['total_price'];
              }
            }
            ?>$<span><?= $total_completes;?></span>/</h5>
            <p class="card-text">Completed Orders</p>
            <a href="orders.php" class="btn btn-primary">See Orders</a>
          </div>
        </div>
      </div>
      <!-- Orders Placed Card -->
      <div class="col-md-3 col-sm-6">
        <div class="card shadow-lg card-custom">
          <div class="card-body">
            <h5 class="card-title">
            <?php $orders = $conn->prepare('SELECT * FROM `orders`');
            $orders->execute();
            echo $orders->rowCount(); 
            ?>
            </h5>
            <p class="card-text">Orders Placed</p>
            <a href="orders.php" class="btn btn-primary">See Orders</a>
          </div>
        </div>
      </div>
      <!-- Products Added Card -->
      <div class="col-md-3 col-sm-6">
        <div class="card shadow-lg card-custom">
          <div class="card-body">
            <h5 class="card-title"><?php $prodcuts = $conn->prepare('SELECT * FROM `products`');
            $prodcuts->execute();
            echo $prodcuts->rowCount(); 
            ?></h5>
            <p class="card-text">Products Added</p>
            <a href="products.php" class="btn btn-primary">See Products</a>
          </div>
        </div>
      </div>
      <!-- Normal Users Card -->
      <div class="col-md-3 col-sm-6">
        <div class="card shadow-lg card-custom">
          <div class="card-body">
            <h5 class="card-title"><?php $users = $conn->prepare('SELECT * FROM `users`');
            $users->execute();
            echo $users->rowCount(); 
            ?></h5>
            <p class="card-text">Normal Users</p>
            <a href="users.php" class="btn btn-primary">See Users</a>
          </div>
        </div>
      </div>
      <!-- Admin Users Card -->
      <div class="col-md-3 col-sm-6">
        <div class="card shadow-lg card-custom">
          <div class="card-body">
            <h5 class="card-title"><?php $admins = $conn->prepare('SELECT * FROM `admins`');
            $admins->execute();
            echo $admins->rowCount(); 
            ?></h5>
            <p class="card-text">Admin Users</p>
            <a href="admins.php" class="btn btn-primary">See Admins</a>
          </div>
        </div>
      </div>

    </div>
  </div>
<?php include_once('../components/footer.php') ?>
</body>
</html>