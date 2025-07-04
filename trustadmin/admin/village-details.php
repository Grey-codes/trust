<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['aId'])) {
    header("location:../index.php");
}
include 'includes/head.php';
include '../../config.php';
$act = 8;

?>

<body>
    <?php include 'includes/sidebar.php'; ?>
    <section id="content">
        <?php include 'includes/navbar.php'; ?>
        <?php include '../../common/village-details.php'; ?>
    </section>

</body>

</html>