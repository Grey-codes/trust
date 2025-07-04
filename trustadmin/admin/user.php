<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['aId'])) {
    header("location:../index.php");
}
include 'includes/head.php';
include '../../config.php';
$act = 4;

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $query = "SELECT * FROM user WHERE id = '$userId'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "User not found!";
        exit();
    }
} else {
    echo "No user ID provided!";
    exit();
}
?>

<body>
    <?php
    include 'includes/sidebar.php';
    ?>
    <section id="content">

        <?php
        include 'includes/navbar.php';
        include '../../config.php';

        include "../../common/volunteer-details.php";
        ?>

</body>

</html>