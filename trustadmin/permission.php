 <?php
include '../config.php';
include 'permnav.php';
  ?>

<div class="mx-2">
<table class="table mt-5">
  <thead class="table-dark text-center">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">User Name</th>
      <th scope="col">Status</th>
      <th scope="col">Edit</th>
    </tr>
  </thead>


<tbody>
  <?php 
  if(!empty($_GET['adminid'])){
    $id=$_GET['adminid'];
$sql = "SELECT id, username, status, permission FROM subadmin where id=$id"; 
  }else{
    $sql = "SELECT id, username, status, permission FROM subadmin"; 
  }
$result = mysqli_query($conn, $sql);
while($j = mysqli_fetch_array($result)) { 
  $permissions = explode(',', $j['permission']);
?>
  <tr class="text-center">
    <th scope="row"><?= $j['id'] ?></th>
    <td><?= htmlspecialchars($j['username']) ?></td>
    <td>
      <div class="d-flex justify-content-center form-check form-switch">
        <input 
          class="form-check-input toggle-status" 
          type="checkbox" 
          data-id="<?= $j['id'] ?>" 
          <?= $j['status'] ? 'checked' : '' ?>
        >
      </div>
    </td>
    <td>
      <button 
        class="btn btn-warning edit-permissions-btn" 
        data-id="<?= $j['id'] ?>" 
        data-permissions='<?= json_encode($permissions) ?>'
        data-bs-toggle="modal" 
        data-bs-target="#permissionModal">
        Edit
      </button>
    </td>
</tr>
<?php } ?>

</tbody>

</table>


<!-- Permissions Modal -->
<div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="permissionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="permissionForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Permissions</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="modalUserId" name="user_id">
          <div class="row">
            
<?php
$permNames = [
  4 => 'Chlid',
  5 => 'Pregnant',
  6 => 'Widow',
  7 => 'Old Age',
  8 => 'Village',
  9 => 'Add Borewell',
  10 => 'View BoreWell',
  11 => 'Create Medical',
  12=> 'View Medical',
  13 => 'View Other',
];

foreach ($permNames as $value => $label):
?>
  <div class="col-6 mb-2">
    <div class="form-check">
      <input 
        class="form-check-input permission-checkbox" 
        type="checkbox" 
        value="<?= $value ?>" 
        id="perm<?= $value ?>" 
        name="permissions[]"
      >
      <label class="form-check-label" for="perm<?= $value ?>">
        <?= htmlspecialchars($label) ?>
      </label>
    </div>
  </div>
<?php endforeach; ?>


          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Permissions</button>
        </div>
      </div>
    </form>
  </div>
</div>



</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
  // Open modal and set checkboxes
  document.querySelectorAll('.edit-permissions-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const userId = this.dataset.id;
      const permissions = JSON.parse(this.dataset.permissions);

      document.getElementById('modalUserId').value = userId;

      document.querySelectorAll('.permission-checkbox').forEach(cb => {
        cb.checked = permissions.includes(cb.value);
      });
    });
  });

  // Handle form submit
  document.getElementById('permissionForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const userId = document.getElementById('modalUserId').value;
    const permissions = Array.from(document.querySelectorAll('.permission-checkbox'))
                             .filter(cb => cb.checked)
                             .map(cb => cb.value);

    fetch('perm_status.php', {
      method: 'PUT',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `user_id=${userId}&permissions=${permissions.join(',')}`
    })
    .then(res => res.text())
    .then(response => {
      alert('Permissions updated!');
      location.reload();
    });
  });
});
</script>


<script>

document.addEventListener('DOMContentLoaded', function () {
  const toggles = document.querySelectorAll('.toggle-status');

  toggles.forEach(toggle => {
    toggle.addEventListener('change', function () {
      const id = this.getAttribute('data-id');
      const status = this.checked ? 1 : 0;

      fetch('perm_status.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id}&status=${status}`
      })
      .then(res => res.text())
      .then(response => {
        console.log('Status updated:', response);
      })
      .catch(err => {
        console.error('Error:', err);
      });
    });
  });
});
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


  </body>
</html>