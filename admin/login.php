<?php
session_start();
include_once('../connect.php');
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if(isset($_POST['login'])){
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $select_admin = $conn->prepare('SELECT * FROM `admins` WHERE name = ? AND password= ?');
    $select_admin->execute([$_POST['name'], $pass]);
    $row = $select_admin->fetch(PDO::FETCH_ASSOC);
    if ($row) { 
      $_SESSION['admin_id'] = $row['id']; 
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
  .messages{
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
}
.messages p{
    font-size: 18px;
}
.messages i{
    color: black;
    font-size: 18px;
}
.messages i:hover{
    color: red;
    transform: rotate(360deg);
}
</style>
<body>
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
                <input type="name" class="form-control" id="name" name="name" placeholder="Enter your name" required>
              </div>
              <!-- Password field -->
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="pass" placeholder="Enter your password" required>
              </div>
              <!-- Submit button -->
              <button name="login" type="submit" class="btn text-light btn-info w-100">Login</button>
            </form>
          </div>
          <div class="card-footer text-center">
            <small>Don't have an account? <a href="register.php" class="text-secondary">Register here</a></small>
          </div>
        </div>
      </div>
    </div>
  </div>
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
  ?>
  <?php include_once('../components/footer.php') ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
