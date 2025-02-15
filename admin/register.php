<?php
include_once('../connect.php');
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
  header('location:login.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['register'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
    $select_admin = $conn->prepare('SELECT * FROM `admins` WHERE name = ?');
    $select_admin->execute([$name]);
    if ($select_admin->rowCount() > 1){
      $message[] = ' User already Resigtered';
    } else {
      if ($pass !== $cpass) {
        $message[] = 'the password does not matched';
      } else {
        $insert_admin = $conn->prepare('INSERT INTO `admins` (name, password) VALUES (?,?)');
        $insert_admin->execute([$name, $pass]);
        $select_admin = $conn->prepare('SELECT * FROM `admins` WHERE name = ?');
        $select_admin->execute([$name]);
        $result = $select_admin->fetch(PDO::FETCH_ASSOC);
        $admin_id = $result['id'];
        $message[] = "New Admin Registered Successfully";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Style.css link -->
   
</head>
<body>
  <?php include_once('../components/admin_header.php'); ?>
  <div class="container mt-5">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6 mt-5">
        <div class="card shadow-lg">
          <div class="card-header text-center bg-dark text-white">
            <h3>Register</h3>
          </div>
          <div class="card-body">
            <form method="POST">
              <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="pass" id="password" placeholder="Enter your password">
              </div>
              <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="cpass" id="confirmPassword"
                  placeholder="Confirm your password">
              </div>
              <button name="register" type="submit" class="btn btn-dark w-100">Register</button>
            </form>
          </div>
          <div class="card-footer text-center">
            <small>Already have an account? <a href="login.php" class="text-secondary">Login here</a></small>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('../components/footer.php') ?>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>