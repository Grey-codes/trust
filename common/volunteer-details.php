<!DOCTYPE html>
<html lang="en">
<?php

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $query = "SELECT * FROM user WHERE id = '$userId'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "User not found!";
        exit();
    }
} else {
    echo "No user ID provided!";
    exit();
}
?>

<main>
    <?php if (!empty($_GET['status'])) {
        $status = $_GET['status'];

        if ($status == 1) {
            ?>
            <br>
            <div class="alert alert-success" role="alert">
                Edited Successfully
            </div>
            <?php
        } else {
            ?>
            <br>
            <div class="alert alert-danger" role="alert">
                Error ! Incorrect Data Found
            </div>
            <?php
        }

    } ?>
    <div class="head-title">
        <div class="left">
            <h1>
                Volunteer
            </h1>
        </div>
    </div>
    <?php
    include 'includes/navbar.php';
    ?>
    <div id="student-details">
        <?php
        $subdir = str_contains($user['photo'],'userphotos')
            ? '/trust/api/'
            : '/trust/api/userphotos/';

        // Build and escape full URL
        $photoUrl = htmlspecialchars(
            $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']
            . $subdir . $user['photo'],
            ENT_QUOTES,
            'UTF-8'
        );
        echo '<div style="position:absolute; left:80%;">'
        . '<img src="'
        . $photoUrl
        . '" style="height:100px; width:100px; border-radius:5%; padding:5px; border:2px solid black;">'
        . '</div>';

        $fields = [
            'User_ID' => '1. User_ID',
            "Name_of_the_User" => "2. Name_of_the_User",
            "Date_of_Birth" => "3. Date_of_Birth",
            "Secular_Education" => "4. Secular_Education",
            "Theology_Studies" => "5. Theology_Studies",
            "Name_of_the_Wife_or_Husband" => "6. Name_of_the_Wife_or_Husband",
            "Number_of_Kids" => "7. Number_of_Kids",
            "Personal_Testimony" => "8. Personal_Testimony",
            "Name_of_the_Church" => "9. Name_of_the_Church",
            "Church_Need" => "10. Church_Need",
            "Evangelism_Need" => "11. Evangelism_Need",
            "Village_Need" => "12. Village_Need",
            "Phone_Number" => "13. Phone_Number",
            "Password" => "14. Password",
            "Door_Number" => "15. Door_Number",
            "Street" => "16. Street",
            "Village" => "17. Village",
            "Mandal" => "18. Mandal",
            "City" => "19. City",
            "Pincode" => "20. Pincode",
            "District" => "21. District",
            "State" => "22. State",
            "Country" => "23. Country",
            "photo" => "24. photo"
        ];

        foreach ($fields as $key => $label) {
            echo '<div style="display:grid; grid-template-columns: 30% 20px 80%; margin-bottom: 20px" id="field-' . $key . '">';
            echo '<div>' . $label . '</div>';
            echo '<div>:</div>';
            echo '<div id="value-' . $key . '">' . $user[$key] . '</div>';
            echo '</div>';
        }
        ?>

        <button type="button" id="edit-button" class="btn btn-warning" onclick="editDetails()">Edit</button>

        <button type="button" id="save-btn" class="btn btn-success" style="display:none;"
            onclick="saveDetails()">Save</button>
    </div>

    <script>
        const commonApiPath = 'http://localhost/trust/api/'
        function editDetails() {
            document.getElementById('edit-button').style.display = 'none';
            document.getElementById('save-btn').style.display = 'inline-block';
            let fieldKey;
            let value;
            let input;

            <?php foreach ($fields as $key => $label): ?>
                if ('<?php echo $key; ?>' === 'photo') {
                    fieldKey = document.getElementById('field-<?php echo $key; ?>');
                    input = document.createElement('input');
                    input.type = 'file';
                    input.className = 'form-control';
                    input.id = '<?php echo $key; ?>';

                    fieldKey.innerHTML = '<div><?php echo $label; ?></div><div>:</div>';
                    fieldKey.appendChild(input);
                } else {
                    fieldKey = document.getElementById('field-<?php echo $key; ?>');
                    value = document.getElementById('value-<?php echo $key; ?>').innerText;

                    input = document.createElement('input');
                    input.style = { width: '50%' };
                    input.type = 'text';
                    input.className = 'form-control';
                    input.id = '<?php echo $key; ?>';
                    input.value = value;

                    fieldKey.innerHTML = '<div><?php echo $label; ?></div><div>:</div>';
                    fieldKey.appendChild(input);
                }
            <?php endforeach; ?>
        }

        function saveDetails() {
            let updatedData = new FormData();

            updatedData.append('id', <?php echo $user['id']; ?>);
            <?php foreach ($fields as $key => $label): ?>
                if ('<?php echo $key; ?>' === 'photo') {
                    let fileInput = document.getElementById('<?php echo $key; ?>');
                    if (fileInput.files[0]) {
                        updatedData.append('<?php echo $key; ?>', fileInput.files[0]);
                    }
                } else {
                    updatedData.append("<?php echo $key; ?>", document.getElementById('<?php echo $key; ?>').value);
                }
            <?php endforeach; ?>

            fetch(commonApiPath+'volunteer.php', {
                method: 'PUT',
                body: updatedData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload()
                    } else {
                        alert('Error updating details.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        }           
    </script>
</main>
<?php
mysqli_close($conn);
?>