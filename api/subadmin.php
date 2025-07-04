<?php
session_start();

include '../config.php';
function getInputData()
{
    $input = file_get_contents("php://input");
    if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
        return json_decode($input, true);
    } else {
        parse_str($input, $data);
        return $data;
    }
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo = $_FILES['photo'];

        $fileName = $photo['name'];
        $fileTmpName = $photo['tmp_name'];
        $fileSize = $photo['size'];
        $fileError = $photo['error'];

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExt, $allowed)) {
            $uploadDir = 'subadminImages/';
            $filePath = $uploadDir . basename($fileName);

            if (move_uploaded_file($fileTmpName, $filePath)) {
                $sql = "INSERT INTO subadmin (username, email, phone, password, location, photo) 
                        VALUES ('$username', '$email', '$phone', '$password', '$address', '$filePath')";

                if (mysqli_query($conn, $sql)) {
                    echo json_encode(['status' => 'success', 'message' => 'User added successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error adding user to database.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error uploading photo.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid file type.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No photo uploaded or error occurred during upload.']);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = getInputData();

    if (empty($data['id']) || empty($data['username']) || empty($data['phone']) || empty($data['location']) || empty($data['password']) || empty($data['email'])) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit();
    }

    $date = date('d/m/y');
    date_default_timezone_set("Asia/Kolkata");
    $time = date('h:i:s');

    $id = $_SESSION['aId'];
    $name = $data['username'];
    $phone = $data['phone'];
    $address = $data['location'];
    $password = $data['password'];
    $email = $data['email'];

    $sql = mysqli_query($conn, "UPDATE subadmin SET username='$name', password='$password', email='$email', phone='$phone', location='$address' WHERE id='$id'");

    if ($sql) {
        echo json_encode(['status' => 'success', 'message' => 'User updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'An error occurred while updating the user.']);
    }
}
?>
