<?php
// Assuming $conn and session are already started

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

if (isset($_SESSION['aId'])) {
    $pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pregnant WHERE status = 0"));
    $verified = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pregnant WHERE status = 1"));
    $approved = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pregnant WHERE status = 2"));
    $rejected = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pregnant WHERE status = 3"));
} else {
    $ref = $_SESSION['userId'];
    $pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pregnant WHERE status = 0 AND sub_refer = $ref"));
    $verified = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pregnant WHERE status = 1 AND sub_refer = $ref"));
    $approved = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pregnant WHERE status = 2 AND sub_refer = $ref"));
    $rejected = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pregnant WHERE status = 3 AND sub_refer = $ref"));
}
?>

<div class="head-title">
  <div class="left">
    <h1>View Pregnant Applications</h1>
    <ul class="breadcrumb">
      <li>View Application</li>
      <li><i class='bx bx-chevron-right'></i></li>
      <li><a class="active" href="#">Home</a></li>
      <li>
        <form method="post" action="../../api/pregnantxl.php">
          <input type="submit" name="export" class="btn btn-success" value="Export To Excel" />
        </form>
      </li>
    </ul>
  </div>
</div>


<ul class="box-info" style="display: flex; flex-wrap: wrap; gap: 20px; padding: 0; list-style: none;">
  <li style="flex: 1; min-width: 220px; background: #fff; border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <i class='bx bg-warning d-flex align-items-center justify-content-center' style='color:white; font-size: 30px; border-radius: 50%; padding: 10px; background-color: #f0ad4e;'><iconify-icon icon='mdi:receipt-text-pending'></iconify-icon></i>
    <span class="text">
      <h3 style="margin: 0;"><?php echo $pending; ?></h3>
      <p style="margin: 0;">Pending</p>
    </span>
  </li>
  <li style="flex: 1; min-width: 220px; background: #fff; border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <i class='bx bg-info d-flex align-items-center justify-content-center' style='color:white; font-size: 30px; border-radius: 50%; padding: 10px; background-color: #17a2b8;'><iconify-icon icon='ic:baseline-verified-user'></iconify-icon></i>
    <span class="text">
      <h3 style="margin: 0;"><?php echo $verified; ?></h3>
      <p style="margin: 0;">Verified</p>
    </span>
  </li>
  <li style="flex: 1; min-width: 220px; background: #fff; border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <i class='bx bg-success d-flex align-items-center justify-content-center' style='color:white; font-size: 30px; border-radius: 50%; padding: 10px; background-color: #28a745;'><iconify-icon icon='ic:baseline-verified'></iconify-icon></i>
    <span class="text">
      <h3 style="margin: 0;"><?php echo $approved; ?></h3>
      <p style="margin: 0;">Approved</p>
    </span>
  </li>
  <li style="flex: 1; min-width: 220px; background: #fff; border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <i class='bx bg-danger d-flex align-items-center justify-content-center' style='color:white; font-size: 30px; border-radius: 50%; padding: 10px; background-color: #dc3545;'><iconify-icon icon='fluent:text-change-reject-20-filled'></iconify-icon></i>
    <span class="text">
      <h3 style="margin: 0;"><?php echo $rejected; ?></h3>
      <p style="margin: 0;">Rejected</p>
    </span>
  </li>
</ul>


<div class="table-data">
  <div class="container">
    <div class="order">
      <div class="head d-flex justify-content-between align-items-center">
        <h3>List</h3>
        <form method="GET" action="" class="d-flex">
          <input id="searchInput" type="text" class="form-control me-2" name="search" placeholder="Search..." value="<?= $_GET['search'] ?? '' ?>">
          <button class="btn btn-primary">Search</button>
        </form>
      </div>

<?php
$limit = 200;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$searchQuery = "";
if (!empty($search)) {
    $searchQuery = " AND CONCAT_WS(' ', id, time, date, refer, sub_refer, PREGNANT_NAME, DATE_OF_BIRTH, AADHAR_CARD_NUMBER, EDUCATION, HUSBAND_NAME, DELIVERY_DATE, MARRIAGE_DATE, NUMBER_OF_CHILDREN, HEALTH_PROBLEMS, PRESENT_LIVING_STATUS, Door_Number, Street, VILLAGE_NAME, Mandal, City, Pincode, District, State, Country, PHONE_NUMBER, REQUESTED_THROUGH, REQUESTED_BY_NAME, REQUESTED_PLACE, REQUESTED_PHONE_NUMBER, NGO_NAME) LIKE '%$search%'";
}

if (isset($_SESSION['aId'])) {
    $query = "SELECT * FROM pregnant WHERE 1 $searchQuery ORDER BY id DESC LIMIT $offset, $limit";
    $countQuery = "SELECT COUNT(*) as total FROM pregnant WHERE 1 $searchQuery";
} else {
    $ref = $_SESSION['userId'];
    $query = "SELECT * FROM pregnant WHERE sub_refer = $ref $searchQuery ORDER BY id DESC LIMIT $offset, $limit";
    $countQuery = "SELECT COUNT(*) as total FROM pregnant WHERE sub_refer = $ref $searchQuery";
}

$sl_id = mysqli_query($conn, $query);
$totalRes = mysqli_fetch_assoc(mysqli_query($conn, $countQuery));
$totalRows = $totalRes['total'];
$totalPages = ceil($totalRows / $limit);
?>

      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Volunteer ID</th>
            <th>Name</th>
            <th>Village</th>
            <th>Mandal</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Edit</th>
       <?php if(isset($_SESSION['aId'])){  ?>   <th>Delete</th>  <?php } ?>
          </tr>
          </tr>
        </thead>
        <tbody>
        <?php while ($j = mysqli_fetch_assoc($sl_id)) { ?>
          <tr>
            <td>PR-<?= $j['id'] ?></td>
            <td><?= $j['refer'] ?></td>
            <td><?= $j['PREGNANT_NAME'] ?></td>
            <td><?= $j['VILLAGE_NAME'] ?></td>
            <td><?= $j['Mandal'] ?></td>
            <td><?= $j['PHONE_NUMBER'] ?></td>
            <td>
              <?php
              if ($j['status'] == 0) echo '<span class="badge bg-warning">Pending</span>';
              else if ($j['status'] == 1) echo '<span class="badge bg-info">Verified</span>';
              else if ($j['status'] == 2) echo '<span class="badge bg-success">Approved</span>';
              else echo '<span class="badge bg-danger">Rejected</span>';
              ?>
            </td>
            <td><a href="pregnant-details.php?id=<?= $j['id'] ?>" class="btn btn-outline-dark btn-sm">Edit</a></td>
            <td>
              <?php if(isset($_SESSION['aId'])){ ?>
              <?php $admin = isset($_SESSION['aId']) ? 2 : 1; ?>
              <a href="../../api/delete.php?id=<?= $j['id'] ?>&type=2&admin=2" class="btn btn-outline-danger btn-sm">Delete</a>
            </td>
            <?php } ?>
          </tr>
        <?php } ?>
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="text-center mt-3">
        <?php
        $startPage = max(1, $page - 5);
        $endPage = min($totalPages, $startPage + 9);

        if ($page > 1) {
            echo '<a href="?page=1&search=' . urlencode($search) . '" class="btn btn-light">First</a>';
            echo '<a href="?page=' . ($page - 1) . '&search=' . urlencode($search) . '" class="btn btn-light">&laquo; Prev</a>';
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            echo '<a href="?page=' . $i . '&search=' . urlencode($search) . '" class="btn ' . ($i == $page ? 'btn-dark' : 'btn-light') . '">' . $i . '</a>';
        }

        if ($page < $totalPages) {
            echo '<a href="?page=' . ($page + 1) . '&search=' . urlencode($search) . '" class="btn btn-light">Next &raquo;</a>';
            echo '<a href="?page=' . $totalPages . '&search=' . urlencode($search) . '" class="btn btn-light">Last</a>';
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
  const rows = document.querySelectorAll('tbody tr');
  rows.forEach(row => {
    const name = row.cells[2]?.textContent.toLowerCase();
    if (name.includes(filter)) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
}
</script>
