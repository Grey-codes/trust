<main>
<?php
if (!empty($_GET['status'])) {
    $status = $_GET['status'];
    if ($status == 1) {
        echo '<br><div class="alert alert-success" role="alert">Approved Successfully</div>';
    } else if ($status == 3) {
        echo '<br><div class="alert alert-warning" role="alert">Rejected Successfully</div>';
    } else {
        echo '<br><div class="alert alert-danger" role="alert">Error! Incorrect Data Found</div>';
    }
}

// Summary boxes
if (isset($_SESSION['aId'])) {
    $pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM student WHERE status = 0"));
    $verified = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM student WHERE status = 1"));
    $approved = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM student WHERE status = 2"));
    $rejected = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM student WHERE status = 3"));
} else {
    $ref = $_SESSION['userId'];
    $pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM student WHERE status = 0 AND sub_refer = $ref"));
    $verified = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM student WHERE status = 1 AND sub_refer = $ref"));
    $approved = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM student WHERE status = 2 AND sub_refer = $ref"));
    $rejected = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM student WHERE status = 3 AND sub_refer = $ref"));
}
?>

<div class="head-title">
  <div class="left">
    <h1>View Child Application</h1>
    <ul class="breadcrumb">
      <li>View Application</li>
      <li><i class='bx bx-chevron-right'></i></li>
      <li><a class="active" href="#">Home</a></li>
      <li>
        <form method="post" action="../../common/studentxl.php">
          <?php
          $query = "SELECT DISTINCT Mandal FROM student WHERE Mandal IS NOT NULL AND Mandal != ''";
          $result = mysqli_query($conn, $query);
          if ($result) {
              echo '<select name="village" id="village">';
              echo '<option value="">Select Mandal</option>';
              while ($row = mysqli_fetch_assoc($result)) {
                  $village = $row['Mandal'];
                  echo "<option value=\"$village\">$village</option>";
              }
              echo '</select>';
          }
          ?>
          <input type="submit" name="export" class="btn btn-success" value="Export To Excel" />
        </form>
      </li>
    </ul>
  </div>
</div>

<ul class="box-info">
  <li><i class='bx bg-warning'><iconify-icon icon='mdi:receipt-text-pending' style='color:white'></iconify-icon></i><span class="text"><h3><?php echo $pending; ?></h3><p>Pending Applications</p></span></li>
  <li><i class='bx bg-info'><iconify-icon icon='ic:baseline-verified-user' style='color:white'></iconify-icon></i><span class="text"><h3><?php echo $verified; ?></h3><p>Verified Applications</p></span></li>
  <li><i class='bx bg-success'><iconify-icon icon='ic:baseline-verified' style='color:white'></iconify-icon></i><span class="text"><h3><?php echo $approved; ?></h3><p>Approved Applications</p></span></li>
  <li><i class='bx bg-danger'><iconify-icon icon="fluent:text-change-reject-20-filled" style="color: white"></iconify-icon></i><span class="text"><h3><?php echo $rejected; ?></h3><p>Rejected Applications</p></span></li>
</ul>

<div class="table-data">
    <div class="order">

    <div class="head mb-4 p-3 bg-light rounded shadow-sm d-flex flex-wrap justify-content-between align-items-center gap-2">
  <h3 class="mb-0">List</h3>

  <div class="d-flex flex-wrap gap-2">
    <?php if ($_SESSION['aId']) { ?>
      <form method="GET" action="" class="d-flex align-items-center gap-2">
        <input 
          id="adminSearchInput" 
          type="text" 
          class="form-control" 
          name="subsearch" 
          placeholder="Search by Admin..." 
          value="<?php echo $_GET['subsearch'] ?? ''; ?>"
        >
        <button class="btn btn-outline-primary">Admin Search</button>
      </form>
    <?php } ?>

    <form method="GET" action="" class="d-flex align-items-center gap-2">
      <input 
        id="searchInput" 
        type="text" 
        class="form-control" 
        name="search" 
        placeholder="General Search..." 
        value="<?php echo $_GET['search'] ?? ''; ?>"
      >
      <button class="btn btn-primary">Search</button>
    </form>
  </div>
</div>



<?php
$limit = 200;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$searchCondition = '';
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $searchCondition = "CONCAT_WS(' ', 
        id, time, date, refer, sub_refer, Student_Full_Name, Date_of_Birth, Class, 
        School_or_College_Name, Gender, Child_Aadhar_No, Father_Name, Mother_Name, 
        Religious, Caste_And_Sub_Caste, Favorite_Subject, Favorite_Colour, Favorite_Game, 
        Best_Friend, Hobbies, Goal, Door_Number, Street, village, Mandal, City, 
        Pincode, District, State, Country, Parent_Contact, status, photo, 
        Full_Photo, LATITUDE, LONGITUDE, NGO_NAME
    ) LIKE '%$search%'";
}
elseif(!empty($_GET['subsearch'])){
  $search = mysqli_real_escape_string($conn, $_GET['subsearch']);
    $searchCondition = "CONCAT_WS(' ',sub_refer
    ) LIKE '%$search%'";
}

$where = [];
if (!isset($_SESSION['aId'])) {
    $ref = $_SESSION['userId'];
    $where[] = "sub_refer = $ref";
}
if ($searchCondition !== '') {
    $where[] = $searchCondition;
}

$whereSql = '';
if (!empty($where)) {
    $whereSql = "WHERE " . implode(" AND ", $where);
}

$query = "SELECT * FROM student $whereSql LIMIT $offset, $limit";
$countQuery = "SELECT COUNT(*) as total FROM student $whereSql";

$sl_id = mysqli_query($conn, $query);
$totalRes = mysqli_fetch_assoc(mysqli_query($conn, $countQuery));
$totalRows = $totalRes['total'];
$totalPages = ceil($totalRows / $limit);
?>

  <div class="table-responsive">
  <table class="table table-striped table-hover table-bordered align-middle text-center">
    <thead class="table-dark align-middle text-center">
      <tr>
        <th>ID</th>
        <th>V ID</th>
        <?php if ($_SESSION['aId']) { ?><th>Admin ID</th><?php } ?>
        <th>Child Name</th>
        <th>DOB</th>
        <th>Class</th>
        <th>Mandal</th>
        <!-- <th>Phone Number</th> -->
         <th>Village</th>
        <th>Status</th>
        <th>Edit</th>
        <?php if ($_SESSION['aId']) { ?><th>Delete</th><?php } ?>
      </tr>
    </thead>
    <tbody id="studentTable">
      <?php while ($j = mysqli_fetch_array($sl_id)) { ?>
        <tr>
          <td>CH-<?php echo $j['id']; ?></td>
          <td><?php echo $j['refer']; ?></td>
          <?php if ($_SESSION['aId']) { ?>
            <td><?php echo $j['sub_refer']; ?></td>
          <?php } ?>
          <td><?php echo $j['Student_Full_Name']; ?></td>
          <td><?php echo $j['Date_of_Birth']; ?></td>
          <td><?php echo $j['Class']; ?></td>
          <td><?php echo $j['Mandal']; ?></td>
          <td><?php echo $j['village']; ?></td>
          <td>
            <?php
            switch ($j['status']) {
              case 0:
                echo '<span class="badge bg-warning text-dark"><iconify-icon icon="mdi:receipt-text-pending"></iconify-icon> Verify</span>';
                break;
              case 1:
                echo '<span class="badge bg-primary"><iconify-icon icon="ic:baseline-verified-user"></iconify-icon> Approval</span>';
                break;
              case 2:
                echo '<span class="badge bg-success"><iconify-icon icon="ic:baseline-verified"></iconify-icon> Approved</span>';
                break;
              case 3:
                echo '<span class="badge bg-danger"><iconify-icon icon="tabler:x"></iconify-icon> Rejected</span>';
                break;
            }
            ?>
          </td>
          <td>
            <a href="student-details.php?id=<?php echo $j['id']; ?>" class="btn btn-sm btn-outline-dark">Edit</a>
          </td>
          <?php if ($_SESSION['aId']) { ?>
            <td>
              <a href="../../api/delete.php?id=<?php echo $j['id']; ?>&type=1&admin=2"
                class="btn btn-sm btn-outline-danger"
                onclick="return confirm('Are you sure you want to delete this entry?');">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
</svg>
              </a>
            </td>
          <?php } ?>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>


      <!-- Pagination -->
      <div style="text-align:center; margin-top:20px;">
        <?php
        $startPage = max(1, $page - 5);
        $endPage = min($totalPages, $startPage + 9);

        $queryStr = http_build_query(array_merge($_GET, ['page' => 1]));
        if ($page > 1) {
            echo '<a href="?' . http_build_query(array_merge($_GET, ['page' => 1])) . '" class="btn btn-light mx-1">First</a>';
            echo '<a href="?' . http_build_query(array_merge($_GET, ['page' => $page - 1])) . '" class="btn btn-light mx-1">&laquo; Prev</a>';
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            echo '<a href="?' . http_build_query(array_merge($_GET, ['page' => $i])) . '" class="btn ' . ($i == $page ? 'btn-dark' : 'btn-light') . ' mx-1">' . $i . '</a>';
        }

        if ($page < $totalPages) {
            echo '<a href="?' . http_build_query(array_merge($_GET, ['page' => $page + 1])) . '" class="btn btn-light mx-1">Next &raquo;</a>';
            echo '<a href="?' . http_build_query(array_merge($_GET, ['page' => $totalPages])) . '" class="btn btn-light mx-1">Last</a>';
        }
        ?>
      </div>

    </div>
  </div>
</div>
</main>
