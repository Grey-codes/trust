<?php
//export.php  
include 'config.php';
$output = '';
if (isset($_POST["export"])) {
    $query = "SELECT * FROM village_survey";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $output .= '<style>td,tr{border:solid black 1px;}</style>
   <table class="table" bordered="1">  
                    <tr>  
                    <th>Village ID</th>  
                         <th>Region</th>  
                         <th>Village Name</th>  
                         <th>Village Population</th> 
                         <th>Gram Panchayat Name</th> 
                         <th>Panchayat Population</th>  
                         <th>Mandal Name</th> 
                         <th>District Name</th> 
                         <th>State</th> 
                         <th>Number Of Temples</th> 
                         <th>Number Of Churches</th> 
                         <th>Number Of Mosques</th> 
                         <th>Village Leader Name</th> 
                         <th>Requested For </th> 
                         <th>Details For Programs</th> 
                         <th>Requested Through</th> 
                         <th>Requested By Name</th> 
                         <th>Requested Details</th> 
                         <th>Requested Phone Number</th> 
                         <th>Final Decision</th> 
                         <th>Final Decision Reason</th> 
                         <th>Status</th> 
                         <td>
                    </tr>
  ';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '
    <tr>  
                         <td>' . $row["id"] . '</td>  
                         <td>' . $row["REGION"] . '</td>  
                         <td>' . $row["VILLAGE_NAME"] . '</td>
                         <td>' . $row["VILLAGE_POPULATION"] . '</td>
                         <td>' . $row["GRAM_PANCHAYAT_NAME"] . '</td>
                         <td>' . $row["PANCHAYAT_POPULATION"] . '</td>  
                         <td>' . $row["MANDAL_NAME"] . '</td>
                         <td>' . $row["DISTRICT_NAME"] . '</td>
                         <td>' . $row["STATE"] . '</td>
                         <td>' . $row["NUMBER_OF_TEMPLE"] . '</td>
                         <td>' . $row["NUMBER_OF_CHURCHES"] . '</td>
                         <td>' . $row["NUMBER_OF_MOSQUES"] . '</td>
                         <td>' . $row["VILLAGE_LEADER_NAME"] . '</td>
                         <td>' . $row["REQUESTED_FOR"] . '</td>
                         <td>' . $row["DETAILS_FOR_PROGRAMS"] . '</td>
                         <td>' . $row["REQUESTED_THROUGH"] . '</td>
                         <td>' . $row["REQUESTED_BY_NAME"] . '</td>
                         <td>' . $row["REQUESTED_DETAILS"] . '</td>
                         <td>' . $row["REQUESTED_PHONE_NUMBER"] . '</td>
                         <td>' . $row["FINAL_DECISION"] . '</td>
                         <td>' . $row["FINAL_DECISION_REASON"] . '</td>
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