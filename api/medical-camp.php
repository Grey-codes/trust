<?php
session_start();
include '../config.php';

header('Content-Type: application/json');

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

    if (empty($data['id']) || empty($data['campaign_place']) || empty($data['panchayat']) || empty($data['date']) || empty($data['mandal']) || empty($data['district']) || empty($data['state']) || empty($data['pin'])) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit();
    }

    $id = $data['id'];
    $campaign_place = $data['campaign_place'];
    $panchayat = $data['panchayat'];
    $date = $data['date'];
    $mandal = $data['mandal'];
    $district = $data['district'];
    $state = $data['state'];
    $pin = $data['pin'];

    $query = "UPDATE medicalcamp SET 
              campaign_place = ?, 
              panchayat = ?, 
              date = ?, 
              mandal = ?, 
              district = ?, 
              state = ?, 
              pin = ? 
              WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssi", $campaign_place, $panchayat, $date, $mandal, $district, $state, $pin, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Medical camp details updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating medical camp details: ' . $stmt->error]);
    }

    $stmt->close();
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = getInputData();

    if (empty($data['id'])) {
        echo json_encode(['success' => false, 'message' => 'Record ID is required']);
        exit();
    }

    $id = $data['id'];

    $query = "DELETE FROM medical_camp_records WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Record deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting record: ' . $stmt->error]);
    }

    $stmt->close();
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = getInputData();

    if (empty($data['type'])) {
        echo json_encode(['success' => false, 'message' => 'Type is required']);
        exit();
    }

    if ($data['type'] === 'medical-camp-record') {
        if (empty($data['medical_camp_id']) || empty($data['name']) || empty($data['gender']) || empty($data['uid_or_ration_no']) || empty($data['age']) || empty($data['relation']) || empty($data['phone']) || empty($data['address'])) {
            echo json_encode(['success' => false, 'message' => 'All fields are required']);
            exit();
        }

        $medical_camp_id = $data['medical_camp_id'];
        $name = $data['name'];
        $gender = $data['gender'];
        $uid_or_ration_no = $data['uid_or_ration_no'];
        $age = $data['age'];
        $relation = $data['relation'];
        $phone = $data['phone'];
        $address = $data['address'];

        $query = "INSERT INTO medical_camp_records (medical_camp_id, name, gender, uid_or_ration_no, age, relation, phone, address) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isssisss", $medical_camp_id, $name, $gender, $uid_or_ration_no, $age, $relation, $phone, $address);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Record added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error adding record: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        if (empty($data['ref']) || empty($data['campaign_place']) || empty($data['panchayat']) || empty($data['date']) || empty($data['VILLAGE_NAME']) || empty($data['mandal']) || empty($data['district']) || empty($data['state']) || empty($data['pin'])) {
            echo json_encode(['success' => false, 'message' => 'All fields are required']);
            exit();
        }

        $ref = $data['ref'];
        $campaign_place = $data['campaign_place'];
        $panchayat = $data['panchayat'];
        $date = $data['date'];
        $village = $data['VILLAGE_NAME'];
        $mandal = $data['mandal'];
        $district = $data['district'];
        $state = $data['state'];
        $pin = $data['pin'];

        $query = "INSERT INTO medicalcamp (ref, campaign_place, panchayat, date, VILLAGE_NAME, mandal, district, state, pin) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issssssss", $ref, $campaign_place, $panchayat, $date, $village, $mandal, $district, $state, $pin);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Medical camp created successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error creating medical camp: ' . $stmt->error]);
        }

        $stmt->close();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>