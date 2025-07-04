<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['userId'])) {
  header("location:../index.php");
}
include 'includes/head.php';
include '../../config.php';
$act = 4;
?>

<body>
  <?php
  include 'includes/sidebar.php';
  ?>
  <section id="content">

    <?php
    include 'includes/navbar.php';
    include '../../common/viewStudent.php';
    ?>
    
  </section>

  <script src="script.js"></script>
</body>

</html>