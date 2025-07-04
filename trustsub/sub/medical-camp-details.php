<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("location:../view.php");
}
include 'includes/head.php';
include '../../config.php';
$act = 12;
?>
<?php include 'includes/sidebar.php'; ?>
<section id="content">
    <?php include 'includes/navbar.php'; ?>
    <?php include '../../common/medical-camp-details.php'; ?>
</section>
</body>

</html>