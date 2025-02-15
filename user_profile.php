<?php
session_start();
include_once('./connect.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['update'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $ppass = sha1($_POST['ppass']);
    $ppass = filter_var($ppass, FILTER_SANITIZE_STRING);
    $npass = sha1($_POST['npass']);
    $npass = filter_var($npass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
    $prev_pass = $_POST['prev_pass'];
    if ($ppass !== $prev_pass) {
      $message[] = 'Your Previous password is not correct';

    } else if ($npass !== $cpass) {
      $message[] = 'Your both passwords doesnot match';
    } else {
      $insert_updates = $conn->prepare('UPDATE `users` SET name = ? , password = ? WHERE id = ?');
      $insert_updates->execute([$name, $npass, $_SESSION['user_id']]);
      $message[] = 'Data Successfully Updated';
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href='../css/style.css'>
</head>
<body>
  <?php include_once('./components/user_header.php'); ?>
  <div class="container mt-5">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6 mt-5">
        <div class="card shadow-lg">
          <div class="card-header text-center bg-dark text-white">
            <h3>Update Profile</h3>
          </div>
          <div class="card-body">
            <form method="POST">
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <?php
                $fetch_pass = $conn->prepare('SELECT * FROM `users` WHERE id = ?');
                $fetch_pass->execute([$_SESSION['user_id']]);
                $row = $fetch_pass->fetch(PDO::FETCH_ASSOC); 
                 ?>
                <input type="hidden" value="<?= $row['password'] ?>" name="prev_pass">
                <input type="text" class="form-control" value='<?= $_SESSION['user_name'] ?>' name="name" id="name"
                  placeholder="Enter your name">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Previous Password</label>
                <input type="password" class="form-control" name="ppass" id="password"
                  placeholder="Enter your password">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control" name="npass" id="password"
                  placeholder="Enter your password">
              </div>
              <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="cpass" id="confirmPassword"
                  placeholder="Confirm your password">
              </div>
              <button name="update" type="submit" class="btn btn-dark w-100">Update</button>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
  <?php include_once('./components/user_footer.php') ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>