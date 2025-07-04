<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Define all column names (must match input names from form)
    $columns = [
        'Village_Name', 'Mandal_Name', 'District_Name', 'State_Name', 'Type_of_drilling',
        'If_drilling_with_rig_type_of_rig', 'Drilling_depth_in_feet', 'Dimensions_of_casing',
        'Casing_thickness_in_MM', 'Casing_diameter_in_Inches', 'Depth_of_casing_in_feet',
        'Ground_water_level_in_feet', 'Type_of_hand_pump', 'Water_pipe_length', 'Number_of_Pipes_used',
        'Number_of_Rods_used', 'Number_of_Couplings_fitted', 'Depth_of_Cylinder', 'Hand_set_paint',
        'Type_of_Platfor', 'Plaque_type', 'If_special_mention_the_name', 'Latitude', 'Longitude',
        'Type_of_Soil', 'Static_water_level', 'Total_depth_of_drilling', 'Operator_Name_And_Contact_No',
        'Owner_Name_And_Contact_No', 'Vehicle_RC_No', 'House_owner_Full_Name_1', 'Contact_no_1',
        'Signature_1', 'House_owner_Full_Name_2', 'Contact_no_2', 'Signature_2', 'Final_Status',
        'NUMBER_Of_PANCHAYAT_TANKS_AVAILABLE', 'NUMBER_OF_PANCHAYAT_TAPS', 'NUMBER_OF_OPEN_GROUND_WELLS',
        'NUMBER_OF_PANCHAYAT_BORE_WELLS', 'NUMBER_OF_NGO_WELLS', 'MENTION_DETAILS', 'DATE_OF_DRILLING',
        'PRESENT_WELL_CONDITION', 'NAME_OF_NGO', 'NUMBER_OF_HOUSE_HOLDS_INTENDED_TO_BE_SERVED',
        'SELF_MADE_BORE_WELLS_DETAILS', 'Verified_By', 'Place', 'Phone_Number'
    ];

    $updates = [];
    $params = [];
    $types = '';

    foreach ($columns as $col) {
        $updates[] = "$col = ?";
        $params[] = $_POST[$col] ?? '';
        $types .= 's'; // assume all are strings for now
    }

    $params[] = $id;
    $types .= 'i';

    $sql = "UPDATE borewell SET " . implode(', ', $updates) . " WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute()) {
            header("Location: ../trustsub/sub/viewBorewell.php?status=1");
            exit;
        } else {
            header("Location: ../trustsub/sub/viewBorewell.php?status=0");
            exit;
        }
    } else {
        echo "SQL Error: " . $conn->error;
    }
} else {
    echo "Invalid Request.";
}
?>
