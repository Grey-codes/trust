<!-- View Admin Section -->
<main class="container py-4">
  <?php if (!empty($_GET['status'])): ?>
    <div class="alert <?= $_GET['status']==1 ? 'alert-success' : 'alert-danger' ?> mt-3">
      <?= $_GET['status']==1 ? 'Edited Successfully' : 'Error! Incorrect Data Found' ?>
    </div>
  <?php endif; ?>

  <div class="head-title">
    <div class="left">
      <h1>View Admin</h1>
      <ul class="breadcrumb">
        <li><a href="#">View Admin</a></li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li><a class="active" href="#">Home</a></li>
      </ul>
    </div>
  </div>

  <ul class="box-info">
    <li>
      <i class='bx bx-list-check'><iconify-icon icon="clarity:users-solid"></iconify-icon></i>
      <span class="text">
        <h3>
          <?php
          $sl_id = mysqli_query($conn, "select * from subadmin");
          echo mysqli_num_rows($sl_id);
          ?>
        </h3>
        <p>Total Admin users</p>
      </span>
    </li>
  </ul>

  <table class="table table-bordered">
    <thead>
      <tr><th>ID</th><th>User Name</th><th>Email</th><th>Phone</th><th>Address</th><th>Edit</th></tr>
    </thead>
    <tbody>
    <?php 
      $res = mysqli_query($conn, "SELECT * FROM subadmin");
      while ($j = mysqli_fetch_assoc($res)):
    ?>
      <tr>
        <td><?= $j['id'] ?></td>
        <td><?= htmlspecialchars($j['username']) ?></td>
        <td><?= htmlspecialchars($j['email']) ?></td>
        <td><?= htmlspecialchars($j['phone']) ?></td>
        <td><?= htmlspecialchars($j['location']) ?></td>
        <td>
          <button
            type="button"
            class="btn btn-warning edit-admin"
            data-id="<?= $j['id'] ?>"
            data-username="<?= htmlspecialchars($j['username'], ENT_QUOTES) ?>"
            data-email="<?= htmlspecialchars($j['email'], ENT_QUOTES) ?>"
            data-phone="<?= htmlspecialchars($j['phone'], ENT_QUOTES) ?>"
            data-location="<?= htmlspecialchars($j['location'], ENT_QUOTES) ?>"
            data-password="<?= htmlspecialchars($j['password'], ENT_QUOTES) ?>"
            data-bs-toggle="modal"
            data-bs-target="#editAdminModal">
            <i class="bx bx-edit"></i> Edit
          </button>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</main>

<!-- Edit Modal -->
<div class="modal fade mt-5" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="margin-top: 200px">
      <form id="editAdminForm">
        <div class="modal-header">
          <h5 class="modal-title" id="editAdminLabel">Edit Admin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="admin-id" name="id">
          <div class="mb-3">
            <label>User Name</label>
            <input type="text" id="admin-username" name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" id="admin-email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Phone</label>
            <input type="text" id="admin-phone" name="phone" class="form-control">
          </div>
          <div class="mb-3">
            <label>Password</label>
            <input type="text" id="admin-password" name="password" class="form-control">
          </div>
          <div class="mb-3">
            <label>Address</label>
            <input type="text" id="admin-location" name="location" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // When Edit button is clicked
  document.querySelectorAll('.edit-admin').forEach(btn => {
    btn.addEventListener('click', () => {
      const fields = ['id', 'username', 'email', 'phone', 'password', 'location'];
      fields.forEach(field => {
        document.getElementById('admin-' + field).value = btn.dataset[field];
      });
    });
  });

  // Handle form submit
  document.getElementById('editAdminForm').addEventListener('submit', async e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const jsonData = {};
    formData.forEach((value, key) => {
      jsonData[key] = value;
    });

    const res = await fetch('/trust/api/subadmin.php', {
      method: 'PUT',
      body: JSON.stringify(jsonData),
      headers: {
        'Content-Type': 'application/json'
      }
    });

    const { status, message } = await res.json();
    if (status === 'success') {
      window.location.search = 'status=1';
    } else {
      alert('Update failed: ' + message);
    }
  });
</script>

<!-- Optional: Hide modal backdrop -->
<style>
  .modal-backdrop.show {
    opacity: 0;
  }
  .modal-backdrop {
    z-index: 0;
  }
</style>
