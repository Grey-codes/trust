<!DOCTYPE html>
<html lang="en">
<?php

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    $query = "SELECT * FROM village_survey WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Student not found.";
        exit();
    }
} else {
    echo "Student ID is missing.";
    exit();
}
?>

<main>
    <div class="container" style="padding: 10ex;">
        <?php if (!empty($_GET['status'])) {
            $status = $_GET['status'];
            if ($status == 1) {
                echo '<br><div class="alert alert-success" role="alert">Approved Successfully</div>';
            } else if ($status == 3) {
                echo '<br><div class="alert alert-warning" role="alert">Rejected Successfully</div>';
            } else {
                echo '<br><div class="alert alert-danger" role="alert">Error! Incorrect Data Found</div>';
            }
        } ?>
<div id="student-details" class="p-4 rounded-4 shadow" style="background-color:rgb(239, 241, 243);">

            <?php
            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="id">';
            echo '<div>Application No</div>';
            echo '<div>:</div>';
            echo '<div>' . $student["id"] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="REGION">';
            echo '<div>REGION</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['REGION'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="VILLAGE_NAME">';
            echo '<div>VILLAGE_NAME</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['VILLAGE_NAME'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="VILLAGE_POPULATION">';
            echo '<div>VILLAGE_POPULATION</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['VILLAGE_POPULATION'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="GRAM_PANCHAYAT_NAME">';
            echo '<div>GRAM_PANCHAYAT_NAME</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['GRAM_PANCHAYAT_NAME'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="PANCHAYAT_POPULATION">';
            echo '<div>PANCHAYAT_POPULATION</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['PANCHAYAT_POPULATION'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="MANDAL_NAME">';
            echo '<div>MANDAL_NAME</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['MANDAL_NAME'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="DISTRICT_NAME">';
            echo '<div>DISTRICT_NAME</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['DISTRICT_NAME'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="STATE">';
            echo '<div>STATE</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['STATE'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="PINCODE">';
            echo '<div>PINCODE</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['PINCODE'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="LATITUDE">';
            echo '<div>LATITUDE</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['LATITUDE'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="LONGITUDE">';
            echo '<div>LONGITUDE</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['LONGITUDE'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="NUMBER_OF_TEMPLE">';
            echo '<div>NUMBER_OF_TEMPLE</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['NUMBER_OF_TEMPLE'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="NUMBER_OF_CHURCHES">';
            echo '<div>NUMBER_OF_CHURCHES</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['NUMBER_OF_CHURCHES'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="NUMBER_OF_MOSQUES">';
            echo '<div>NUMBER_OF_MOSQUES</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['NUMBER_OF_MOSQUES'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="VILLAGE_LEADER_NAME">';
            echo '<div>VILLAGE_LEADER_NAME</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['VILLAGE_LEADER_NAME'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="REQUESTED_FOR">';
            echo '<div>REQUESTED_FOR</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['REQUESTED_FOR'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="DETAILS_FOR_PROGRAMS">';
            echo '<div>DETAILS_FOR_PROGRAMS</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['DETAILS_FOR_PROGRAMS'] . '</div>';
            echo '</div>';

            echo '<div id="ngo" style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="REQUESTED_THROUGH">';
            echo '<div>REQUESTED_THROUGH</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['REQUESTED_THROUGH'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="REQUESTED_BY_NAME">';
            echo '<div>REQUESTED_BY_NAME</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['REQUESTED_BY_NAME'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="REQUESTED_DETAILS">';
            echo '<div>REQUESTED_DETAILS</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['REQUESTED_DETAILS'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="REQUESTED_PHONE_NUMBER">';
            echo '<div>REQUESTED_PHONE_NUMBER</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['REQUESTED_PHONE_NUMBER'] . '</div>';
            echo '</div>';

            echo '<div id="ngo" style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="FINAL_DECISION">';
            echo '<div>FINAL_DECISION</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['FINAL_DECISION'] . '</div>';
            echo '</div>';

            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="FINAL_DECISION_REASON">';
            echo '<div>FINAL_DECISION_REASON</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['FINAL_DECISION_REASON'] . '</div>';
            echo '</div>';

            echo '<div id="ngo" style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" data-field="NGO_NAME">';
            echo '<div>25. NGO Name</div>';
            echo '<div>:</div>';
            echo '<div>' . $student['NGO_NAME'] . '</div>';
            echo '</div>';
            ?>
        </div>

        <!-- <div id="actionbuttons">
            <?php
            if ($student['status'] !== 2) {
                echo '<div class="col-4" style="padding:40px 0%;">';
                echo '<center>';
                echo ' <button type="button" onclick="saveChanges(2)" class="btn btn-success col-6 mt-4"><iconify-icon icon="ic:baseline-verified"></iconify-icon>Aprove</button>';
                echo '</center>';
                echo '</div>';
            }
            if ($student['status'] !== 3) {
                echo '<div class="col-4" style="padding:40px 0%;">';
                echo '<center>';
                echo '<button type="button" onclick="saveChanges(3)" class="btn btn-danger col-6 mt-4"><iconify-icon icon="healthicons:x-negative"></iconify-icon> <span>Reject</span></button>';
                echo '</center>';
                echo '</div>';
            }
            ?>
        </div> -->

        <center>
        <div class="row" style="padding:40px 0%;">
                <div class="row">
                <button type="button" onclick="printModal()" class="btn btn-primary col-3 mx-4">
                    <iconify-icon icon="ic:round-print"></iconify-icon> Print
                </button>
                <button type="button" onclick="toggleEditMode()" id="edit-button" class="btn btn-warning col-3 mx-4">
                    <iconify-icon icon="mdi:pencil"></iconify-icon> Edit
                </button>
                <button type="button" onclick="saveChanges(<?php echo $student['status'] ?>)" id="save-button"
                    class="btn btn-success col-3 mx-4" style="display: none;">
                    <iconify-icon icon="mdi:content-save"></iconify-icon> Save
                </button>
                <button type="button" onclick="cancelChanges()" id="cancel-button" class="btn btn-secondary col-3"
                    style="display: none;">
                    Cancel
                </button>
            </center>
        </div>
        </div>
    </div>
    <script>
        const commonApiPath = window.location.origin+"/trust/api/";

        function toggleEditMode() {
            const fields = document.querySelectorAll('#student-details div[data-field]');
            fields.forEach(field => {
                const fieldName = field.getAttribute('data-field');
                if (fieldName !== 'id') {
                    const value = field.textContent.split(':')[1].trim();
                    field.innerHTML = `
                        <div>${fieldName}</div>
                        <div>:</div>
                        <div><input style="width:500px;" type="text" id="edit-${fieldName}" value="${value}" class="form-control"></div>
                        `;
                }
            });

            document.getElementById('edit-button').style.display = 'none';
            document.getElementById('save-button').style.display = 'inline-block';
            document.getElementById('cancel-button').style.display = 'inline-block';
            document.getElementById('actionbuttons').style.display = 'none';
        }

        function cancelChanges() {
            location.reload()
        }

        function saveChanges(status) {
            const studentId = <?php echo $student['id']; ?>;
            const updatedData = new FormData();
            const existingStatus = <?php echo $student['status']; ?>;
            const studentData = <?php echo json_encode($student); ?>

            updatedData.append('status', status)

            const fields = document.querySelectorAll('#student-details div[data-field]');
            fields.forEach(field => {
                const fieldName = field.getAttribute('data-field');
                if (status == existingStatus) {
                    if (fieldName == 'id') {
                        updatedData.append(fieldName, studentId);
                    }
                    else {
                        const value = document.getElementById(`edit-${fieldName}`).value;
                        updatedData.append(fieldName, value);
                    }
                }
                else {
                    const value = studentData[fieldName];
                    updatedData.append(fieldName, value);
                }
            });

            fetch(commonApiPath+`village_survey.php?id=${studentId}`, {
                method: 'PUT',
                body: updatedData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error updating widow details.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function printModal() {
            var modalContent = document.getElementById('student-details');
             const ngo = <?php echo json_encode($student['NGO_NAME'] ?? ''); ?>;
            // var ngo = prompt("Enter NGO Name");

            var printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>Print</title>');
            printWindow.document.write('<link rel="stylesheet" type="text/css" href="style.css">');
            printWindow.document.write('<style>');
            printWindow.document.write('html, body { margin: 0; padding: 0; font-size: 12px; }');
            printWindow.document.write('@page { size: A4; margin: 0; }');
            printWindow.document.write('@media print { #ngo * { display: none; }  }');
            printWindow.document.write('body { font-family: Arial, sans-serif; margin: 1cm; padding: 10px; }');
            printWindow.document.write('#not, #close { display:none; }');
            printWindow.document.write('.map { display:none; }');
            printWindow.document.write('.row { page-break-inside: avoid; }');
            printWindow.document.write('</style>');
            printWindow.document.write("<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'>");
            printWindow.document.write('</head><body><div style="margin:10px; border:2px solid black; padding:10px; border-radius:5px;">');

            printWindow.document.write("<center><div class='row'><div class='col-11'><h2>" + ngo + "</h2></div></div></center>");
             printWindow.document.write("<center><div class='row'><div class='col-11'><h3> Village Application </h3></div></div><hr></center>");
            printWindow.document.write(modalContent.innerHTML);
            printWindow.document.write("<div class='row'><div class='col-6'>Date :</div><div class='col-6'>Place :</div><br><br><div class='col-6'>Applicant Signature :</div></div>");
            printWindow.document.write('</body></html>');
            printWindow.document.close();

            printWindow.onload = function () {
                printWindow.print();
                printWindow.close();
            };
        }
    </script>
</main>