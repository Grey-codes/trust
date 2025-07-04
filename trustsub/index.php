<?php
session_start();
$status = 11;
include '../config.php';
if (!empty($_POST)) {
  $uid = $_POST['name'];
  $upass = $_POST['pass'];
  $sql = mysqli_query($conn, "select * from subadmin where username='$uid' and password='$upass'");

if (mysqli_num_rows($sql) > 0) {
  while ($j = mysqli_fetch_array($sql)) {
    $uid = $j['id'];
    $status = $j['status'];
    $perm = $j['permission']; // e.g., "1,2,4"
  }

  if ($status) {
    $_SESSION['userId'] = $uid;

    // Convert permission string to array
    $permArray = array_filter(explode(',', $perm));

    $newPerms = [1, 2, 3];
    $permArray = array_unique(array_merge($permArray, $newPerms));

    // Convert back to string
    $permString = implode(',', $permArray);

    $_SESSION['subadmin_permission'] = $permString;
    
    header("Location: sub/profile.php");
    exit;
  } else {
    $error = "Access Denied. Contact Super Admin";
  }

} else {
  $status = 0;
  $error = "Invalid Password or Username";
}
 }

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/owl.carousel.min.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="icon" href="../../logo.png" type="image/png">

  <link rel="stylesheet" href="css/style.css">

  <title>Admin Login</title>
</head>

<body>

  <div class="content">
    <div class="container">
 <?php 
 
 if(!empty($error)){
  echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
  <strong>'.$error.'</strong>
</div>';
 }
 ?>
    <div class="row">
        <div class="col-md-6">
          <img src="logo.png" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
                <h3>Admin Sign In</h3>
              </div>
              <form action=" " method="POST">
                <div class="form-group first">
                  <label for="username">Username</label>
                  <input type="text" class="form-control" id="username" name="name">

                </div>
                <div class="form-group last mb-4">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="pass">

                </div>

                <div class="d-flex mb-5 align-items-center">
                  <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                    <input type="checkbox" checked="checked" />
                    <div class="control__indicator"></div>
                  </label>

                </div>

                <input type="submit" value="Log In" class="btn btn-block btn-primary">


              </form>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>


  <script src="../js/jquery-3.3.1.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/main.js"></script>
</body>

</html>