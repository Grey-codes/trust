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
                max-width: 1000px;
                margin: 30px auto;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 10px;
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 14px;
            }
            td {
                padding: 6px;
                vertical-align: top;
            }
            .label { font-weight: bold; width: 30%; }
            .colon { width: 10px; }
            .value input { width: 100%; padding: 5px; font-size: 14px; }
            .photo-cell { text-align: center; vertical-align: top; }
            .photo-cell img {
                border: 2px solid #333;
                border-radius: 10px;
                height: 120px;
                width: 120px;
                object-fit: cover;
                padding: 5px;
                background-color: white;
            }
        </style>

        <div id="student-details">
            <table>
                <tbody>
                <?php
                $fields = [
                    "id" => "1. Application No",
                    "Child_Aadhar_No" => "2. Child Aadhar",
                    "Student_Full_Name" => "3. Student Full Name",
                    "Date_of_Birth" => "4. Date of Birth / Age",
                    "Class" => "5. Class",
                    "School_or_College_Name" => "6. School / College Name",
                    "Father_Name" => "7. Father Name",
                    "Mother_Name" => "8. Mother Name",
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
                ];
                $i = 0;
                foreach ($fields as $key => $label) {
                    echo '<tr data-field="' . $key . '">';
                    echo '<td class="label">' . $label . '</td>';
                    echo '<td class="colon">:</td>';
                    echo '<td class="value"><input type="text" id="edit-' . $key . '" value="' . htmlspecialchars($student[$key]) . '"></td>';
                    if ($i === 0) {
                        echo '<td class="photo-cell" rowspan="4">';
                        echo '<img id="student-photo" src="" alt="Student Photo">';
                        echo '</td>';
                    }
                    echo '</tr>';
                    $i++;
                }
                ?>
                </tbody>
            </table>
        </div>

       
            <div class="row mt-4">
                 <center>
                <button type="button" onclick="printModal()" class="col-3 btn btn-primary mx-2">Print</button>
                <!-- <button type="button" onclick="saveChanges(2)" class="btn btn-success mx-2">Approve</button>
                <button type="button" onclick="saveChanges(3)" class="btn btn-danger mx-2">Reject</button> -->
                <button type="button" onclick="saveChanges(<?php echo $student['status'] ?>)" class="col-3 btn btn-warning mx-2">Save</button>
                <button type="button" onclick="cancelChanges()" class="col-3 btn btn-secondary mx-2">Cancel</button>
                
            </center>
            </div>


        <script>
            const commonApiPath = window.location.origin + "/trust/api/";
            document.getElementById("student-photo").src = commonApiPath + "student/<?php echo $student['photo']; ?>";

            function cancelChanges() { location.reload(); }

            function saveChanges(status) {
                const studentId = <?php echo $student['id']; ?>;
                const formData = new FormData();
                formData.append('status', status);

                const fields = document.querySelectorAll('#student-details tr[data-field]');
                fields.forEach(field => {
                    const key = field.getAttribute('data-field');
                    const value = field.querySelector('input')?.value || '';
                    formData.append(key, value);
                });

                fetch(`${commonApiPath}student.php?id=${studentId}`, {
                    method: 'PUT',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) location.reload();
                    else alert("Update failed");
                })
                .catch(err => console.error(err));
            }

            function printModal() {
                const table = document.querySelector('#student-details').cloneNode(true);
                const inputs = table.querySelectorAll('input');
                inputs.forEach(input => {
                    const td = input.parentElement;
                    td.textContent = input.value;
                });
                const photo = document.getElementById('student-photo').src;
                const ngo = prompt("Enter NGO Name") || "NGO";

                const win = window.open('', '_blank');
                win.document.write('<html><head><title>Print</title><style>');
                win.document.write('@page { size: A4; margin: 1cm; } body { font-family: Arial; }');
                win.document.write('table { width: 100%; border-collapse: collapse; font-size: 14px; } td { padding: 6px; } .label { font-weight: bold; } .photo-cell img { height: 120px; width: 120px; border: 2px solid #000; border-radius: 10px; object-fit: cover; }');
                win.document.write('</style></head><body>');
                win.document.write('<h3 style="text-align:center">' + ngo + ' NGO</h3>');
                win.document.write('<table>' + table.innerHTML + '</table>');
                win.document.write('<br><div style="margin-top:40px;"><table><tr><td>Date:</td><td>Place:</td></tr><tr><td>Child Signature:</td><td>Parent/Guardian Signature:</td></tr></table></div>');
                win.document.write('</body></html>');
                win.document.close();
                win.onload = () => {
                    win.focus();
                    win.print();
                    win.close();
                };
            }
        </script>
    </div>
</main>
