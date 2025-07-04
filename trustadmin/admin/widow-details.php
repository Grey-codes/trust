<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['aId'])) {
    header("location:../index.php");
}
include 'includes/head.php';
include '../../config.php';
$type = $_GET['type'];
if ($type === '1') {
    $act = 8;
}
else {
    $act = 7;
}
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    $query = "SELECT * FROM widow_aged WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Student not found.";
        exit();
    }
} else {
    echo "Student ID is missing.";
    exit();
}
?>

<body>
    <?php include 'includes/sidebar.php'; ?>
    <section id="content">
        <?php include 'includes/navbar.php'; ?>
        <?php include '../../common/widow-details.php'; ?>
    </section>

</body>

</html>