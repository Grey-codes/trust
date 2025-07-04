<?php
// Start session and DB connection assumed

if (!empty($_GET['status'])) {
  $status = $_GET['status'];
  echo '<br><div class="alert alert-' . ($status == 1 ? 'success' : 'danger') . '" role="alert">';
  if ($status == 1) echo 'Verified Successfully';
  elseif ($status == 3) echo 'Error! Aadhar No is Used. Check Aadhar Number and Retry';
  else echo 'Error! Incorrect Data Found';
  echo '</div>';
}

$ref = $_SESSION['userId'] ?? '';
$isAdmin = isset($_SESSION['aId']);

function getCount($conn, $status, $type, $isAdmin, $ref) {
  $q = $isAdmin ?
    "SELECT COUNT(*) FROM widow_aged WHERE status = $status AND app_type = $type" :
    "SELECT COUNT(*) FROM widow_aged WHERE status = $status AND app_type = $type AND sub_refer = '$ref'";
  return mysqli_fetch_array(mysqli_query($conn, $q))[0];
}

$pending = getCount($conn, 0, 1, $isAdmin, $ref);
$verified = getCount($conn, 1, 1, $isAdmin, $ref);
$approved = getCount($conn, 2, 1, $isAdmin, $ref);
$rejected = getCount($conn, 3, 1, $isAdmin, $ref);

$search = mysqli_real_escape_string($conn, $_GET['search'] ?? '');
$whereClause = $isAdmin ? "app_type=1" : "app_type=1 AND sub_refer='$ref'";

if (!empty($search)) {
  $columns = ["NAME_OF_THE_APPLICANTE", "AADHAR_CARD_NUMBER", "HUSBAND_NAME", "Village", "MANDAL_NAME", "PHONE_NUMBER", "DISTRICT_NAME", "STATE", "NGO_NAME"];
  $searchConditions = array_map(fn($col) => "$col LIKE '%$search%'", $columns);
  $whereClause .= " AND (" . implode(" OR ", $searchConditions) . ")";
}

$limit = 100;
$page = $_GET['page'] ?? 1;
$offset = ($page - 1) * $limit;

$dataQuery = "SELECT * FROM widow_aged WHERE $whereClause ORDER BY id DESC LIMIT $limit OFFSET $offset";
$totalQuery = "SELECT COUNT(*) FROM widow_aged WHERE $whereClause";
$rows = mysqli_query($conn, $dataQuery);
$totalRecords = mysqli_fetch_array(mysqli_query($conn, $totalQuery))[0];
$totalPages = ceil($totalRecords / $limit);
?>

<main>
  <div class="head-title">
    <div class="left">
      <h1>View Old Age People Applications</h1>
      <ul class="breadcrumb">
        <li>View Application</li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li><a class="active" href="#">Home</a></li>
        <li>
          <form method="post" action="../../api/agedxl.php">
            <input type="submit" name="export" class="btn btn-success" value="Export To Excel" />
          </form>
        </li>
      </ul>
    </div>
  </div>

  <ul class="box-info">
    <li><i class='bx bg-warning'><iconify-icon icon='mdi:receipt-text-pending' style='color:white'></iconify-icon></i><span class="text"><h3><?= $pending ?></h3><p>Pending</p></span></li>
    <li><i class='bx bg-info'><iconify-icon icon='ic:baseline-verified-user' style='color:white'></iconify-icon></i><span class="text"><h3><?= $verified ?></h3><p>Verified</p></span></li>
    <li><i class='bx bg-success'><iconify-icon icon='ic:baseline-verified' style='color:white'></iconify-icon></i><span class="text"><h3><?= $approved ?></h3><p>Approved</p></span></li>
    <li><i class='bx bg-danger'><iconify-icon icon='fluent:text-change-reject-20-filled' style='color:white'></iconify-icon></i><span class="text"><h3><?= $rejected ?></h3><p>Rejected</p></span></li>
  </ul>

  <div class="table-data">
    <div class="container">
      <div class="order">
        <div class="head d-flex justify-content-between align-items-center flex-wrap gap-2">
  <h3 class="mb-0">List</h3>
  <form method="GET" action="" class="d-flex align-items-center gap-2">
    <input type="text" name="search" class="form-control" placeholder="Search entire table..." value="<?= htmlspecialchars($search) ?>" style="min-width: 250px;">
    <button class="btn btn-primary">Search</button>
  </form>
</div>

        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th><th>Volunteer Id</th><th>Name</th><th>Village</th><th>Mandal</th><th>Phone</th><th>Status</th><th>Edit</th><?php if(!empty($_SESSION['aId'])){  ?>   <th>Delete</th>  <?php } ?>
          </tr>
            </tr>
          </thead>
          <tbody>
            <?php while ($j = mysqli_fetch_assoc($rows)): ?>
            <tr>
              <td>WI-<?= $j['id'] ?></td>
              <td><?= $j['refer'] ?></td>
              <td><?= $j['NAME_OF_THE_APPLICANTE'] ?></td>
              <td><?= $j['Village'] ?></td>
              <td><?= $j['MANDAL_NAME'] ?></td>
              <td><?= $j['PHONE_NUMBER'] ?></td>
              <td>
                <?php
                $statusLabels = [0 => ['warning', 'Verify'], 1 => ['info', 'Verified'], 2 => ['success', 'Approved'], 3 => ['danger', 'Rejected']];
                [$color, $label] = $statusLabels[$j['status']];
                echo "<button class='btn btn-$color'>$label</button>";
                ?>
              </td>
              <td><a href="widow-details.php?id=<?= $j['id'] ?>&type=1" class="btn btn-outline-dark">Edit</a></td>
            <?php if(!empty($_SESSION['aId'])){ ?>
              <td>
                <a href="../../api/delete.php?id=<?= $j['id'] ?>&type=4&admin=<?= $isAdmin ? 2 : 1 ?>" class="btn btn-outline-danger">🗑</a>
              </td>

            <?php } ?>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>

        <div class="pagination d-flex justify-content-center mt-3">
          <?php if ($page > 1): ?><a class="btn btn-sm btn-primary mx-1" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">Prev</a><?php endif; ?>
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a class="btn btn-sm mx-1 <?= $i == $page ? 'btn-dark' : 'btn-outline-dark' ?>" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
          <?php endfor; ?>
          <?php if ($page < $totalPages): ?><a class="btn btn-sm btn-primary mx-1" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">Next</a><?php endif; ?>
        </div>

      </div>
    </div>
  </div>
</main>
