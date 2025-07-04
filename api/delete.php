<?php
include '../config.php';

if (!empty($_GET)) {
    $id = $_GET['id'];
    $type = $_GET['type'];
    $admin = $_GET['admin'];

    $redirectBase = ($admin == 1) ? "../trustsub/sub/" : "../trustadmin/admin/";

    switch ($type) {
        case 1: // student
            $table = "student";
            $redirect = "viewStudent.php";
            break;

        case 2: // pregnant
            $table = "pregnant";
            $redirect = "viewPregnant.php";
            break;

        case 3: // widow
            $table = "widow_aged";
            $redirect = "viewWidow.php";
            break;

        case 4: // aged (same table as widow_aged)
            $table = "widow_aged";
            $redirect = "viewAged.php";
            break;

        case 5: // village survey
            $table = "village_survey";
            $redirect = "viewVillage.php";
            break;

        case 6: // medical camp
            $table = "medicalcamp";
            $redirect = "viewMedicalCamp.php";
            break;
        case 7: // borewell camp
            $table = "borewell";
            $redirect = "viewBorewell.php";
            break;
        case 8: // other actives
            $table = "otheractivities";
            $redirect = "viewActivities.php";
            break;

        default:
            echo "Invalid type provided.";
            exit();
    }

    if ($table == 'medicalcamp') {
        $sql1 = "DELETE FROM `medical_camp_records` WHERE medical_camp_id='$id'";
        if (mysqli_query($conn, $sql1)) {
            $sql = "DELETE FROM `$table` WHERE id='$id'";
        }
        else {
            header("Location: " . $redirectBase . $redirect);
            exit;
        }
    }
    else {
        $sql = "DELETE FROM `$table` WHERE id='$id'";
    }
    if (mysqli_query($conn, $sql)) {
        header("Location: " . $redirectBase . $redirect);
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
