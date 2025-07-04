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
        $targetDirectory = 'student/';
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
        $targetDirectory = 'student/';
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        $existingPhoto = $targetDirectory . 'full' . $studentId . ".png";
        if (file_exists($existingPhoto)) {
            unlink($existingPhoto);
        }

        $targetFile = $targetDirectory . 'full' . $studentId . "FULL.png";
        $fullphotoPath = $studentId . ".png";
        file_put_contents($targetFile, $parsedData['photo']);
    }

    $updateQuery = "UPDATE student SET 
        Student_Full_Name = ?, Date_of_Birth = ?, Class = ?, School_or_College_Name = ?, Gender = ?, 
        Child_Aadhar_No = ?, Father_Name = ?,Father_Aadhar = ?, Mother_Name = ?,Mother_Aadhar = ?, Religious = ?, Caste_And_Sub_Caste = ?, 
        Favorite_Subject = ?, Favorite_Colour = ?, Favorite_Game = ?, Best_Friend = ?, Hobbies = ?, 
        Goal = ?, Door_Number = ?, Street = ?, village = ?, Mandal = ?, City = ?, Pincode = ?, District = ?, 
        State = ?, Country = ?, Parent_Contact = ?, NGO_NAME=?, status = ?";

    if ($photoPath) {
        $updateQuery .= ", photo = ?";
    }
    if ($fullphotoPath) {
        $updateQuery .= ", Full_Photo = ?";
    }

    $updateQuery .= " WHERE id = ?";

    $updateStmt = $conn->prepare($updateQuery);

    $paramTypes = "ssssssssssssssssssssssssssssss" . ($photoPath ? 's' : '') . ($fullphotoPath ? 's' : '') . "i";
    $params = [
        $parsedData['Student_Full_Name'],
        $parsedData['Date_of_Birth'],
        $parsedData['Class'],
        $parsedData['School_or_College_Name'],
        $parsedData['Gender'] ?? '',
        $parsedData['Child_Aadhar_No'],
        $parsedData['Father_Name'],
        $parsedData['Father_Aadhar'],
        $parsedData['Mother_Name'],
        $parsedData['Mother_Aadhar'],
        $parsedData['Religious'],
        $parsedData['Caste_And_Sub_Caste'],
        $parsedData['Favorite_Subject'],
        $parsedData['Favorite_Colour'],
        $parsedData['Favorite_Game'],
        $parsedData['Best_Friend'],
        $parsedData['Hobbies'],
        $parsedData['Goal'],
        $parsedData['Door_Number'],
        $parsedData['Street'],
        $parsedData['village'],
        $parsedData['Mandal'],
        $parsedData['City'],
        $parsedData['Pincode'],
        $parsedData['District'],
        $parsedData['State'],
        $parsedData['Country'],
        $parsedData['Parent_Contact'],
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

    // Bind parameters dynamically
    $updateStmt->bind_param($paramTypes, ...$params);

    if ($updateStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Student details updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating student details']);
    }

    $updateStmt->close();
    $conn->close();
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (isset($_POST['name'], $_POST['dob'], $_POST['class'], $_POST['latitude'], $_POST['longitude'], $_POST['address'])) {

        $name = $_POST['name'];
        $dob = $_POST['dob'];
        $number = isset($_POST['number']) ? $_POST['number'] : null;
        $class = $_POST['class'];
        $address = $_POST['address'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $ref = $_SESSION['userid'];
        $subrefer = $_SESSION['ref'];

        $sl_id = mysqli_query($conn, "SELECT * FROM student");
        $sl_no = 0;
        while ($j = mysqli_fetch_array($sl_id)) {
            $sl_no = $j['id'];
        }
        $rq_no = $sl_no + 1;
        $rq_no1 = 'full' . ($sl_no + 1);

        if (isset($_FILES['photo']) && isset($_FILES['full_photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK && $_FILES['full_photo']['error'] === UPLOAD_ERR_OK) {
            $targetDirectory = 'student/';

            if (!file_exists($targetDirectory)) {
                mkdir($targetDirectory, 0755, true);
                chmod($targetDirectory, 0755);
            }

            $targetFile = $targetDirectory . basename($rq_no . ".png");
            $targetFullFile = $targetDirectory . basename($rq_no1 . ".png");

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile) && move_uploaded_file($_FILES['full_photo']['tmp_name'], $targetFullFile)) {
                $photo = $rq_no . ".png";
                $fullPhoto = $rq_no1 . ".png";
            } else {
                echo json_encode(["status" => "error", "message" => "Error uploading photos"]);
                exit();
            }
        } else {
            echo json_encode(["status" => "error", "message" => "No photos uploaded or upload error"]);
            exit();
        }

        $sql = "INSERT INTO `student`(`time`, `date`, `refer`, `sub_refer`, `Student_Full_Name`, `Date_of_Birth`, `Class`, `village`, `Parent_Contact`, `photo`, `LATITUDE`, `LONGITUDE`, `Full_Photo`) 
                VALUES (NOW(), CURDATE(), '$ref', '$subrefer', '$name', '$dob', '$class', '$address', '$number', '$photo', '$latitude', '$longitude', '$fullPhoto')";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(["status" => "success", "message" => "Student added successfully", "student_id" => $rq_no]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error inserting student into database"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Missing required parameters"]);
    }
}