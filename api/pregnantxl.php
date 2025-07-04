<?php
session_start();
include '../config.php'; // Your DB connection

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="pregnant_data.csv"');

$output = fopen('php://output', 'w');

// Define the columns
$columns = [
    'id', 'time', 'date', 'refer', 'sub_refer', 'PREGNANT_NAME', 'DATE_OF_BIRTH', 'AADHAR_CARD_NUMBER',
    'EDUCATION', 'HUSBAND_NAME', 'DELIVERY_DATE', 'MARRIAGE_DATE', 'NUMBER_OF_CHILDREN',
    'HEALTH_PROBLEMS', 'PRESENT_LIVING_STATUS', 'Door_Number', 'Street', 'VILLAGE_NAME',
    'Mandal', 'City', 'Pincode', 'District', 'State', 'Country', 'PHONE_NUMBER',
    'REQUESTED_THROUGH', 'REQUESTED_BY_NAME', 'REQUESTED_PLACE', 'REQUESTED_PHONE_NUMBER',
    'NGO_NAME', 'status', 'photo', 'Full_Photo', 'LATITUDE', 'LONGITUDE'
];

// Output the header
fputcsv($output, $columns);

// Base query
$sql = "SELECT " . implode(',', $columns) . " FROM pregnant";

// Check session and modify query if needed
if (!empty($_SESSION['userid'])) {
    $userid = mysqli_real_escape_string($conn, $_SESSION['userid']);
    $sql .= " WHERE sub_refer = '$userid'";
}

$result = mysqli_query($conn, $sql);

// Output each row
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
