<?php
session_start();

if (!isset($_SESSION['userid'])) {
    echo json_encode(['status' => 'error', 'message' => 'User is not logged in.']);
    exit;
}

include '../../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $date = date('y/m/d');
    date_default_timezone_set("Asia/Kolkata");
    $time = date('h:i:s');

    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $region = isset($_POST['region']) ? $_POST['region'] : '';
    $vName = isset($_POST['villageName']) ? $_POST['villageName'] : '';
    $vPopu = isset($_POST['villagePopu']) ? $_POST['villagePopu'] : '';
    $request = isset($_POST['requesttype']) ? $_POST['requesttype'] : '';
    $RPname = isset($_POST['RPname']) ? $_POST['RPname'] : '';
    $number = isset($_POST['RPphone']) ? $_POST['RPphone'] : '';
    $pincode = isset($_POST['pincode']) ? $_POST['pincode'] : '';

    $ref = $_SESSION['userid'];
    $subrefer = $_SESSION['ref'];

    $sl_id = mysqli_query($conn, "SELECT MAX(id) as max_id FROM village_survey");
    if (!$sl_id) {
        echo json_encode(['status' => 'error', 'message' => 'Error fetching max ID: ' . mysqli_error($conn)]);
        exit;
    }
    $row = mysqli_fetch_array($sl_id);
    $rq_no = $row['max_id'] + 1;

    $sql = "INSERT INTO `village_survey` (`time`, `date`, `refer`, `sub_refer`, `REGION`, `VILLAGE_NAME`, `VILLAGE_POPULATION`, `PINCODE`, `REQUESTED_FOR`, `REQUESTED_BY_NAME`, `REQUESTED_PHONE_NUMBER`) 
            VALUES ('$time', '$date', '$ref', '$subrefer', '$region', '$vName', '$vPopu', '$pincode', '$request', '$RPname', '$number')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database insertion failed: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>