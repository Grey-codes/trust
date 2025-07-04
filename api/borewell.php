<?php
include '../config.php';
session_start();
header('Content-Type: application/json');

function getInputData() {
    $input = file_get_contents("php://input");
    return ($_SERVER['CONTENT_TYPE'] === 'application/json')
        ? json_decode($input, true)
        : parse_str($input, $data) && $data;
}

// Helper: dynamically bind params by reference
function refValues(&$arr) {
    $refs = [];
    foreach ($arr as $key => $val) {
        $refs[$key] = &$arr[$key];
    }
    return $refs;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    if (empty($_SESSION['userId'])) {
        http_response_code(401);
        exit(json_encode(['success' => false, 'message' => 'Not authenticated']));
    }

    $data = getInputData();
    $required = ['camp_id','type','ref','Village_Name','Phone_Number'];
    foreach ($required as $f) {
        if (empty($data[$f])) {
            http_response_code(400);
            exit(json_encode(['success'=>false,'message'=>"Missing '$f'"]));
        }
    }

    unset($data['id']);
    $cols = array_keys($data);
    $placeholders = implode(', ', array_fill(0, count($cols), '?'));
    $colList = implode(', ', array_map(fn($c)=>"`$c`", $cols));
    $sql = "INSERT INTO borewell ($colList) VALUES ($placeholders)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        exit(json_encode(['success'=>false,'message'=>'Prepare failed']));
    }

    $types = '';
    $params = [];
    foreach ($data as $val) {
        $params[] = $val;
        $types .= is_int($val) ? 'i' : (is_float($val) ? 'd' : 's');
    }

    array_unshift($params, $types);
    call_user_func_array([$stmt, 'bind_param'], refValues($params));
    if ($stmt->execute()) {
        echo json_encode(['success'=>true,'message'=>'Entry created','id'=>$stmt->insert_id]);
    } else {
        http_response_code(500);
        echo json_encode(['success'=>false,'message'=>'Insert error']);
    }
    $stmt->close();
    exit;
}

if ($method === 'PUT') {
    $data = getInputData();
    if (empty($data['id'])) {
        http_response_code(400);
        exit(json_encode(['success'=>false,'message'=>'Missing id']));
    }

    $id = (int)$data['id'];
    unset($data['id']);
    if (empty($data)) {
        http_response_code(400);
        exit(json_encode(['success'=>false,'message'=>'No fields to update']));
    }

    $sets = [];
    foreach (array_keys($data) as $col) {
        $sets[] = "`$col` = ?";
    }
    $sql = "UPDATE borewell SET " . implode(', ', $sets) . " WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        exit(json_encode(['success'=>false,'message'=>'Prepare failed']));
    }

    $types = '';
    $params = [];
    foreach ($data as $val) {
        $params[] = $val;
        $types .= is_int($val) ? 'i' : (is_float($val) ? 'd' : 's');
    }
    $types .= 'i';
    $params[] = $id;

    array_unshift($params, $types);
    call_user_func_array([$stmt, 'bind_param'], refValues($params));
    if ($stmt->execute()) {
        echo json_encode(['success'=>true,'message'=>'Record updated']);
    } else {
        http_response_code(500);
        echo json_encode(['success'=>false,'message'=>'Update failed']);
    }
    $stmt->close();
    exit;
}

http_response_code(405);
echo json_encode(['success'=>false,'message'=>'Method not allowed']);
