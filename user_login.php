<?php
session_start();
include_once('./connect.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $pass = sha1($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
        $select_admin = $conn->prepare('SELECT * FROM `users` WHERE name = ? AND password= ?');
        $select_admin->execute([$_POST['name'], $pass]);
        $row = $select_admin->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            header('location:index.php');
            exit;
        } else {
            $message[] = 'Incorrect Username or Password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
</style>

<body>
    <?php include_once('./components/user_header.php') ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-info text-white">
                        <h3>Login</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <!-- Email field -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="name" class="form-control" id="name" name="name"
                                    placeholder="Enter your name" required>
                            </div>
                            <!-- Password field -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="pass"
                                    placeholder="Enter your password" required>
                            </div>
                            <!-- Submit button -->
                            <button name="login" type="submit" class="btn text-light btn-info w-100">Login</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <small>Don't have an account? <a href="register.php" class="text-secondary">Register
                                here</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('./components/user_footer.php') ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>