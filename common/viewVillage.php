<main>
<?php
if (!empty($_GET['status'])) {
    $status = $_GET['status'];
    if ($status == 1) {
        echo '<br><div class="alert alert-success" role="alert">Verified Successfully</div>';
    } else {
        echo '<br><div class="alert alert-danger" role="alert">Error ! Incorrect Data Found</div>';
    }
}

$ref = isset($_SESSION['userId'])?$_SESSION['userId']:null;
if(!empty($ref)){
$pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM village_survey WHERE status=0 AND sub_refer=$ref"));
$verified = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM village_survey WHERE status=1 AND sub_refer=$ref"));
$rejected = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM village_survey WHERE status=3 AND sub_refer=$ref"));
$approved = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM village_survey WHERE sub_refer=$ref"));
}else{
    $pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM village_survey WHERE status=0"));
$verified = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM village_survey WHERE status=1"));
$rejected = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM village_survey WHERE status=3 "));
$approved = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM village_survey"));
}

?>

<div class="head-title">
    <div class="left">
        <h1>View Village Applications</h1>
        <ul class="breadcrumb">
            <li>View Application</li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="#">Home</a></li>
            <li>
                <form method="post" action="villagexl.php">
                    <input type="submit" name="export" class="btn btn-success" value="Export To Excel" />
                </form>
            </li>
        </ul>
    </div>
</div>

<ul class="box-info">
    <li><i class='bx bg-warning'><iconify-icon icon='mdi:receipt-text-pending' style='color:white'></iconify-icon></i>
        <span class="text"><h3><?php echo $pending; ?></h3><p>Pending</p></span></li>
    <li><i class='bx bg-info'><iconify-icon icon='ic:baseline-verified-user' style='color:white'></iconify-icon></i>
        <span class="text"><h3><?php echo $verified; ?></h3><p>Verified</p></span></li>
    <li><i class='bx bg-success'><iconify-icon icon='ic:baseline-verified' style='color:white'></iconify-icon></i>
        <span class="text"><h3><?php echo $approved; ?></h3><p>Approved</p></span></li>
    <li><i class='bx bg-danger'><iconify-icon icon='fluent:text-change-reject-20-filled' style='color:white'></iconify-icon></i>
        <span class="text"><h3><?php echo $rejected; ?></h3><p>Rejected</p></span></li>
</ul>

<div class="table-data">
    <div class="container">
        <div class="order">
            <div class="head">
                <h3>List</h3>
                <i class='bx bx-search'></i>
                <input id="searchInput" type="text" class="form-control" placeholder="Search by village..." onkeyup="searchTable()">
            </div>

<?php
$limit = 200;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
if(!empty($ref)){
$query = "SELECT * FROM village_survey WHERE sub_refer = $ref ORDER BY id DESC LIMIT $offset, $limit";
$countQuery = "SELECT COUNT(*) as total FROM village_survey WHERE sub_refer = $ref";
}else{
 $query = "SELECT * FROM village_survey ORDER BY id DESC LIMIT $offset, $limit";
$countQuery = "SELECT COUNT(*) as total FROM village_survey ";   
}
$sl_id = mysqli_query($conn, $query);
$totalRes = mysqli_fetch_assoc(mysqli_query($conn, $countQuery));
$totalRows = $totalRes['total'];
$totalPages = ceil($totalRows / $limit);
?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Volunteer ID</th>
                        <th>Region</th>
                        <th>Village Name</th>
                        <th>Phone</th>
                        <th>Pincode</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <?php if($_SESSION['aId']){  ?>   <th>Delete</th>  <?php } ?>
          </tr>
                    </tr>
                </thead>
                <tbody id="studentTable">
                <?php while ($j = mysqli_fetch_array($sl_id)) { ?>
                    <tr>
                        <td style="text-align:center;">VS-<?php echo $j['id']; ?></td>
                        <td><?php echo $j['refer']; ?></td>
                        <td><?php echo $j['REGION']; ?></td>
                        <td><?php echo $j['VILLAGE_NAME']; ?></td>
                        <td><?php echo $j['REQUESTED_PHONE_NUMBER']; ?></td>
                        <td><?php echo $j['PINCODE']; ?></td>
                        <td>
                        <?php if ($j['status'] == 0) { ?>
                            <button type="button" onclick="openModal(<?php echo $j['LATITUDE']; ?>, <?php echo $j['LONGITUDE']; ?>, <?php echo $j['id']; ?>)" class="btn btn-warning">
                                <iconify-icon icon="mdi:receipt-text-pending"></iconify-icon> Verify
                            </button>
                        <?php } elseif ($j['status'] == 1) { ?>
                            <button type="button" onclick="openModal(<?php echo $j['LATITUDE']; ?>, <?php echo $j['LONGITUDE']; ?>, <?php echo $j['id']; ?>)" class="btn btn-info">
                                <iconify-icon icon="ic:baseline-verified-user"></iconify-icon> Verified
                            </button>
                        <?php } elseif ($j['status'] == 2) { ?>
                            <button type="button" onclick="openModal(<?php echo $j['LATITUDE']; ?>, <?php echo $j['LONGITUDE']; ?>, <?php echo $j['id']; ?>)" class="btn btn-success">
                                <iconify-icon icon="ic:baseline-verified"></iconify-icon> Approved
                            </button>
                        <?php } elseif ($j['status'] == 3) { ?>
                            <button type="button" onclick="openModal(<?php echo $j['LATITUDE']; ?>, <?php echo $j['LONGITUDE']; ?>, <?php echo $j['id']; ?>)" class="btn btn-danger">
                                <iconify-icon icon="tabler:x"></iconify-icon> Rejected
                            </button>
                        <?php } ?>
                        </td>
                        <td>
                            <button type="button" onclick="window.location.href='village-details.php?id=<?php echo $j['id']; ?>';" class="btn btn-outline-dark">Edit</button>
                        </td>
                        <?php if($_SESSION['aId']){  ?>
                               <td>
              <?php if (!empty($_SESSION['aId'])) { ?>
                <button type="button" onclick="window.location.href='../../api/delete.php?id=<?php echo $j['id']; ?>&type=5&admin=2';" class="btn btn-outline-danger">
                  🗑
                </button>

              <?php } else { ?>
                <button type="button" onclick="window.location.href='../../api/delete.php?id=<?php echo $j['id']; ?>&type=5&admin=1';" class="btn btn-outline-danger">
                  🗑
                </button>
              <?php } ?>
              <?php } ?>
            </td>
            <?php

} ?>
              
            </td>
            <tr>
                </tbody>
            </table>

            <!-- Pagination -->
            <div style="text-align:center; margin-top:20px;">
            <?php
            $startPage = max(1, $page - 5);
            $endPage = min($totalPages, $startPage + 9);

            if ($page > 1) {
                echo '<a href="?page=1" class="btn btn-light mx-1">First</a>';
                echo '<a href="?page=' . ($page - 1) . '" class="btn btn-light mx-1">&laquo; Prev</a>';
            }

            for ($i = $startPage; $i <= $endPage; $i++) {
                echo '<a href="?page=' . $i . '" class="btn ' . ($i == $page ? 'btn-dark' : 'btn-light') . ' mx-1">' . $i . '</a>';
            }

            if ($page < $totalPages) {
                echo '<a href="?page=' . ($page + 1) . '" class="btn btn-light mx-1">Next &raquo;</a>';
                echo '<a href="?page=' . $totalPages . '" class="btn btn-light mx-1">Last</a>';
            }
            ?>
            </div>
        </div>
    </div>
</div>

<script>
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll('#studentTable tr');
    rows.forEach(row => {
        const village = row.cells[3]?.textContent.toLowerCase();
        if (village.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
</main>
