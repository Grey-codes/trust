<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $status = intval($_POST['status']);

    $sql = "UPDATE subadmin SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $status, $id);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Failed";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Parse input data
    parse_str(file_get_contents("php://input"), $putData);

    $user_id = intval($putData['user_id']);
    $permissions = mysqli_real_escape_string($conn, $putData['permissions']);

    $sql = "UPDATE subadmin SET permission = '$permissions' WHERE id = $user_id";

    if (mysqli_query($conn, $sql)) {
        echo "Permissions updated with PUT";
    } else {
        echo "Error using PUT";
    }
}
?>


?>
