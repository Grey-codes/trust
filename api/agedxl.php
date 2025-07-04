<?php
session_start();
include '../config.php'; // Your DB connection

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="oldage_data.csv"');

$output = fopen('php://output', 'w');

// Define the columns
$columns = [
    'id', 'app_type', 'time', 'date', 'refer', 'sub_refer', 'NAME_OF_THE_APPLICANTE', 'DATE_OF_BIRTH',
    'AADHAR_CARD_NUMBER', 'HUSBAND_NAME', 'MARRIAGE_DATE', 'NUMBER_OF_CHILDREN', 'HUSBAND_PASSED_YEAR',
    'CAUSE_OF_DEATH', 'RECEVING_PENSION', 'HEALTH_PROBLEMS', 'PRESENT_LIVING_STATUS', 'Door_Number',
    'Street', 'Village', 'City', 'MANDAL_NAME', 'DISTRICT_NAME', 'STATE', 'PINCODE', 'PHONE_NUMBER',
    'REQUESTED_THROUGH', 'REQUESTED_BY_NAME', 'REQUESTED_PLACE', 'REQUESTED_PHONE_NUMBER',
    'status', 'photo', 'Full_Photo', 'LATITUDE', 'LONGITUDE', 'NGO_NAME'
];

// Output the header
fputcsv($output, $columns);

// Start query
$sql = "SELECT " . implode(',', $columns) . " FROM widow_aged WHERE app_type=1";

// Add filter if session user id is set
if (!empty($_SESSION['userid'])) {
    $userid = mysqli_real_escape_string($conn, $_SESSION['userid']);
    $sql .= " sub_refer = '$userid'";
}

$result = mysqli_query($conn, $sql);

// Output data
while ($row = mysqli_fetch_assoc($result)) {
    $rowData = [];
    foreach ($columns as $col) {
        $rowData[] = $row[$col];
    }
    fputcsv($output, $rowData);
}

fclose($output);
exit;
?>
