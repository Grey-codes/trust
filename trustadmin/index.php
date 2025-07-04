
<?php 
session_start();
$status=11;
include '../config.php';
if(!empty($_POST))
{
    $uid=$_POST['name'];
    $upass=$_POST['pass'];
    $sql=mysqli_query($conn,"select * from admin where username='$uid' and password='$upass'");
    
    if(mysqli_num_rows($sql)>0){
      
      while($j=mysqli_fetch_array($sql))
      {
        $uid=$j['id'];
        
      }
      $_SESSION['aId']=$uid;
      
      if(!empty($_POST['perm'])){
          header("location:permission.php");
          exit;
      }else{
  header("location:admin/createsub.php");
      }
}
else{
     
  $status=0;
  echo "erroe";
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
    
    <link rel="stylesheet" href="css/style.css">

    <title>Super Admin Login</title>
  </head>
  <body>
  

  
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="logo.png" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h3>Super Admin Sign In</h3>
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
            <div class="form-check mx-2 my-3">
  <input class="form-check-input" name="perm" type="checkbox" value="1" id="flexCheckDefault">
  <label class="form-check-label" for="flexCheckDefault">
   <h6 style="font-weight:700;"> For Permissions </h6>
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

  
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>