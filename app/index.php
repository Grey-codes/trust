<?php
session_start();
$status = 11;
include '../config.php';

if (!empty($_POST)) {
    $uid = $_POST['name'];
    $upass = $_POST['pass'];
    $sql = mysqli_query($conn, "select * from user where User_ID='$uid' and Password='$upass'");

    if (mysqli_num_rows($sql) > 0) {

        while ($j = mysqli_fetch_array($sql)) {
            $uid = $j['id'];
            $ref = $j['refer'];

        }
        $_SESSION['userid'] = $uid;
        $_SESSION['ref'] = $ref;
        header("location:app/index.php");
    } else {

        $status = 0;

    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PSR WORLD</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
   
    <meta name="keywords" content="bootstrap, mobile template, Bootstrap 5, mobile, html, responsive" />
    <link rel="icon" href="logo.png" type="image/png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
</head>

<body>
    <!-- <div id="loading">
        <div class="spinner-grow"></div>
    </div> -->
    <div class="appHeader">
        <div class="left">
            <a href="javascript:;" class="icon goBack">
                <i class="icon ion-ios-arrow-back"></i>
            </a>
        </div>
        <div class="pageTitle">Login</div>
        <div class="right">
        </div>
    </div>
    <div id="searchBox">
        <form>
            <span class="inputIcon">
                <i class="icon ion-ios-search"></i>
            </span>
            <input type="text" class="form-control" id="searchInput" placeholder="Search...">
            <a href="javascript:;" class="toggleSearchbox closeButton">
                <i class="icon ion-ios-close-circle"></i>
            </a>
        </form>
    </div>
    <div id="appCapsule">

        <div class="appContent">

            <?php

            if ($status == 0) {
                ?>
                <br>
                <div class="alert alert-danger p-1" role="alert">
                    Error ! Incorrect Data Found
                </div>
                <?php
            }

            ?>
            <div class="col mt-2">
                <center>
                    <img src="logo.png" style="height:200px; width:200px;">
                </center>
            </div>

            <div class="sectionTitle text-center mt-2">
                <div class="title">
                    <h1>Welcome Back</h1>
                </div>
                <div class="lead mb-2">Sign in to continue</div>
            </div>

            <form action=" " method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="User ID" name="name">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="pass">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Sign in
                    </button>
                </div>
            </form>
        </div>

        <!-- <script src=window.location.origin+"/trust/trust/trust/app/assets/js/lib/bootstrap.bundle.min.js"></script>
        <script src=window.location.origin+"/trust/trust/trust/app/assets/js/plugins/splide/splide.min.js"></script>
        <script src=window.location.origin+"/trust/trust/trust/app/assets/js/app.js"></script> -->
</body>

</html>