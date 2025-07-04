<?php
header('Content-Type: application/json');
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (empty($data['campId'])) {
        echo json_encode(['success' => false, 'message' => 'Camp ID is required']);
        exit();
    }

    $campId = $data['campId'];

    if (!is_numeric($campId)) {
        echo json_encode(['success' => false, 'message' => 'Invalid Camp ID']);
        exit();
    }

    $deleteRecordsQuery = "DELETE FROM medical_camp_records WHERE id = $campId";
    $resultDeleteRecords = mysqli_query($conn, $deleteRecordsQuery);

    if ($resultDeleteRecords) {
        echo json_encode(['success' => true, 'message' => 'Medical camp and associated records deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting medical camp: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>