<!DOCTYPE html>
<html lang="en">
<?php
if (isset($_GET['id'])) {
    $pregant_id = $_GET['id'];
    $query = "SELECT * FROM pregnant WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $pregant_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $pregant = $result->fetch_assoc();
    } else {
        echo "Pregnant record not found."; exit();
    }
} else {
    echo "Pregnant ID is missing."; exit();
}
?>

<main>
    <script>
    const commonApiPath = window.location.origin + "/trust/api/";

    function toggleEditMode() {
        const fields = document.querySelectorAll('#pregant-details div[data-field]');
        fields.forEach(field => {
            const fieldName = field.getAttribute('data-field');
            if (fieldName !== 'id') {
                const value = field.querySelector('.field-value')?.textContent.trim() || '';
                field.innerHTML = `
                    <div class="field-label">${fieldName}</div>
                    <div class="field-colon">:</div>
                    <div class="field-value">
                        <input type="text" id="edit-${fieldName}" value="${value}" class="form-control">
                    </div>
                `;
            }
        });

        // Add photo upload fields
        const photoDiv = document.createElement('div');
        photoDiv.className = 'field-row';
        photoDiv.innerHTML = `
            <div class="field-label">Photo</div>
            <div class="field-colon">:</div>
            <div class="field-value"><input type="file" id="edit-photo" class="form-control"></div>
        `;
        document.getElementById('pregant-details').appendChild(photoDiv);

        const fullPhotoDiv = document.createElement('div');
        fullPhotoDiv.className = 'field-row';
        fullPhotoDiv.innerHTML = `
            <div class="field-label">Full Photo</div>
            <div class="field-colon">:</div>
            <div class="field-value"><input type="file" id="edit-full-photo" class="form-control"></div>
        `;
        document.getElementById('pregant-details').appendChild(fullPhotoDiv);

        document.getElementById('edit-button').style.display = 'none';
        document.getElementById('save-button').style.display = 'inline-block';
        document.getElementById('cancel-button').style.display = 'inline-block';
    }

    function cancelChanges() {
        location.reload();
    }

    function saveChanges(status) {
        const pregantId = <?php echo $pregant['id']; ?>;
        const pregantData = <?php echo json_encode($pregant); ?>;
        const existingStatus = <?php echo $pregant['status']; ?>;
        const updatedData = new FormData();

        updatedData.append('status', status);

        const fields = document.querySelectorAll('#pregant-details div[data-field]');
        fields.forEach(field => {
            const fieldName = field.getAttribute('data-field');
            if (status === existingStatus) {
                if (fieldName !== 'id') {
                    const value = document.getElementById(`edit-${fieldName}`)?.value || '';
                    updatedData.append(fieldName, value);
                } else {
                    updatedData.append(fieldName, pregantId);
                }
            } else {
                updatedData.append(fieldName, pregantData[fieldName]);
            }
        });

        if (status === existingStatus) {
            const photoFile = document.getElementById('edit-photo')?.files[0];
            if (photoFile) updatedData.append('photo', photoFile);

            const fullPhotoFile = document.getElementById('edit-full-photo')?.files[0];
            if (fullPhotoFile) updatedData.append('Full_Photo', fullPhotoFile);
        }

        fetch(commonApiPath + `pregnant.php?id=${pregantId}`, {
            method: 'PUT',
            body: updatedData,
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to update record.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>

    <div class="container">
        <?php if (!empty($_GET['status'])) {
            $status = $_GET['status'];
            echo '<br><div class="alert alert-' . ($status == 1 ? 'success' : ($status == 3 ? 'warning' : 'danger')) . '" role="alert">'
                . ($status == 1 ? 'Approved Successfully' : ($status == 3 ? 'Rejected Successfully' : 'Error! Incorrect Data Found')) .
                '</div>';
        } ?>

<style>
    #pregant-details {
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
    #pregant-photo {
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
               if ($pregant['status'] == 0) {
                echo '<div class="col-4" style="padding:40px 0%;">';
                echo '<center>';
                echo ' <button type="button" onclick="saveChanges(1)" class="btn btn-primary col-6 mt-4"><iconify-icon icon="ic:baseline-verified"></iconify-icon>Aprove</button>';
                echo '</center>';
                echo '</div>';
               }
            }
            if (!empty($_SESSION['aId']) ) {
                echo "<div class='row'>";
                if ($pregant['status'] !=2) {
                echo '<div class="col-4" >';
                echo '<center>';
                echo ' <button type="button" onclick="saveChanges(2)" class="btn btn-success col-6 mt-4"><iconify-icon icon="ic:baseline-verified"></iconify-icon>Aprove</button>';
                echo '</center>';
                echo '</div>';
                }
                if($pregant['status'] !=3){
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


<div id="pregant-details">
    <img id="pregant-photo" src="" alt="Pregnant Photo">
    <?php
    $fields = [
        "id" => "1. Application No",
        "PREGNANT_NAME" => "2. Name",
        "DATE_OF_BIRTH" => "3. Date of Birth",
        "AADHAR_CARD_NUMBER" => "4. Aadhar No",
        "EDUCATION" => "5. Education",
        "HUSBAND_NAME" => "6. Husband Name",
        "DELIVERY_DATE" => "7. Delivery Date",
        "MARRIAGE_DATE" => "8. Marriage Date",
        "NUMBER_OF_CHILDREN" => "9. No. of Children",
        "HEALTH_PROBLEMS" => "10. Health Problems",
        "PRESENT_LIVING_STATUS" => "11. Living Status",
        "Door_Number" => "12. Door No",
        "Street" => "13. Street",
        "VILLAGE_NAME" => "14. Village",
        "Mandal" => "15. Mandal",
        "City" => "16. City",
        "Pincode" => "17. Pincode",
        "District" => "18. District",
        "State" => "19. State",
        "Country" => "20. Country",
        "PHONE_NUMBER" => "21. Phone No",
        "REQUESTED_BY_NAME" => "22. Requested By (Name)",
        "REQUESTED_PHONE_NUMBER" => "23. Requested Phone No.",
        "NGO_NAME"=>"24. NGO NAME",
    ];

    foreach ($fields as $key => $label) {
        echo '<div class="field-row" data-field="' . $key . '">';
        echo '<div class="field-label">' . $label . '</div>';
        echo '<div class="field-colon">:</div>';
        echo '<div class="field-value">' . htmlspecialchars($pregant[$key]) . '</div>';
        echo '</div>';
    }

    echo '<script>';
    echo 'document.getElementById("pregant-photo").src="'
    . htmlspecialchars($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/trust/api/pregnant/' .  $pregant['photo'] , ENT_QUOTES, 'UTF-8').'"';
    echo '</script>';
    ?>
</div>

<div class="text-center mt-4 mb-5">
    <button type="button" onclick="printModal()" class="btn btn-primary col-3 mx-2">
        🖨️ Print
    </button>
    <button type="button" onclick="toggleEditMode()" id="edit-button" class="btn btn-warning col-3 mx-2">
        ✏️ Edit
    </button>
    <button type="button" onclick="saveChanges(<?php echo $pregant['status'] ?>)" id="save-button"
        class="btn btn-success col-3 mx-2" style="display: none;">
        💾 Save
    </button>
    <button type="button" onclick="cancelChanges()" id="cancel-button"
        class="btn btn-secondary col-3 mx-2" style="display: none;">
        ❌ Cancel
    </button>
</div>

<script>
function printModal() {
    const modalContent = document.getElementById('pregant-details').cloneNode(true);
    const existingImage = modalContent.querySelector('#pregant-photo');
    if (existingImage) existingImage.remove();

    const imageSrc = document.getElementById('pregant-photo')?.src || '';
     const ngo = <?php echo json_encode($pregant['NGO_NAME'] ?? ''); ?>;

    const printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Print</title>');
    printWindow.document.write(`
        <style>
            @page { size: A4; margin: 1.5cm; }
            body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
            .content { padding: 20px; }
            table { width: 100%; border-collapse: collapse; font-size: 14px; }
            td { padding: 6px; vertical-align: top; }
            .label { font-weight: bold; width: 40%; }
            .colon { width: 10px; }
            .value { width: 60%; }
            .photo-cell { text-align: center; }
            .photo-cell img {
                border: 2px solid #000; border-radius: 10px;
                height: 120px; width: 120px; object-fit: cover;
                margin-left: 10px;
            }
            .signature-section {
                margin-top: 40px;
                font-size: 14px;
            }
        </style>
    `);
    printWindow.document.write('</head><body>');
    printWindow.document.write('<div class="content border border-dark" style="border:2px solid black;">');
    printWindow.document.write('<center><h3>' + ngo + '</h3></center>');
     printWindow.document.write('<center><h4> Pregnant Application</h4></center><hr>');
    printWindow.document.write('<table>');

    const rows = modalContent.querySelectorAll('[data-field]');
    rows.forEach((row, index) => {
        const label = row.children[0]?.textContent || '';
        const value = row.children[2]?.textContent || '';
        printWindow.document.write('<tr>');
if(index<23){
        printWindow.document.write('<td class="label">' + label + '</td>');
        printWindow.document.write('<td class="colon">:</td>');
        printWindow.document.write('<td class="value">' + value + '</td>');
}
        if (index === 0) {
            printWindow.document.write('<td class="photo-cell" rowspan="4">');
            if (imageSrc) {
                printWindow.document.write('<img src="' + imageSrc + '" alt="Pregnant Photo">');
            }
            printWindow.document.write('</td>');
        }

        printWindow.document.write('</tr>');
    });

    printWindow.document.write('</table>');
    printWindow.document.write(`
        <div class="signature-section">
            <table>
                <tr><td>Date :</td><td>Place :</td></tr>
            </table>
        </div>
    `);
    printWindow.document.write('</div></body></html>');
    printWindow.document.close();

    printWindow.onload = () => {
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    };
}
</script>
</div>
</main>
