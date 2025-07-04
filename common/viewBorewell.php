<main>
  <?php if (!empty($_GET['status'])): ?>
    <br>
    <div class="alert alert-<?= ($_GET['status'] == 1 ? 'success' : 'danger') ?>" role="alert">
      <?= ($_GET['status'] == 1 ? 'Edited Successfully' : 'Error! Incorrect Data Found') ?>
    </div>
  <?php endif; ?>

  <div class="head-title">
    <div class="left">
      <h1>View Bore Well</h1>
      <ul class="breadcrumb">
        <li>View Borewell</li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li>
          <form method="post" action="studentxl.php" style="display:inline;">
            <input type="submit" name="export" class="btn btn-success" value="Export To Excel"/>
          </form>
        </li>
      </ul>
    </div>
  </div>

  <div class="mx-2">
    <table class="table mt-5">
      <thead class="table-dark text-center">
        <tr>
          <th>ID</th><th>Admin ID</th><th>Phone</th><th>Village</th><th>Mandal</th><th>District</th><th>State</th><th>Photos</th><th>Edit</th> <?php if(!empty($_SESSION['aId'])){ ?><th>Delete</th> <?php } ?>
        </tr>
      </thead>
      <tbody>
        <?php 
        $sql = "SELECT id, ref, Phone_Number, Village_Name, Mandal_Name, District_Name, State_Name, photos FROM borewell"; 
        $result = mysqli_query($conn, $sql);
        while($j = mysqli_fetch_array($result)) { ?>
        <tr class="text-center">
          <td><?= htmlspecialchars($j['id']) ?></td>
          <td><?= htmlspecialchars($j['ref']) ?></td>
          <td><?= htmlspecialchars($j['Phone_Number']) ?></td>
          <td><?= htmlspecialchars($j['Village_Name']) ?></td>
          <td><?= htmlspecialchars($j['Mandal_Name']) ?></td>
          <td><?= htmlspecialchars($j['District_Name']) ?></td>
          <td><?= htmlspecialchars($j['State_Name']) ?></td>
          <td>
            <button class="btn btn-primary btn-sm open-modal" data-bs-toggle="modal" data-bs-target="#photoModal" data-id="<?= $j['id'] ?>" data-photos="<?= htmlspecialchars($j['photos']) ?>">
              Photos
            </button>
          </td>
          
<td>
  <button 
    class="btn btn-warning btn-sm edit-btn" 
    data-bs-toggle="modal" 
    data-bs-target="#editModal"
    data-id="<?= $j['id'] ?>">
    Edit
  </button>
</td>



     <?php if(!empty($_SESSION['aId'])){ ?>

     <td><a href="../../api/delete.php?id=<?= $j['id'] ?>&type=7&admin=2" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a></td>
        <?php } ?>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</main>

<!-- photos Modal -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="photoModalLabel">Photos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="photo-form" action="../../api/borewell_photos.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" id="upload-id">
          <div class="row" id="photo-gallery"></div>
          <hr>
          <div class="mb-3">
            <label for="upload-photos" class="form-label">Add More Photos</label>
            <input type="file" name="photos[]" id="upload-photos" class="form-control" multiple accept="image/*">
          </div>
          <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Upload</button>
            <button type="button" id="delete-selected" class="btn btn-danger">Delete Selected</button>
          </div>
          <div class="progress mt-3" style="height: 20px; display: none;" id="progress-bar-container">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 100%;" id="progress-bar">Processing...</div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<script>
document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll('.open-modal');
  const modalTitle = document.getElementById('photoModalLabel');
  const photoGallery = document.getElementById('photo-gallery');
  const uploadIdInput = document.getElementById('upload-id');
  const progressContainer = document.getElementById('progress-bar-container');
  const photoForm = document.getElementById('photo-form');
  const deleteBtn = document.getElementById('delete-selected');

  buttons.forEach(button => {
    button.addEventListener('click', function () {
      const id = this.getAttribute('data-id');
      const photosStr = this.getAttribute('data-photos') || '';
      const photos = photosStr.split(',').map(p => p.trim()).filter(p => p !== '');
      modalTitle.textContent = `Photos - ID ${id}`;
      uploadIdInput.value = id;
      photoGallery.innerHTML = '';

      if (photos.length === 0) {
        photoGallery.innerHTML = `<p class="text-muted">No photos available.</p>`;
      } else {
        photos.forEach(photo => {
          const div = document.createElement('div');
          div.className = 'col-md-4 mb-3';
          div.innerHTML = `
            <div class="border p-2 rounded">
              <img src="/trust/api/borewell/${photo}" class="img-fluid rounded mb-2" style="max-height: 150px;">
              <div class="form-check">
                <input class="form-check-input delete-checkbox" type="checkbox" name="delete_photos[]" value="${photo}" id="chk-${photo}">
                <label class="form-check-label small" for="chk-${photo}">${photo}</label>
              </div>
            </div>`;
          photoGallery.appendChild(div);
        });
      }
    });
  });

  photoForm.addEventListener('submit', () => {
    progressContainer.style.display = 'block';
  });

  deleteBtn.addEventListener('click', function () {
    const formData = new FormData(photoForm);
    formData.append('action', 'delete');
    progressContainer.style.display = 'block';
    fetch('../../api/borewell_photos.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.text())
    .then(() => location.reload());
  });
});
</script>


<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content" style="max-height: 90vh;">
      <form id="editForm" action="../../api/borewell_edit.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Borewell Entry</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Scrollable Body with Grid -->
        <div class="modal-body overflow-auto" style="max-height: 70vh;">
          <input type="hidden" name="id" id="edit-id">
          <div class="container-fluid">
            <div class="row g-3" id="edit-form-fields">
              <!-- Input fields will be inserted here -->
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- JavaScript to Load Data -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  const editButtons = document.querySelectorAll(".edit-btn");
  const formContainer = document.getElementById("edit-form-fields");

  const fields = [
    'Village_Name', 'Mandal_Name', 'District_Name', 'State_Name', 'Type_of_drilling',
    'If_drilling_with_rig_type_of_rig', 'Drilling_depth_in_feet', 'Dimensions_of_casing',
    'Casing_thickness_in_MM', 'Casing_diameter_in_Inches', 'Depth_of_casing_in_feet',
    'Ground_water_level_in_feet', 'Type_of_hand_pump', 'Water_pipe_length', 'Number_of_Pipes_used',
    'Number_of_Rods_used', 'Number_of_Couplings_fitted', 'Depth_of_Cylinder', 'Hand_set_paint',
    'Type_of_Platfor', 'Plaque_type', 'If_special_mention_the_name', 'Latitude', 'Longitude',
    'Type_of_Soil', 'Static_water_level', 'Total_depth_of_drilling', 'Operator_Name_And_Contact_No',
    'Owner_Name_And_Contact_No', 'Vehicle_RC_No', 'House_owner_Full_Name_1', 'Contact_no_1',
    'Signature_1', 'House_owner_Full_Name_2', 'Contact_no_2', 'Signature_2', 'Final_Status',
    'NUMBER_Of_PANCHAYAT_TANKS_AVAILABLE', 'NUMBER_OF_PANCHAYAT_TAPS', 'NUMBER_OF_OPEN_GROUND_WELLS',
    'NUMBER_OF_PANCHAYAT_BORE_WELLS', 'NUMBER_OF_NGO_WELLS', 'MENTION_DETAILS', 'DATE_OF_DRILLING',
    'PRESENT_WELL_CONDITION', 'NAME_OF_NGO', 'NUMBER_OF_HOUSE_HOLDS_INTENDED_TO_BE_SERVED',
    'SELF_MADE_BORE_WELLS_DETAILS', 'Verified_By', 'Place', 'Phone_Number'
  ];

  editButtons.forEach(button => {
    button.addEventListener("click", function () {
      const id = this.dataset.id;
      formContainer.innerHTML = ''; // Clear previous content
      document.getElementById("edit-id").value = id;

      fetch("../../api/get_borewell.php?id=" + id)
        .then(response => response.json())
        .then(data => {
          fields.forEach(field => {
            const value = data[field] ? data[field].replace(/"/g, '&quot;') : '';
            const div = document.createElement('div');
            div.className = 'col-md-4';
            div.innerHTML = `
              <label for="${field}" class="form-label">${field.replace(/_/g, ' ')}</label>
              <input type="text" class="form-control" name="${field}" id="${field}" value="${value}">
            `;
            formContainer.appendChild(div);
          });
        });
    });
  });
});
</script>



<!-- Include Bootstrap CSS in <head> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Include Bootstrap JS before </body> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
