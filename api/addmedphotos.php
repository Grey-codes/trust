<?php
session_start();
header('Content-Type: application/json');

include '../config.php';

if ($conn == false) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['camp_id']) || empty($_POST['type'])) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit();
    }

    $rq_no = $_POST['camp_id'];
    $refer_id = $_SESSION['userId'];
    $type = $_POST['type'];

    $parts = explode("-", $type);
    $targetDirectory = $type . '/';

    if (count($parts) == 2) {
        $firstPart = $parts[0];
        $secondPart = $parts[1];
    }

    if (strpos($type, 'medical') !== false) {
        $targetDirectory = 'albums/' . $secondPart . '/';
    }

    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0755, true);
    }

    $photosData = [];
    $fileNames = [];

    if (isset($_FILES['photo'])) {
        foreach ($_FILES['photo']['tmp_name'] as $key => $tmp_name) {
            $fileName = $_FILES['photo']['name'][$key];
            $photoName = $rq_no . '_' . bin2hex(random_bytes(8)) . '.png';
            $targetFile = $targetDirectory . basename($photoName);

            if (move_uploaded_file($tmp_name, $targetFile)) {
                $photosData[] = $photoName;
                $fileNames[] = $fileName;
            }
        }
    }

    $photos = json_encode($photosData);
    $sql = mysqli_query($conn, "INSERT INTO `medicalphotos` (`camp_id`, `type`, `refer_id`, `photos`) VALUES ('$rq_no', '$type', '$refer_id', '$photos')");

    if ($sql) {
        echo json_encode(['success' => true, 'message' => 'Photos uploaded successfully', 'fileNames' => $fileNames]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload photos', 'error' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>