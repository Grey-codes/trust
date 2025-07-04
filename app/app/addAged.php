<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("location:../index.php");
    exit;
}

include '../../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $husband = isset($_POST['husband']) ? $_POST['husband'] : '';
    $number = isset($_POST['number']) ? $_POST['number'] : '';
    $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : '';
    $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : '';

    if (empty($name) || empty($dob) || empty($number)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    $date = date('y/m/d');
    date_default_timezone_set("Asia/Kolkata");
    $time = date('h:i:s');
    $ref = $_SESSION['userid'];
    $subrefer = $_SESSION['ref'];

    $sl_id = mysqli_query($conn, "SELECT MAX(id) as max_id FROM widow_aged");
    if (!$sl_id) {
        die("Error fetching max ID: " . mysqli_error($conn));
    }
    $row = mysqli_fetch_array($sl_id);
    $rq_no = $row['max_id'] + 1;

    $photo = null;
    $full_photo = null;

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $targetDirectory = 'widow/';
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
            chmod($targetDirectory, 0755);
        }
        $targetFile = $targetDirectory . basename($rq_no . ".png");
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
            $photo = $rq_no . ".png";
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error uploading photo.']);
            exit;
        }
    }

    if (isset($_FILES['full_photo']) && $_FILES['full_photo']['error'] === UPLOAD_ERR_OK) {
        $targetDirectory = 'widow/';
        $targetFullFile = $targetDirectory . basename($rq_no . "_full.png");
        if (move_uploaded_file($_FILES['full_photo']['tmp_name'], $targetFullFile)) {
            $full_photo = $rq_no . "_full.png";
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error uploading full photo.']);
            exit;
        }
    }

    $sql = "INSERT INTO widow_aged (app_type, time, date, refer, sub_refer, NAME_OF_THE_APPLICANTE, DATE_OF_BIRTH, HUSBAND_NAME, PHONE_NUMBER, photo, FULL_PHOTO, LATITUDE, LONGITUDE) 
            VALUES (1, '$time', '$date', '$ref', '$subrefer', '$name', '$dob', '$husband', '$number', '$photo', '$full_photo', '$latitude', '$longitude')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database insertion failed: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>