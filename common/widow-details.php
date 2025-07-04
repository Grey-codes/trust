<!DOCTYPE html>
<html lang="en">
<?php

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    $query = "SELECT * FROM widow_aged WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Widow record not found.";
        exit();
    }
} else {
    echo "Widow ID is missing.";
    exit();
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Widow Details</title>
    <script src="https://code.iconify.design/3/iconify.min.js"></script>
    <style>
        .detail-row {
            display: grid;
            grid-template-columns: 30% 5% 65%;
            margin-bottom: 8px;
            align-items: center;
        }
        .detail-label {
            font-weight: 600;
        }
        .action-btns button {
            margin: 5px;
        }
        #student-details {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            background: #f9f9f9;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
        }
        #photo-container {
            position: absolute;
            right: 50px;
            top: 100px;
        }

        @media print {
            body {
                font-size: 14px;
                margin: 10px;
                padding: 10px;
            }
            .action-btns, #edit-button, #save-button, #cancel-button, #photo-container {
                display: none !important;
            }
            #student-details {
                box-shadow: none;
                background: none;
                border: none;
            }
        }
    </style>
</head>
<body>
<main class="container mt-4">
    <?php if (!empty($_GET['status'])) {
        $status = $_GET['status'];
        echo '<div class="alert ' . ($status == 1 ? 'alert-success' : ($status == 3 ? 'alert-warning' : 'alert-danger')) . '" role="alert">';
        echo $status == 1 ? 'Approved Successfully' : ($status == 3 ? 'Rejected Successfully' : 'Error! Incorrect Data Found');
        echo '</div>';
    } ?>


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
            elseif (!empty($_SESSION['aId']) ) {
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

    <div class="position-relative">
        <div id="student-details">
                <div id="photo-container">
        <img src="<?php echo '/trust/api/widow/' . $student['photo']; ?>" style="height:120px; width:120px; border-radius:10%; border:2px solid #555;">
    </div>
    <div class="row">
        
        
    
            <?php
            $i = 1;
           
            foreach ($student as $key => $value) {
             
                
                if (in_array($key, ['app_type','time','date','refer','sub_refer','photo', 'Full_Photo', 'status','LONGITUDE','LATITUDE'])) continue;
                echo "<div id='$key' class='detail-row' data-field='$key'><div class='detail-label'>$i. $key</div><div>:</div><div>$value</div></div>";
            
            $i++;
        }
            ?>
        </div>
    </div>

    <div class="action-btns text-center mt-4">


        <button class="btn btn-primary" onclick="printModal()"><span class="iconify" data-icon="ic:round-print"></span> Print</button>
        <button class="btn btn-warning" id="edit-button" onclick="toggleEditMode()"><span class="iconify" data-icon="mdi:pencil"></span> Edit</button>
        <button class="btn btn-success" id="save-button" style="display:none;" onclick="saveChanges(<?php echo $student['status']; ?>)"><span class="iconify" data-icon="mdi:content-save"></span> Save</button>
        <button class="btn btn-secondary" id="cancel-button" style="display:none;" onclick="cancelChanges()">Cancel</button>
    </div>
</main>

<script>
    const commonApiPath = window.location.origin + "/trust/api/";

    function toggleEditMode() {
        const fields = document.querySelectorAll('#student-details .detail-row');
        fields.forEach(row => {
            const fieldName = row.getAttribute('data-field');
            const value = row.children[2].textContent.trim();
            row.children[2].innerHTML = `<input type="text" class="form-control" id="edit-${fieldName}" value="${value}">`;
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
    }

    function cancelChanges() {
        location.reload();
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

        fetch(`${commonApiPath}widow_aged.php?id=${studentId}`, {
            method: 'PUT',
            body: updatedData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Updated successfully');
                location.reload();
            } else {
                alert('Update failed');
            }
        })
        .catch(err => console.error(err));
    }

function printModal() {
    const details = document.getElementById('student-details').innerHTML;
    const photoUrl = "<?php echo '/trust/api/widow/' . $student['photo']; ?>";
    const ngo = <?php echo json_encode($student['NGO_NAME'] ?? 'NGO'); ?>;
    const heading = <?php echo json_encode($student['app_type'] == 0 ? 'Widow' : 'Old Age'); ?>;

    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
        <head>
            <title>Application Form</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
            <style>
                @page {
                    size: A4;
                    margin: 1cm;
                }
                body {
                    font-family: Arial, sans-serif;
                    font-size: 15px;
                    margin: 0;
                    padding: 10px;
                }
                .application-container {
                    border: 1px solid #000;
                    padding: 15px;
                    border-radius: 5px;
                    max-width: 100%;
                }
                h2 {
                    text-align: center;
                    font-size: 20px;
                    margin-bottom: 20px;
                    text-transform: uppercase;
                    font-weight: bold;
                }
                .row-layout {
                    display: flex;
                    flex-direction: row;
                    justify-content: space-between;
                    gap: 40px;
                }
                .details-section {
                    flex: 1;
                }
                .detail-row {
                    display: grid;
                    grid-template-columns: 50% 5% 45%;
                    margin-bottom: 5px;
                }
                .right-photo {
                    flex: 0 0 120px;
                    text-align: center;
                }
                .right-photo img {
                    height: 120px;
                    width: 100px;
                    border: 2px solid #444;
                    border-radius: 5px;
                }
                .signatures {
                    margin-top: 30px;
                    display: flex;
                    justify-content: space-between;
                    font-size: 11px;
                }

                @media print {
                    #NGO_NAME * {
                        display: none;
                    }
                }
            </style>
        </head>
        <body>
            <div class="application-container">
                <h2>${ngo}</h2>
                <h3>${heading} Application</h3>
                <div class="row-layout">
                    <div class="details-section">
                        ${details}
                    </div>
                    <div class="right-photo">
                        <img src="${photoUrl}" alt="Photo"><br>
                        <small>Applicant Photo</small>
                    </div>
                </div>
                <div class="signatures">
                    <div>Date: _______________</div>
                    <div>Place: _______________</div>
                </div>
                <div class="signatures">
                    <div>Applicant Signature: _______________</div>
                </div>
            </div>
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.onload = () => {
        printWindow.print();
        printWindow.close();
    };
}




</script>
</body>
</html>
