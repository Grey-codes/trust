<?php
session_start();

include '../config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['userId'];

    if (isset($_FILES['profile']) && $_FILES['profile']['error'] == 0) {
        $profile = $_FILES['profile'];

        $fileName = $profile['name'];
        $fileTmpName = $profile['tmp_name'];
        $fileSize = $profile['size'];
        $fileError = $profile['error'];
        
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        if (in_array($fileExt, $allowed)) {
            $uploadDir = 'subadminImages/';
            $filePath = $uploadDir . basename($fileName);
            
            if (move_uploaded_file($fileTmpName, $filePath)) {
                $sql = mysqli_query($conn, "UPDATE `subadmin` SET `photo`='$filePath' WHERE `id`='$userId'");

                if ($sql) {
                    echo json_encode(['status' => 'success', 'message' => 'Profile picture updated successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update the database.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to upload the file.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid file type.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No file uploaded or error occurred.']);
    }
}
?>
