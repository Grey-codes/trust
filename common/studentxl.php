<?php
include '../config.php';
$output = '';
session_start();
$uid = $_SESSION['userId'];

if (isset($_POST['village'])) {
    $selectedValue = $_POST['village'];
}

if (isset($_POST["export"])) {
    if (!empty($selectedValue)) {
        $query = "SELECT * FROM student WHERE sub_refer='$uid' AND Mandal = '$selectedValue'";
    } else {
        $query = "SELECT * FROM student WHERE sub_refer='$uid'";
    }

    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $output .= '<style>td, tr { border: solid black 1px; }</style>
        <table class="table" bordered="1">  
            <tr>  
                <th>Child ID</th>  
                <th>Child Name</th>  
                <th>Date_of_Birth</th>  
                <th>Class</th> 
                <th>School_or_College_Name</th> 
                <th>Gender</th>  
                <th>Child_Aadhar_No</th> 
                <th>Father_Aadhar_No</th> 
                <th>Mother_Aadhar_No</th> 
                <th>Religious</th> 
                <th>Caste_And_Sub_Caste</th> 
                <th>Favorite_Subject</th> 
                <th>Favorite_Colour</th> 
                <th>Favorite_Game</th> 
                <th>Best_Friend</th> 
                <th>Hobbies</th> 
                <th>Goal</th> 
                <th>Full_Address</th> 
                <th>Parent_Contact</th> 
                <th>Status</th> 
            </tr>';

        while ($row = mysqli_fetch_array($result)) {
            $fullAddress = $row["Door_Number"] . ", " . $row["Street"] . ", " . $row["Village"] . ", " .
                           $row["Mandal"] . ", " . $row["City"] . ", " . $row["District"] . ", " .
                           $row["State"] . " - " . $row["Pincode"] . ", " . $row["Country"];

            $statusText = match((int)$row["status"]) {
                0 => 'Pending',
                1 => 'Verified',
                2 => 'Approved',
                default => 'Rejected',
            };

            $output .= '<tr>
                <td>' . $row["id"] . '</td>  
                <td>' . $row["Student_Full_Name"] . '</td>  
                <td>' . $row["Date_of_Birth"] . '</td>
                <td>' . $row["Class"] . '</td>
                <td>' . $row["School_or_College_Name"] . '</td>
                <td>' . $row["Gender"] . '</td>  
                <td>' . $row["Child_Aadhar_No"] . '</td>
                <td>' . $row["Father_Name"] . '</td>
                <td>' . $row["Mother_Name"] . '</td>
                <td>' . $row["Religious"] . '</td>
                <td>' . $row["Caste_And_Sub_Caste"] . '</td>
                <td>' . $row["Favorite_Subject"] . '</td>
                <td>' . $row["Favorite_Colour"] . '</td>
                <td>' . $row["Favorite_Game"] . '</td>
                <td>' . $row["Best_Friend"] . '</td>
                <td>' . $row["Hobbies"] . '</td>
                <td>' . $row["Goal"] . '</td>
                <td>' . $fullAddress . '</td>
                <td>' . $row["Parent_Contact"] . '</td>
                <td>' . $statusText . '</td>
            </tr>';
        }

        $output .= '</table>';

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename=download.xls');
        echo $output;
    }
}
?>
