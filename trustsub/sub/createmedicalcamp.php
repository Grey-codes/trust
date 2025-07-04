<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("location:../index.php");
}
include '../../config.php';
$userId = $_SESSION['userId'];
include 'includes/head.php';
$act = 11;
?>

<body>
    <?php include 'includes/sidebar.php'; ?>
    <section id="content">
        <?php include 'includes/navbar.php'; ?>
        <?php include '../../common/createmedicalcamp.php'; ?>
    </section>

</body>

</html>