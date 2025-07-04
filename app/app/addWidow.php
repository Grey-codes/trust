<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../index.php");
    exit();
}

include '../../config.php';

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {

    $date = date('y/m/d');
    date_default_timezone_set("Asia/Kolkata");
    $time = date('h:i:s');

    $name = $_POST['name'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $husband = $_POST['husband'] ?? '';
    $number = $_POST['number'] ?? '';
    $pincode = $_POST['pincode'] ?? '';
    $lati = $_POST['latitude'] ?? '';
    $long = $_POST['longitude'] ?? '';
    $ref = $_SESSION['userid'];
    $subrefer = $_SESSION['ref'];
    $appType = $_SESSION['app_type'];

    $sl_id = mysqli_query($conn, "SELECT * FROM widow_aged ORDER BY id DESC LIMIT 1");
    $row = mysqli_fetch_assoc($sl_id);
    $rq_no = isset($row['id']) ? $row['id'] + 1 : 1;

    $uploadDirectory = 'widow/';

    $photo = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
            chmod($uploadDirectory, 0755);
        }
        $photo = $rq_no . ".png";
        $targetFile = $uploadDirectory . $photo;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error uploading photo.';
            echo json_encode($response);
            exit();
        }
    }

    $fullPhoto = '';
    if (isset($_FILES['full_photo']) && $_FILES['full_photo']['error'] === UPLOAD_ERR_OK) {
        $fullPhoto = $rq_no . "_full.png";
        $targetFullFile = $uploadDirectory . $fullPhoto;
        if (!move_uploaded_file($_FILES['full_photo']['tmp_name'], $targetFullFile)) {
            $response['status'] = 'error';
            $response['message'] = 'Error uploading full photo.';
            echo json_encode($response);
            exit();
        }
    }

    $sql = "INSERT INTO widow_aged 
            (app_type, time, date, refer, sub_refer, NAME_OF_THE_APPLICANTE, DATE_OF_BIRTH, HUSBAND_NAME, 
            PHONE_NUMBER, photo, LATITUDE, LONGITUDE, FULL_PHOTO)
            VALUES (0, '$time', '$date', '$ref', '$subrefer', '$name', '$dob', '$husband', '$number', 
            '$photo', '$lati', '$long', '$fullPhoto')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $response['status'] = 'success';
        $response['message'] = 'Data submitted successfully!';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to submit data. Please try again.';
    }

    echo json_encode($response);
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request. Please send a POST request with the necessary data.';
    echo json_encode($response);
}
?>