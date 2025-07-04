<?php

$medical_camp_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$medical_camp_id) {
    die("Medical Camp ID not provided.");
}

$query = "SELECT * FROM medicalcamp WHERE id = $medical_camp_id";
$result = mysqli_query($conn, $query);
$medical_camp = mysqli_fetch_assoc($result);

if (!$medical_camp) {
    die("Medical Camp not found.");
}

$records_query = "SELECT * FROM medical_camp_records WHERE medical_camp_id = $medical_camp_id";
$records_result = mysqli_query($conn, $records_query);
$records = mysqli_fetch_all($records_result, MYSQLI_ASSOC);
?>

<main>
    <div class="head-title">
        <div class="left">
            <h1>View Medical Camp</h1>
            <ul class="breadcrumb">
                <li>View Application</li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Medical Camp Details</li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="container">
            <form id="medicalCampForm">
                <input type="hidden" name="id" value="<?php echo $medical_camp['id']; ?>">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" style="width: 300px;">Campaign Place</span>
                    <input type="text" class="form-control" name="campaign_place"
                        value="<?php echo $medical_camp['campaign_place']; ?>">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" style="width: 300px;">Panchayat</span>
                    <input type="text" class="form-control" name="panchayat"
                        value="<?php echo $medical_camp['panchayat']; ?>">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" style="width: 300px;">Date</span>
                    <input type="date" class="form-control" name="date" value="<?php echo $medical_camp['date']; ?>">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" style="width: 300px;">Mandal</span>
                    <input type="text" class="form-control" name="mandal"
                        value="<?php echo $medical_camp['mandal']; ?>">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" style="width: 300px;">District</span>
                    <input type="text" class="form-control" name="district"
                        value="<?php echo $medical_camp['district']; ?>">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" style="width: 300px;">State</span>
                    <input type="text" class="form-control" name="state" value="<?php echo $medical_camp['state']; ?>">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" style="width: 300px;">Pin Code</span>
                    <input type="text" class="form-control" name="pin" value="<?php echo $medical_camp['pin']; ?>">
                </div>
                <div class="row">
                    <div class="col-6" style="padding: 30px 0%;">
                        <center>
                            <button type="submit" class="btn btn-success col-6 mt-4">Update</button>
                        </center>
                    </div>
                    <div class="col-6" style="padding: 30px 0%;">
                        <center>
                            <a href="viewmedicalcamp.php" class="btn btn-danger col-6 mt-4">Cancel</a>
                        </center>
                    </div>
                </div>
            </form>

            <div class="order">
                <h3>Medical Camp Records</h3>
                <table id="recordsTable" class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>UID/Ration Number</th>
                            <th>Age</th>
                            <th>Relation</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($records as $record): ?>
                            <tr id="record_<?php echo $record['id']; ?>">
                                <td><?php echo $record['name']; ?></td>
                                <td><?php echo $record['gender']; ?></td>
                                <td><?php echo $record['uid_or_ration_no']; ?></td>
                                <td><?php echo $record['age']; ?></td>
                                <td><?php echo $record['relation']; ?></td>
                                <td><?php echo $record['phone']; ?></td>
                                <td><?php echo $record['address']; ?></td>
                                <td>
                                    <button class="btn btn-danger"
                                        onclick="deleteRecord(<?php echo $record['id']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button class="btn btn-primary" onclick="addRecord()">+ Add Record</button>
            </div>
        </div>
    </div>
    <script>
        const commonApiPath = window.location.origin+"/trust/api/";

        document.getElementById('medicalCampForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);
            const jsonData = {};
            formData.forEach((value, key) => {
                jsonData[key] = value;
            });

            fetch(commonApiPath + 'medical-camp.php', {
                method: 'PUT',
                body: JSON.stringify(jsonData),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Medical camp details updated successfully!');
                    } else {
                        alert('Error updating medical camp details: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

        function deleteRecord(recordId) {
            if (confirm('Are you sure you want to delete this record?')) {
                fetch(commonApiPath+`medical-camp.php?id=${recordId}`, {
                    method: 'DELETE',
                    body: JSON.stringify({
                        id: recordId
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById(`record_${recordId}`).remove();
                            alert('Record deleted successfully!');
                        } else {
                            alert('Error deleting record: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        }

        function addRecord() {
            const table = document.getElementById('recordsTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            const columns = ['name', 'gender', 'uid_or_ration_no', 'age', 'relation', 'phone', 'address'];

            columns.forEach(column => {
                const cell = newRow.insertCell();
                const input = document.createElement('input');
                input.type = 'text';
                input.name = column;
                cell.appendChild(input);
            });

            const actionCell = newRow.insertCell();
            const saveButton = document.createElement('button');
            saveButton.className = 'btn btn-success';
            saveButton.textContent = 'Save';
            saveButton.onclick = function () {
                const rowData = {};
                columns.forEach(column => {
                    rowData[column] = newRow.querySelector(`input[name="${column}"]`).value;
                });

                fetch(commonApiPath+'medical-camp.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        medical_camp_id: <?php echo $medical_camp_id; ?>,
                        type: 'medical-camp-record',
                        ...rowData
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Record added successfully!');
                            window.location.reload();
                        } else {
                            alert('Error adding record: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            };
            actionCell.appendChild(saveButton);
        }
    </script>
</main>