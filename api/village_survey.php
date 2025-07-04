<?php
include '../config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $putData = file_get_contents("php://input");

    $boundary = substr($putData, 0, strpos($putData, "\r\n"));
    $parts = array_slice(explode($boundary, $putData), 1, -1);

    $parsedData = [];
    foreach ($parts as $part) {
        if (empty($part))
            continue;

        $partHeaders = substr($part, 0, strpos($part, "\r\n\r\n"));
        $partBody = substr($part, strlen($partHeaders) + 4);

        if (preg_match('/name="([^"]+)"/', $partHeaders, $matches)) {
            $fieldName = $matches[1];
            $parsedData[$fieldName] = trim($partBody);
        }
    }

    $studentId = $_GET['id'];

    $updateQuery = "UPDATE village_survey SET 
            REGION = ?,
            VILLAGE_NAME = ?,
            VILLAGE_POPULATION = ?,
            GRAM_PANCHAYAT_NAME = ?,
            PANCHAYAT_POPULATION = ?,
            MANDAL_NAME = ?,
            DISTRICT_NAME = ?,
            STATE = ?,
            PINCODE = ?,
            LATITUDE = ?,
            LONGITUDE = ?,
            NUMBER_OF_TEMPLE = ?,
            NUMBER_OF_CHURCHES = ?,
            NUMBER_OF_MOSQUES = ?,
            VILLAGE_LEADER_NAME = ?,
            REQUESTED_FOR = ?,
            DETAILS_FOR_PROGRAMS = ?,
            REQUESTED_THROUGH = ?,
            REQUESTED_BY_NAME = ?,
            REQUESTED_DETAILS = ?,
            REQUESTED_PHONE_NUMBER = ?,
            FINAL_DECISION = ?,
            FINAL_DECISION_REASON = ?,
            NGO_NAME = ?,
            status = ?";

    $updateQuery .= " WHERE id = ?";

    $updateStmt = $conn->prepare($updateQuery);

    $paramTypes = "sssssssssssssssssssssssssi";
    $params = [
        $parsedData['REGION'],
        $parsedData['VILLAGE_NAME'],
        $parsedData['VILLAGE_POPULATION'],
        $parsedData['GRAM_PANCHAYAT_NAME'],
        $parsedData['PANCHAYAT_POPULATION'],
        $parsedData['MANDAL_NAME'],
        $parsedData['DISTRICT_NAME'],
        $parsedData['STATE'],
        $parsedData['PINCODE'],
        $parsedData['LATITUDE'],
        $parsedData['LONGITUDE'],
        $parsedData['NUMBER_OF_TEMPLE'],
        $parsedData['NUMBER_OF_CHURCHES'],
        $parsedData['NUMBER_OF_MOSQUES'],
        $parsedData['VILLAGE_LEADER_NAME'],
        $parsedData['REQUESTED_FOR'],
        $parsedData['DETAILS_FOR_PROGRAMS'],
        $parsedData['REQUESTED_THROUGH'],
        $parsedData['REQUESTED_BY_NAME'],
        $parsedData['REQUESTED_DETAILS'],
        $parsedData['REQUESTED_PHONE_NUMBER'],
        $parsedData['FINAL_DECISION'],
        $parsedData['FINAL_DECISION_REASON'],
        $parsedData['NGO_NAME'],
        $parsedData['status'],
    ];

    $params[] = $studentId;

    // Bind parameters dynamically
    $updateStmt->bind_param($paramTypes, ...$params);

    if ($updateStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Village details updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating village details']);
    }

    $updateStmt->close();
    $conn->close();
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

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
}