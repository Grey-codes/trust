<?php

$permRaw = $_SESSION['subadmin_permission'] ?? '';
$permissions = array_filter(array_map('intval', explode(',', $permRaw)));

$act = $act ?? 0;

$sidebarItems = [
  1  => ['link' => 'profile.php',           'icon' => 'bxs-user',              'label' => 'Profile'],
  2  => ['link' => 'createuser.php',        'icon' => 'material-symbols:person-add-outline', 'label' => 'Create Volunteer'],
  3  => ['link' => 'viewuser.php',          'icon' => 'ic:outline-people',     'label' => 'View Volunteers'],
  4  => ['link' => 'viewStudent.php',       'icon' => 'bx-printer',            'label' => 'View Child Application'],
  5  => ['link' => 'viewPregnant.php',      'icon' => 'bx-printer',            'label' => 'View Pregnant Application'],
  6  => ['link' => 'viewWidow.php',         'icon' => 'bx-printer',            'label' => 'View Widow Application'],
  7  => ['link' => 'viewAged.php',          'icon' => 'bx-printer',            'label' => 'View Old Age Application'],
  8  => ['link' => 'viewVillage.php',       'icon' => 'bx-printer',            'label' => 'View Village Application'],
  9  => ['link' => 'addBorewell.php',       'icon' => 'bx-printer',            'label' => 'Add BoreWell Application'],
  10 => ['link' => 'viewBorewell.php',      'icon' => 'bx-printer',            'label' => 'View BoreWell Application'],
  11 => ['link' => 'createmedicalcamp.php', 'icon' => 'bx-printer',            'label' => 'Create Medical Camp'],
  12 => ['link' => 'viewMedicalCamp.php',   'icon' => 'bx-printer',            'label' => 'View Medical Camp'],
  13 => ['link' => 'viewActivities.php',    'icon' => 'bx-printer',            'label' => 'View Other Activities'],
];
?>

<!-- BOOTSTRAP + ICONS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

<!-- SIDEBAR START -->
<div class="d-flex flex-column bg-white vh-100" style="width: 260px; position: fixed; box-shadow: 5px 0 10px rgba(0, 0, 0, 0.1);">
  <div class="text-center py-4 border-bottom">
    <img src="../logo.png" alt="Logo" class="img-fluid" style="height: 100px;">
    <h5 class="mt-2 text-success" style="font-family: Georgia, cursive;">Dashboard</h5>
  </div>

  <div class="flex-grow-1 overflow-auto">
    <ul class="nav flex-column p-3">
      <?php foreach ($sidebarItems as $id => $item): ?>
        <?php if (in_array($id, $permissions)): ?>
          <li class="nav-item mb-1">
            <a href="<?= $item['link'] ?>" 
               class="nav-link d-flex align-items-center <?= ($act == $id) ? 'active-link' : 'link-hover' ?>" 
               style="border-radius: 10px; padding: 10px 14px;">
              <i class="bx <?= strpos($item['icon'], ':') === false ? $item['icon'] : '' ?> me-2 bx-sm text-primary">
                <?php if (strpos($item['icon'], ':') !== false): ?>
                  <iconify-icon icon="<?= $item['icon'] ?>" style="font-size: 1.2em;" class="text-primary"></iconify-icon>
                <?php endif; ?>
              </i>
              <span class="text-dark"><?= htmlspecialchars($item['label']) ?></span>
            </a>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>

      <li class="nav-item mt-3">
        <a href="../logout.php" class="nav-link d-flex align-items-center text-danger" style="border-radius: 10px; padding: 10px 14px;">
          <i class='bx bxs-log-out-circle me-2 bx-sm'></i>
          <span>Logout</span>
        </a>
      </li>
    </ul>
  </div>
</div>

<!-- STYLING -->
<style>
.link-hover:hover {
  background-color: #f0f0f0;
  color: #333;
}
.active-link {
  background-color: #e0ffe0 !important;
  color: #2ecc71 !important;
  font-weight: 600;
  border-left: 4px solid #2ecc71;
}
</style>
