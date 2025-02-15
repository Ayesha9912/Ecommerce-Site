<?php
if(isset($message)){
    foreach($message as $msg){
       echo '
       <div class="messages">
          <span>'.$msg.'</span>
          <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
       </div>
       ';
    }
 }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Navbar</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <!-- css link -->
    <link rel="stylesheet" href='../css/style.css'>
</head>

<body>
  
    <nav class="navbar navbar-expand-lg bg-light border-bottom">
        <div class="container">
            <!-- Left: Admin Panel Title -->
            <a class="navbar-brand fw-bold" href="index.php">
                Admin<span class="text-primary">Panel</span>
            </a>

            <!-- Center: Links -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="admins.php">Admins</a></li>
                    <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
                </ul>
            </div>

            <!-- Right: Font Awesome Icon -->
            <div class="user-icon d-flex">
                <a href="#" class="text-dark">
                    <i class="fas fa-user fa-lg"></i>
                </a>
                <div class="user-dropdown mt-5">
                    <!-- Admin Name -->
                    <div class="text-center mb-4">
                        <?php $fetch_data = $conn->prepare('SELECT * FROM `admins` WHERE id = ?');
                        $fetch_data->execute([$admin_id]);
                        $fetch_profile = $fetch_data->fetch(PDO::FETCH_ASSOC);
                        
                        ?>
                        <p class="fw-bold">Welcome, <span class="text-primary"><?= $fetch_profile['name']; ?></span></>
                    </div>
                    <!-- Action Buttons -->
                    <div class="d-flex flex-column align-items-center gap-3">
                        <a href="update_profile.php" class="btn btn-primary w-50">Update Profile</a>
                        <a href="logout.php" onclick="return confirm('Do you want to logout?');" class="btn btn-danger w-50">Logout</a>
                        <a href="login.php" class="btn btn-success w-50">Login</a>
                        <a href="register.php" class="btn btn-secondary w-50">Register</a>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </nav>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/admin.js"></script>

</body>

</html>