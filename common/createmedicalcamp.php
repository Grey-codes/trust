<!-- <?php session_start(); ?> -->
<main>
    <?php if (!empty($_GET['status'])): ?>
        <?php if ($_GET['status'] == 1): ?>
            <div class="alert alert-success mt-2">Submitted Successfully</div>
        <?php else: ?>
            <div class="alert alert-danger mt-2">Error! Incorrect Data Found</div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="head-title">
        <div class="left">
            <h1>Create Medical Camp</h1>
            <ul class="breadcrumb">
                <li><a href="#">Create Medical Camp</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Home</a></li>
            </ul>
        </div>
    </div>

    <ul class="box-info">
        <li>
            <img src="../images/medicalcamp.png" width="50" height="50" alt="Medical Camp Icon" />
            <span class="text">
                <h3>
                    <?php
                    // include '../config.php';
                    $sl_id = mysqli_query($conn, "SELECT * FROM medicalcamp");
                    echo mysqli_num_rows($sl_id);
                    ?>
                </h3>
                <p>Total Medical Camps</p>
            </span>
        </li>
    </ul>

    <div class="table-data">
        <div class="container">
            <div class="row p-3">
                <div class="col-12 border p-5 rounded-5">
                    <form method="POST" action="../../api/createmedical.php" class="row g-3">
                        <input type="hidden" name="ref" value="<?php echo htmlspecialchars($_SESSION['userId']); ?>">
                        <div class="col-md-6">
                            <label class="form-label">Campaign Place</label>
                            <input required type="text" class="form-control" name="campaign_place">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Panchayat</label>
                            <input required type="text" class="form-control" name="panchayat">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date</label>
                            <input required type="date" class="form-control" name="date">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Village</label>
                            <input required type="text" class="form-control" name="VILLAGE_NAME">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mandal</label>
                            <input required type="text" class="form-control" name="mandal">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">District</label>
                            <input required type="text" class="form-control" name="district">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">State</label>
                            <input required type="text" class="form-control" name="state">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pin Code</label>
                            <input required type="number" class="form-control" name="pin">
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div class="col-6">
                            <button type="reset" class="btn btn-danger">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- <script>
        const commonApiPath = window.location.origin + "/trust/api/";

        document.getElementById('medicalCampForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);
            const jsonData = {};
            formData.forEach((value, key) => {
                jsonData[key] = value;
            });
            jsonData['type'] = 'medical-camp';

            fetch(commonApiPath + '.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(jsonData),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response:', data);
                if (data.success) {
                    alert('Medical camp created successfully!');
                    window.location.href = 'createmedicalcamp.php?status=1';
                } else {
                    alert('Error: ' + data.message);
                    window.location.href = 'createmedicalcamp.php?status=0';
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                alert('An error occurred while creating the medical camp.');
            });
        });
    </script> -->
</main>
