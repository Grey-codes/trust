<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Only run if POST data is received
if (!empty($_POST)) {
    include '../config.php'; // Adjust path if needed

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Collect POST data safely
    $ref            = mysqli_real_escape_string($conn, $_POST['ref'] ?? '');
    $campaign_place = mysqli_real_escape_string($conn, $_POST['campaign_place'] ?? '');
    $panchayat      = mysqli_real_escape_string($conn, $_POST['panchayat'] ?? '');
    $date           = mysqli_real_escape_string($conn, $_POST['date'] ?? '');
    $village        = mysqli_real_escape_string($conn, $_POST['VILLAGE_NAME'] ?? '');
    $mandal         = mysqli_real_escape_string($conn, $_POST['mandal'] ?? '');
    $district       = mysqli_real_escape_string($conn, $_POST['district'] ?? '');
    $state          = mysqli_real_escape_string($conn, $_POST['state'] ?? '');
    $pin            = mysqli_real_escape_string($conn, $_POST['pin'] ?? '');

    // Set default image
    $default_image = 'default.jpg';

    // Validate required fields
    if (
        empty($campaign_place) || empty($panchayat) || empty($date) || empty($village) ||
        empty($mandal) || empty($district) || empty($state) || empty($pin)
    ) {
        echo "Error: All fields are required.";
        exit;
    }

    // Insert query with 10 values including default image
    $sql = "INSERT INTO medicalcamp 
        (`ref`, `campaign_place`, `panchayat`, `date`, `VILLAGE_NAME`, `mandal`, `district`, `state`, `pin`, `images`) 
        VALUES 
        ('$ref', '$campaign_place', '$panchayat', '$date', '$village', '$mandal', '$district', '$state', '$pin', '$default_image')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully.";
       header("Location: ../trustsub/sub/viewMedicalCamp.php");
exit;

    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "No data received.";
}
?>
