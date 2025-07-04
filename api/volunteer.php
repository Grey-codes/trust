<?php
session_start();

require '../config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userData = array();

    foreach ($_POST as $key => $value) {
        if (!empty($key)) {
            $userData[$key] = mysqli_real_escape_string($conn, $value);
        }
    }

    if (!empty($userData)) {
        $columns = implode(',', array_map(function ($column) {
            return "`$column`";
        }, array_keys($userData)));
        $values = "'" . implode("','", $userData) . "'";
        $query = "INSERT INTO `user` ($columns) VALUES ($values)";

        $result = mysqli_query($conn, $query);

        $user_id = $_POST['User_ID'];
        $photo = $user_id . ".png";

        $query1 = "UPDATE `user` SET `photo`='$photo' WHERE `User_ID`='$user_id'";
        $updatePhoto = mysqli_query($conn, $query1);

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $targetDirectory = 'userphotos/';

            if (!file_exists($targetDirectory)) {
                mkdir($targetDirectory, 0755, true);
                chmod($targetDirectory, 0755);
            }

            $targetFile = $targetDirectory . $user_id . ".png";

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                $response = ['success' => true, 'message' => 'User added successfully, photo uploaded'];
            } else {
                $response = ['success' => false, 'message' => 'Error uploading the photo'];
            }
        } else {
            $response = ['success' => false, 'message' => 'No photo uploaded or upload error'];
        }

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'User added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error adding user to the database']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No user data received']);
    }

    mysqli_close($conn);
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
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

    if (isset($parsedData['id'])) {
        $userId = $parsedData['id'];

        $updateQuery = "UPDATE `user` SET ";
        $updates = [];
        foreach ($parsedData as $key => $value) {
            if ($key !== 'id' && $key !== 'photo') {
                $updates[] = "`$key` = '" . mysqli_real_escape_string($conn, $value) . "'";
            }
        }
        $updateQuery .= implode(', ', $updates) . " WHERE `id` = '$userId'";

        $result = mysqli_query($conn, $updateQuery);

        if (!$result) {
            echo json_encode(['success' => false, 'message' => 'Error updating user data']);
            exit();
        }

        if (isset($parsedData['photo'])) {
            $targetDirectory = 'userphotos/';
            if (!file_exists($targetDirectory)) {
                mkdir($targetDirectory, 0755, true);
            }

            $existingPhoto = $targetDirectory . $userId . ".png";
            if (file_exists($existingPhoto)) {
                unlink($existingPhoto);
            }

            $targetFile = $targetDirectory . $userId . ".png";
            file_put_contents($targetFile, $parsedData['photo']);

            $photoQuery = "UPDATE `user` SET `photo` = '$targetFile' WHERE `id` = '$userId'";
            mysqli_query($conn, $photoQuery);

            echo json_encode(['success' => true, 'message' => 'User data and photo updated successfully']);
        } else {
            echo json_encode(['success' => true, 'message' => 'User data updated successfully (no photo uploaded)']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User ID is missing from the request']);
    }

    mysqli_close($conn);
}