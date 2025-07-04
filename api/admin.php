<?php
session_start();

if (!isset($_SESSION['aId'])) {
    header("location:../index.php");
    exit();
}

header('Content-Type: application/json');

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

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = getInputData();

    if (empty($data['id']) || empty($data['name']) || empty($data['phone']) || empty($data['address']) || empty($data['password']) || empty($data['email'])) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit();
    }

    $date = date('d/m/y');
    date_default_timezone_set("Asia/Kolkata");
    $time = date('h:i:s');

    $id = $_SESSION['aId'];
    $name = $data['name'];
    $phone = $data['phone'];
    $address = $data['address'];
    $password = $data['password'];
    $email = $data['email'];

    // Update query
    $sql = mysqli_query($conn, "UPDATE `admin` SET `username`='$name', `password`='$password', `email`='$email', `phone`='$phone', `location`='$address' WHERE id='$id'");

    if ($sql) {
        // If update is successful
        echo json_encode(['status' => 'success', 'message' => 'User updated successfully.']);
    } else {
        // If update fails
        echo json_encode(['status' => 'error', 'message' => 'An error occurred while updating the user.']);
    }
}
?>