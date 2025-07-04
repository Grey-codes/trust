<?php
// session_start();
include '../../config.php';

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
    $pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM widow_aged WHERE status = 0 AND app_type = 0"));
    $verified = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM widow_aged WHERE status = 1 AND app_type = 0"));
    $approved = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM widow_aged WHERE status = 2 AND app_type = 0"));
    $rejected = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM widow_aged WHERE status = 3 AND app_type = 0"));
} else {
    $ref = $_SESSION['userId'];
    $pending = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM widow_aged WHERE status = 0 AND sub_refer = $ref AND app_type = 0"));
    $verified = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM widow_aged WHERE status = 1 AND sub_refer = $ref AND app_type = 0"));
    $approved = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM widow_aged WHERE status = 2 AND sub_refer = $ref AND app_type = 0"));
    $rejected = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM widow_aged WHERE status = 3 AND sub_refer = $ref AND app_type = 0"));
}
?>

<div class="head-title">
  <div class="left">
    <h1>View Widow Applications</h1>
    <ul class="breadcrumb">
      <li>View Application</li>
      <li><i class='bx bx-chevron-right mx-4'></i></li>
      <li>
        <form method="post" action="../../api/widowxl.php">
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


  <div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Application List</h5>
      <form method="GET" action="" class="d-flex">
        <input type="text" name="search" id="searchInput" class="form-control me-2" placeholder="Search..." value="<?php echo $_GET['search'] ?? ''; ?>">
        <button class="btn btn-primary">Search</button>
      </form>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped mb-0">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Volunteer ID</th>
              <th>Name</th>
              <th>Village</th>
              <th>Mandal</th>
              <th>Phone</th>
              <th>Status</th>
              <th>Edit</th>
              <?php if($_SESSION['aId']){  ?>   <th>Delete</th>  <?php } ?>
          </tr>
            </tr>
          </thead>
          <tbody id="studentTable">
<?php
$limit = 200;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search = $_GET['search'] ?? '';

$where = "WHERE app_type = 0";
if (!empty($search)) {
  $search = mysqli_real_escape_string($conn, $search);
  $where .= " AND (NAME_OF_THE_APPLICANTE LIKE '%$search%' OR AADHAR_CARD_NUMBER LIKE '%$search%' OR PHONE_NUMBER LIKE '%$search%' OR refer LIKE '%$search%')";
}

if (!isset($_SESSION['aId'])) {
  $ref = $_SESSION['userId'];
  $where .= " AND sub_refer = $ref";
}

$query = "SELECT * FROM widow_aged $where ORDER BY id DESC LIMIT $offset, $limit";
$countQuery = "SELECT COUNT(*) as total FROM widow_aged $where";

$sl_id = mysqli_query($conn, $query);
$totalRes = mysqli_fetch_assoc(mysqli_query($conn, $countQuery));
$totalRows = $totalRes['total'];
$totalPages = ceil($totalRows / $limit);

while ($j = mysqli_fetch_array($sl_id)) {
?>
<tr>
  <td>WI-<?php echo $j['id']; ?></td>
  <td><?php echo $j['refer']; ?></td>
  <td><?php echo $j['NAME_OF_THE_APPLICANTE']; ?></td>
  <td><?php echo $j['Village']; ?></td>
  <td><?php echo $j['MANDAL_NAME']; ?></td>
  <td><?php echo $j['PHONE_NUMBER']; ?></td>
  <td>
    <?php if ($j['status'] == 0): ?>
      <span class="badge bg-warning">Pending</span>
    <?php elseif ($j['status'] == 1): ?>
      <span class="badge bg-info">Verified</span>
    <?php elseif ($j['status'] == 2): ?>
      <span class="badge bg-success">Approved</span>
    <?php else: ?>
      <span class="badge bg-danger">Rejected</span>
    <?php endif; ?>
  </td>
  <td><a href="widow-details.php?id=<?php echo $j['id']; ?>&type=0" class="btn btn-outline-dark btn-sm">Edit</a></td>
  <?php if($_SESSION['aId']){ ?>
  <td><a href="../../api/delete.php?id=<?php echo $j['id']; ?>&type=3&admin=<?php echo isset($_SESSION['aId']) ? '2' : '1'; ?>" class="btn btn-outline-danger btn-sm">🗑</a></td>
<?php } ?>
</tr>
<?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="text-center my-3">
<?php
$startPage = max(1, $page - 5);
$endPage = min($totalPages, $startPage + 9);

if ($page > 1) {
  echo '<a href="?page=1&search=' . $search . '" class="btn btn-light mx-1">First</a>';
  echo '<a href="?page=' . ($page - 1) . '&search=' . $search . '" class="btn btn-light mx-1">&laquo; Prev</a>';
}

for ($i = $startPage; $i <= $endPage; $i++) {
  echo '<a href="?page=' . $i . '&search=' . $search . '" class="btn ' . ($i == $page ? 'btn-dark' : 'btn-light') . ' mx-1">' . $i . '</a>';
}

if ($page < $totalPages) {
  echo '<a href="?page=' . ($page + 1) . '&search=' . $search . '" class="btn btn-light mx-1">Next &raquo;</a>';
  echo '<a href="?page=' . $totalPages . '&search=' . $search . '" class="btn btn-light mx-1">Last</a>';
}
?>
  </div>
</div>