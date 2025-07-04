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

    $photoPath = null;
    $fullphotoPath = null;


    if (isset($parsedData['photo'])) {
        $targetDirectory = 'widow/';
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        $existingPhoto = $targetDirectory . $studentId . ".png";
        if (file_exists($existingPhoto)) {
            unlink($existingPhoto);
        }

        $targetFile = $targetDirectory . $studentId . ".png";
        $photoPath = $studentId . ".png";
        file_put_contents($targetFile, $parsedData['photo']);
    }

    if (isset($parsedData['Full_Photo'])) {
        $targetDirectory = 'widow/';
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        $existingPhoto = $targetDirectory . 'full' . $studentId . ".png";
        if (file_exists($existingPhoto)) {
            unlink($existingPhoto);
        }

        $targetFile = $targetDirectory . 'full' . $studentId . "FULL.png";
        $fullphotoPath = $studentId . ".png";
        file_put_contents($targetFile, $parsedData['Full_Photo']);
    }

    $updateQuery = "UPDATE widow_aged SET 
            NAME_OF_THE_APPLICANTE = ?,
            DATE_OF_BIRTH = ?,
            AADHAR_CARD_NUMBER = ?,
            HUSBAND_NAME = ?,
            MARRIAGE_DATE = ?,
            NUMBER_OF_CHILDREN = ?,
            HUSBAND_PASSED_YEAR = ?,
            CAUSE_OF_DEATH = ?,
            RECEVING_PENSION = ?,
            HEALTH_PROBLEMS = ?,
            PRESENT_LIVING_STATUS = ?,
            Door_Number = ?,
            Street = ?,
            Village = ?,
            City = ?,
            MANDAL_NAME = ?,
            DISTRICT_NAME = ?,
            STATE = ?,
            PINCODE = ?,
            PHONE_NUMBER = ?,
            REQUESTED_THROUGH = ?,
            REQUESTED_BY_NAME = ?,
            REQUESTED_PHONE_NUMBER = ?,
            REQUESTED_PLACE = ?,
            NGO_NAME = ?,
            status = ?
                ";

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
        $parsedData['NAME_OF_THE_APPLICANTE'],
        $parsedData['DATE_OF_BIRTH'],
        $parsedData['AADHAR_CARD_NUMBER'],
        $parsedData['HUSBAND_NAME'],
        $parsedData['MARRIAGE_DATE'],
        $parsedData['NUMBER_OF_CHILDREN'],
        $parsedData['HUSBAND_PASSED_YEAR'],
        $parsedData['CAUSE_OF_DEATH'],
        $parsedData['RECEVING_PENSION'],
        $parsedData['HEALTH_PROBLEMS'],
        $parsedData['PRESENT_LIVING_STATUS'],
        $parsedData['Door_Number'],
        $parsedData['Street'],
        $parsedData['Village'],
        $parsedData['City'],
        $parsedData['MANDAL_NAME'],
        $parsedData['DISTRICT_NAME'],
        $parsedData['STATE'],
        $parsedData['PINCODE'],
        $parsedData['PHONE_NUMBER'],
        $parsedData['REQUESTED_THROUGH'],
        $parsedData['REQUESTED_BY_NAME'],
        $parsedData['REQUESTED_PHONE_NUMBER'],
        $parsedData['REQUESTED_PLACE'],
        $parsedData['NGO_NAME'],
        $parsedData['status'],
    ];

    if ($photoPath) {
        $params[] = $photoPath;
    }
    if ($fullphotoPath) {
        $params[] = $fullphotoPath;
    }

    $params[] = $studentId;

    $updateStmt->bind_param($paramTypes, ...$params);

    if ($updateStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Widow aged details updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating widowaged details']);
    }

    $updateStmt->close();
    $conn->close();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
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
    $appType = $_POST['app_type'];

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
            VALUES ('$appType', '$time', '$date', '$ref', '$subrefer', '$name', '$dob', '$husband', '$number', 
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
}