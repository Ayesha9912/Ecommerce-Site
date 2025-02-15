<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
      <div class="messages">
      <p>' . $msg . '</p>
       <i onclick="this.parentElement.remove();" class="fa-solid fa-x"></i>
      </div>  
      ';
    }
}
$wish_count = 0;
$c_count = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Responsive Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        .messages {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            display: flex;
            background-color: #f8f8f8;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 4rem;
            margin-bottom: 5rem;
            z-index: 99;
        }

        .messages p {
            font-size: 18px;
        }

        .messages i {
            color: black;
            font-size: 18px;
        }

        .messages i:hover {
            color: red;
            transform: rotate(360deg);
        }

        .navbar-nav {
            margin: auto;
        }

        .nav-item {
            margin: 0 10px;
        }

        .icons {
            display: flex;
            align-items: center;
        }

        .icons i {
            font-size: 20px;
            margin-left: 15px;
        }

        .drop {
            position: relative;
        }

        .drop-down {
            background-color: white;
            position: absolute;
            padding: 1.3rem 1rem;
            border: solid 2px black;
            top: 30px;
            left: -50px;
            border-radius: 3px;
            display: none;
            font-family: cursive;
            font-size: 16px;
            font-weight: 300;
            z-index: 22;
        }

        .active {
            display: block;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">Shopie.</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">about</a></li>
                    <li class="nav-item"><a class="nav-link" href="orders.php">orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="shop.php">shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">contact</a></li>
                </ul>
            </div>
            <div class="icons">
                <i class="fas fa-search"></i>

                <?php
                if (isset($_SESSION['user_id'])) {
                  
                    $wishlist_count = $conn->prepare('SELECT * FROM `wishlist` WHERE user_id = ?');
                    $wishlist_count->execute([$_SESSION['user_id']]);
                    $wish_count = $wishlist_count->rowCount();
                    $cart_count = $conn->prepare('SELECT * FROM `cart` WHERE user_id = ?');
                    $cart_count->execute([$_SESSION['user_id']]);
                    $c_count = $cart_count->rowCount();}
                     ?>
                   <a href="wishlist_pro.php" class="text-dark"> <i class="fas fa-heart"></i><span>(<?= $wish_count ?>)</span></a>
                   <a href="cart.php" class="text-dark"><i class="fas fa-shopping-cart"></i> <span>(<?= $c_count ?>)</span></a> 
                    <i class="fas fa-user drop">
                    <?php
                    if (isset($_SESSION['user_id'])) { ?>
                        <div class="drop-down">
                            <p><?= $_SESSION['user_name'] ?></p>
                            <a href="user_profile.php" class="btn btn-primary mb-2">Update Profile</a>
                            <div style="gap:10px;" class="d-flex mb-2">
                                <a href="user_login.php" class="btn btn-danger">Login</a>
                                <a href="user_register.php" class="btn btn-success">Register</a>
                            </div>
                            <a onclick="return confirm('do you want to logout?')" href="user_logout.php"
                                class="btn btn-primary mb-2">Logout Now!</a>
                        </div>
                        <?php
                    } else {
                        error_reporting(0);
                        ?>
                        <div class="drop-down">
                            <p>Please Login or regsiter First</p>
                            <div style="gap:10px;" class="d-flex mb-2">
                                <a href="user_login.php" class="btn btn-danger">Login</a>
                                <a href="user_register.php" class="btn btn-success">Register</a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </i>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        let drop = document.querySelector('.drop');
        let user_drop = document.querySelector('.drop-down');
        drop.addEventListener('click', (e) => {
            user_drop.classList.toggle('active');
            e.stopPropagation();
        })
        document.addEventListener('click', (e) => {
            if (e.target.contains(user_drop)) {
                user_drop.classList.remove('active');
            }
        })

    </script>
</body>

</html>