<?php
session_start();

if (!isset($_SESSION['userid'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

include '../config.php';

$sl_id = mysqli_query($conn, "select * from pregnant");
while ($j = mysqli_fetch_array($sl_id)) {
    $sl_no = $j['id'];
}
if (!isset($sl_no)) {
    $sl_no = 0;
}
$rq_no = $sl_no + 1;

$data = $_POST;

if (empty($data['name']) || empty($data['dob']) || empty($data['month']) || empty($data['husband']) || empty($data['address']) || empty($data['latitude']) || empty($data['longitude'])) {
    echo json_encode(["status" => "error", "message" => "Missing required parameters"]);
    exit();
}

$name = $data['name'];
$dob = $data['dob'];
$month = $data['month'];
$husband = $data['husband'];
$number = isset($data['number']) ? $data['number'] : '';
$ddate = $data['ddate'];
$pincode = $data['address'];
$lati = $data['latitude'];
$long = $data['longitude'];
$ref = $_SESSION['userid'];
$subrefer = $_SESSION['ref'];

$date = date('y/m/d');
date_default_timezone_set("Asia/Kolkata");
$time = date('h:i:s');

$targetDirectory = 'pregnant/';
$photo = '';
$fullPhoto = '';

if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0755, true);
        chmod($targetDirectory, 0755);
    }
    $photo = $rq_no . ".png";
    $targetFile = $targetDirectory . basename($photo);
    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
        echo json_encode(["status" => "error", "message" => "Error uploading photo"]);
        exit();
    }
} else {
    echo json_encode(["status" => "error", "message" => "No photo uploaded or error occurred during upload"]);
    exit();
}

if (isset($_FILES['full_photo']) && $_FILES['full_photo']['error'] === UPLOAD_ERR_OK) {
    $fullPhoto = $rq_no . "_full.png";
    $targetFullFile = $targetDirectory . basename($fullPhoto);
    if (!move_uploaded_file($_FILES['full_photo']['tmp_name'], $targetFullFile)) {
        echo json_encode(["status" => "error", "message" => "Error uploading full photo"]);
        exit();
    }
} else {
    echo json_encode(["status" => "error", "message" => "No full photo uploaded or error occurred during upload"]);
    exit();
}

$sql = mysqli_query($conn, "INSERT INTO `pregnant`(`time`, `date`, `refer`, `sub_refer`, `PREGNANT_NAME`, `DATE_OF_BIRTH`, `HUSBAND_NAME`, `DELIVERY_DATE`, `VILLAGE_NAME`, `PHONE_NUMBER`, `photo`, `LATITUDE`, `LONGITUDE`, `FULL_PHOTO`) VALUES ('$time','$date','$ref','$subrefer','$name','$dob','$husband','$ddate','$pincode','$number','$photo','$lati','$long','$fullPhoto')");

if ($sql) {
    echo json_encode(["status" => "success", "message" => "Data successfully added"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to insert data"]);
}
?>