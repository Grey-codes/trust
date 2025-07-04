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

    $pregnantId = $_GET['id'];

    $photoPath = null;
    $fullphotoPath = null;

    if (isset($parsedData['photo'])) {
        $targetDirectory = 'pregnant/';
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        $existingPhoto = $targetDirectory . $pregnantId . ".png";
        if (file_exists($existingPhoto)) {
            unlink($existingPhoto);
        }

        $targetFile = $targetDirectory . $pregnantId . ".png";
        $photoPath = $pregnantId . ".png";
        file_put_contents($targetFile, $parsedData['photo']);
    }

    if (isset($parsedData['Full_Photo'])) {
        $targetDirectory = 'pregnant/';
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        $existingPhoto = $targetDirectory . 'full' . $pregnantId . ".png";
        if (file_exists($existingPhoto)) {
            unlink($existingPhoto);
        }

        $targetFile = $targetDirectory . 'full' . $pregnantId . "FULL.png";
        $fullphotoPath = $pregnantId . ".png";
        file_put_contents($targetFile, $parsedData['photo']);
    }

    $updateQuery = "UPDATE pregnant SET 
        PREGNANT_NAME=  ?,DATE_OF_BIRTH=  ?,AADHAR_CARD_NUMBER=  ?,EDUCATION=  ?,HUSBAND_NAME=  ?,DELIVERY_DATE=  ?,MARRIAGE_DATE=  ?,NUMBER_OF_CHILDREN=  ?,HEALTH_PROBLEMS=  ?,PRESENT_LIVING_STATUS=  ?,Door_Number=  ?,Street=  ?,VILLAGE_NAME=  ?,Mandal=  ?,City=  ?,Pincode=  ?,District=  ?,State=  ?,Country=  ?,PHONE_NUMBER=  ?,REQUESTED_THROUGH=  ?,REQUESTED_BY_NAME=  ?,REQUESTED_PLACE = ?,REQUESTED_PHONE_NUMBER = ?,NGO_NAME = ?,status= ? ";

    if ($photoPath) {
        $updateQuery .= ", photo = ?";
    }
    if ($fullphotoPath) {
        $updateQuery .= ", Full_Photo = ?";
    }

    $updateQuery .= " WHERE id = ?";

    $updateStmt = $conn->prepare($updateQuery);

    $paramTypes = "ssssssssssssssssssssssssss" . ($photoPath ? 's' : '') . ($fullphotoPath ? 's' : '') . "i";
    $params = [
        $parsedData['PREGNANT_NAME'],
        $parsedData['DATE_OF_BIRTH'],
        $parsedData['AADHAR_CARD_NUMBER'],
        $parsedData['EDUCATION'],
        $parsedData['HUSBAND_NAME'],
        $parsedData['DELIVERY_DATE'],
        $parsedData['MARRIAGE_DATE'],
        $parsedData['NUMBER_OF_CHILDREN'],
        $parsedData['HEALTH_PROBLEMS'],
        $parsedData['PRESENT_LIVING_STATUS'],
        $parsedData['Door_Number'],
        $parsedData['Street'],
        $parsedData['VILLAGE_NAME'],
        $parsedData['Mandal'],
        $parsedData['City'],
        $parsedData['Pincode'],
        $parsedData['District'],
        $parsedData['State'],
        $parsedData['Country'],
        $parsedData['PHONE_NUMBER'],
        $parsedData['REQUESTED_THROUGH'],
        $parsedData['REQUESTED_BY_NAME'],
        $parsedData['REQUESTED_PLACE'],
        $parsedData['REQUESTED_PHONE_NUMBER'],
        $parsedData['NGO_NAME'],
        $parsedData['status'],
    ];

    if ($photoPath) {
        $params[] = $photoPath;
    }
    if ($fullphotoPath) {
        $params[] = $fullphotoPath;
    }

    $params[] = $pregnantId;

    // Bind parameters dynamically
    $updateStmt->bind_param($paramTypes, ...$params);

    if ($updateStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Pregnant details updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating pregnant details']);
    }

    $updateStmt->close();
    $conn->close();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
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
}