<?php
//export.php  
include 'config.php';
$output = '';
if (isset($_POST["export"])) {
    $query = "SELECT * FROM widow_aged where app_type=0";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $output .= '<style>td,tr{border:solid black 1px;}</style>
        <table class="table" bordered="1">  
        <tr>  
                        <th>Widow Id</th>
                        <th>Widow Name</th>
                        <th>Date Of Birth</th>
                        <th>Aadhar Card Number</th>
                        <th>Husband Name</th>
                        <th>Marriage Date</th>
                        <th>Number Of Children</th>
                        <th>Husband Passed Year</th>
                        <th>Cause Of Death</th>
                        <th>Recieving Pension</th>
                        <th>Health Problems</th>
                        <th>Present Living Status</th>
                        <th>Village Name</th>
                        <th>Street Name</th>
                        <th>Mandal Name</th>
                        <th>District Name</th>
                        <th>State</th>
                        <th>Pincode</th>
                        <th>Phone Number</th>
                        <th>Requested Through</th>
                        <th>Requested By Name</th>
                        <th>Requested Place</th>
                        <th>Requested Phone Number</th>
                         <th>Status</th> 
                         <td>
                    </tr>
  ';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '
    <tr>  
                         <td>' . $row["id"] . '</td>
                         <td>' . $row["NAME_OF_THE_APPLICANTE"] . '</td>
                         <td>' . $row["DATE_OF_BIRTH"] . '</td>
                         <td>' . $row["AADHAR_CARD_NUMBER"] . '</td>
                         <td>' . $row["HUSBAND_NAME"] . '</td>
                         <td>' . $row["MARRIAGE_DATE"] . '</td>
                         <td>' . $row["NUMBER_OF_CHILDREN"] . '</td>
                         <td>' . $row["HUSBAND_PASSED_YEAR"] . '</td>
                        <td>' . $row["CAUSE_OF_DEATH"] . '</td>
                        <td>' . $row["RECEVING_PENSION"] . '</td>
                        <td>' . $row["HEALTH_PROBLEMS"] . '</td>
                        <td>' . $row["PRESENT_LIVING_STATUS"] . '</td>
                        <td>' . $row["VILLAGE_NAME"] . '</td>
                        <td>' . $row["STREET_NAME"] . '</td>
                        <td>' . $row["MANDAL_NAME"] . '</td>
                        <td>' . $row["DISTRICT_NAME"] . '</td>
                        <td>' . $row["STATE"] . '</td>
                        <td>' . $row["PINCODE"] . '</td>
                        <td>' . $row["PHONE_NUMBER"] . '</td>
                        <td>' . $row["REQUESTED_THROUGH"] . '</td>
                        <td>' . $row["REQUESTED_BY_NAME"] . '</td>
                        <td>' . $row["REQUESTED_PLACE"] . '</td>
                        <td>' . $row["REQUESTED_PHONE_NUMBER"] . '</td>
                    <td>';

            if ($row["status"] == 0) {
                $output .= 'Pending</td>';
            } else if ($row["status"] == 1) {
                $output .= 'Verified</td>';
            } else if ($row["status"] == 2) {
                $output .= 'Aproved</td>';
            } else {
                $output .= 'Rejected</td>';
            }


        }
        $output .= '</tr></table>';
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename=download.xls');
        echo $output;
    }
}
?>