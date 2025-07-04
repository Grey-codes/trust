<!DOCTYPE html>
<html lang="en">
<?php

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    $query = "SELECT * FROM student WHERE id = ?";
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
    <div class="container">
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
      <style>
    #student-details {
        max-width: 900px;
        margin: 30px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: relative;
    }

    .field-row {
        display: flex;
        margin-bottom: 15px;
    }

    .field-label {
        width: 30%;
        font-weight: bold;
    }

    .field-colon {
        width: 10px;
    }

    .field-value {
        width: 65%;
    }

    #student-photo {
        position: absolute;
        top: 20px;
        right: 20px;
        border: 2px solid #333;
        border-radius: 10px;
        height: 120px;
        width: 120px;
        object-fit: cover;
        padding: 5px;
        background-color: white;
    }
</style>

<div class="row">

        <div id="actionbuttons" class="row m-4">
            <center>
            <?php
             if (!empty($_SESSION['userId']) ) {
               if ($student['status'] == 0) {
                echo '<div class="col-4" style="padding:40px 0%;">';
                echo '<center>';
                echo ' <button type="button" onclick="saveChanges(1)" class="btn btn-primary col-6 mt-4"><iconify-icon icon="ic:baseline-verified"></iconify-icon>Aprove</button>';
                echo '</center>';
                echo '</div>';
               }
            }
            if (!empty($_SESSION['aId']) ) {
                echo "<div class='row'>";
                if ($student['status'] !=2) {
                echo '<div class="col-4" >';
                echo '<center>';
                echo ' <button type="button" onclick="saveChanges(2)" class="btn btn-success col-6 mt-4"><iconify-icon icon="ic:baseline-verified"></iconify-icon>Aprove</button>';
                echo '</center>';
                echo '</div>';
                }
                if($student['status'] !=3){
                echo '<div class="col-4" >';
                echo '<center>';
                echo '<button type="button" onclick="saveChanges(3)" class="btn btn-danger col-6 mt-4"><iconify-icon icon="healthicons:x-negative"></iconify-icon> <span>Reject</span></button>';
                echo '</center>';
                echo '</div>';
                }
                echo "</div>";
            }
            ?>
        </center>
        </div>


<div id="student-details">
    <img id="student-photo" src="" alt="Student Photo">

    <?php
    $fields = [
        "id" => "1. Application No",
        "Child_Aadhar_No" => "2. Child Aadhar",
        "Student_Full_Name" => "3. Student Full Name",
        "Date_of_Birth" => "4. Date of Birth / Age",
        "Class" => "5. Class",
        "School_or_College_Name" => "6. School / College Name",
        "Father_Name" => "7. Father Name",
        "Father_Aadhar" => "7. Father Aadhar",
        "Mother_Name" => "8. Mother Name",
        "Mother_Aadhar" => "8. Mother Aadhar",
        "Religious" => "9. Religious",
        "Caste_And_Sub_Caste" => "10. Caste and Sub-Caste",
        "Favorite_Subject" => "11. Favorite Subject",
        "Favorite_Colour" => "12. Favorite Colour",
        "Favorite_Game" => "13. Favorite Game",
        "Best_Friend" => "14. Best Friend",
        "Hobbies" => "15. Hobbies",
        "Goal" => "16. Goal",
        "Door_Number" => "17. Door Number",
        "Street" => "18. Street",
        "village" => "19. Village",
        "Mandal" => "20. Mandal",
        "City" => "21. City",
        "District" => "22. District",
        "State" => "23. State",
        "Pincode" => "24. Pincode",
        "Country" => "25. Country",
        "Parent_Contact" => "26. Parent Contact",
        "NGO_NAME" => "27. NGO Name",
    ];

    foreach ($fields as $key => $label) {
        echo '<div class="field-row" data-field="' . $key . '">';
        echo '<div class="field-label">' . $label . '</div>';
        echo '<div class="field-colon">:</div>';
        echo '<div class="field-value">' . htmlspecialchars($student[$key]) . '</div>';
        echo '</div>';
    }


    echo '<script>';
    echo 'document.getElementById("student-photo").src="'
    . htmlspecialchars($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/trust/api/student/' .  $student['photo'] , ENT_QUOTES, 'UTF-8').'"';
    echo '</script>';
    ?>
</div>

        <center>
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
           
        </div>
        </div>
        </center>
    </div>
    <div>
    <script>
        const commonApiPath = window.location.origin+"/trust/api/";

        function toggleEditMode() {
            const fields = document.querySelectorAll('#student-details div[data-field]');
            fields.forEach(field => {
                const fieldName = field.getAttribute('data-field');
                if (fieldName !== 'id') {
                    const value = field.textContent.split(':')[1].trim();
                    field.innerHTML = `
                    <div class="row">
                        <div class="col-5">${fieldName}</div>
                        <div class="col-1">:</div>
                        <div class="col-6"><input type="text" id="edit-${fieldName}" value="${value}" class="form-control"></div>
                        `;
                }
            });

            // Add file input for photo
            const photoField = document.createElement('div');
            photoField.innerHTML = `
                <div>Photo</div>
                <div>:</div>
                <div><input type="file" id="edit-photo" class="form-control"></div>
                <div>Full Photo</div>
            <div>:</div>
            <div><input type="file" id="edit-full-photo" class="form-control"></div>
        `;
            document.getElementById('student-details').appendChild(photoField);

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

            if (status === existingStatus) {
                const photoFile = document.getElementById('edit-photo').files[0];
                if (photoFile) {
                    updatedData.append('photo', photoFile);
                }

                const fullphotoFile = document.getElementById('edit-full-photo').files[0];
                if (fullphotoFile) {
                    updatedData.append('Full_Photo', fullphotoFile);
                }
            }

            fetch(commonApiPath+`student.php?id=${studentId}`, {
                method: 'PUT',
                body: updatedData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error updating student details.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

    
    function printModal() {
    const modalContent = document.getElementById('student-details').cloneNode(true);

    // Remove existing image if any
    const existingImage = modalContent.querySelector('#student-photo');
    if (existingImage) existingImage.remove();

    // Ask NGO name
 const ngo = <?php echo json_encode($student['NGO_NAME'] ?? ''); ?>;

    // Get student photo
    const imageSrc = document.getElementById('student-photo')?.src || '';

    // Open new print window
    const printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Print</title>');

    // Styles
    printWindow.document.write(`
        <style>
            @page { size: A4; margin: 1.5cm; }
            body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
            .content {
                padding: 20px;
                box-sizing: border-box;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 13px;
            }
            td {
                padding: 6px;
                vertical-align: top;
            }
            .label {
                font-weight: bold;
                width: 40%;
            }
            .colon {
                width: 10px;
            }
            .value {
                width: 60%;
            }
            .photo-cell {
                text-align: center;
            }
            .photo-cell img {
                border: 2px solid #000;
                border-radius: 10px;
                height: 120px;
                width: 120px;
                object-fit: cover;
                margin-left: 10px;
            }
            .signature-section {
                margin-top: 40px;
                font-size: 14px;
            }
        </style>
    `);

    printWindow.document.write('</head><body>');
    printWindow.document.write('<div class="content border border-dark" style="border:2px solid black; border-radius:0px;">');

    // NGO Title
    printWindow.document.write('<center><div class="text-center mb-3"><h3>' + ngo + '</h3></div> </center>');
    printWindow.document.write('<center><div class="text-center mb-3"><h4> Child Application </h4 ></div> </center>');

    // Start table
    printWindow.document.write('<table>');

    const rows = modalContent.querySelectorAll('[data-field]');
    const totalRows = rows.length;

    rows.forEach((row, index) => {
        const label = row.children[0]?.textContent || '';
        const value = row.children[2]?.textContent || '';

        printWindow.document.write('<tr>');
if(index<27){
        printWindow.document.write('<td class="label">' + label + '</td>');
        printWindow.document.write('<td class="colon">:</td>');
        printWindow.document.write('<td class="value">' + value + '</td>');
}
        // Add image in the first row, spanning 4 rows
        if (index === 0) {
            printWindow.document.write('<td class="photo-cell" rowspan="4">');
            if (imageSrc) {
                printWindow.document.write('<img src="' + imageSrc + '" alt="Student Photo">');
            }
            printWindow.document.write('</td>');
        }

        printWindow.document.write('</tr>');
    });

    printWindow.document.write('</table>');

    // Signature section
    printWindow.document.write(`
        <div class="signature-section">
            <table>
                <tr>
                    <td>Date :</td>
                    <td>Place :</td>
                </tr>
                <tr>
                    <td>Child Signature :</td>
                    <td>Parent/Guardian Signature :</td>
                </tr>
            </table>
        </div>
    `);

    printWindow.document.write('</div></body></html>');
    printWindow.document.close();

    // Trigger print
    printWindow.onload = function () {
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    };
}


    </script>
</main>