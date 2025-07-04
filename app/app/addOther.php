<?php
session_start();
if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

include '../../config.php';

$response = [
    'status' => 'error',
    'message' => 'Something went wrong. Please try again.'
];

if ($conn == false) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

$sl_id = mysqli_query($conn, "SELECT * FROM otherActivities");
$sl_no = 0;
while ($j = mysqli_fetch_array($sl_id)) {
    $sl_no = $j['id'];
}
$rq_no = $sl_no + 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDirectory = 'other/';
    $photosData = [];
    $count = 0;
    $maxSize = 5 * 1024 * 1024;
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'][0])) {
        foreach ($_FILES['photo']['tmp_name'] as $key => $tmp_name) {
            $count++;

            if ($_FILES['photo']['size'][$key] > $maxSize) {
                echo json_encode(['status' => 'error', 'message' => 'File size exceeds the 5MB limit.']);
                exit;
            }

            $fileName = $_FILES['photo']['name'][$key];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (!in_array($fileExt, $allowedTypes)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid file type.']);
                exit;
            }

            $photoName = 'photo_' . time() . '_' . $count . '.' . $fileExt;

            $targetFile = $targetDirectory . basename($photoName);
            if (move_uploaded_file($tmp_name, $targetFile)) {
                array_push($photosData, $photoName);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to upload photo.']);
                exit;
            }
        }

        $photos = json_encode($photosData);
        $sql = mysqli_query($conn, "INSERT INTO otheractivities (photo) VALUES ('$photos')");

        if ($sql) {
            echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database insertion failed.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No photos uploaded.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>