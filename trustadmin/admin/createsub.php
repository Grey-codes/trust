<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['aId'])) {
	header("location:../index.php");
}
include '../../config.php';

include 'includes/head.php';
$act = 2;
?>

<body>
	<?php
	include 'includes/sidebar.php';
	?>
	<section id="content">

		<?php
		include 'includes/navbar.php';
		?>

		<main>
			<?php if (!empty($_GET['status'])) {
				$status = $_GET['status'];

				if ($status == 1) {
					?>
					<br>
					<div class="alert alert-success" role="alert">
						Submited Successfully
					</div>
					<?php
				} else {
					?>
					<br>
					<div class="alert alert-danger" role="alert">
						Error ! Incorrect Data Found
					</div>
					<?php
				}

			} ?>

			<div class="head-title">
				<div class="left">
					<h1>
						Create Admin</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">
								Create Admin
							</a>
						</li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
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
							$rowCount = mysqli_num_rows($sl_id);
							echo $rowCount;
							?>
						</h3>
						<p>Total Admin users</p>
					</span>
				</li>

			</ul>


			<div class="table-data ">
				<div class="container ">
					<div class="row p-3 ">
						<div class="col-12 border p-5 rounded-5">

							<form id="addUserForm" class="row g-3" method="POST" enctype="multipart/form-data">
								<div class="col-md-6">
									<label for="inputEmail4" class="form-label">User Name</label>
									<input required type="text" class="form-control" id="inputEmail4" name="username">
								</div>
								<div class="col-md-6">
									<label for="inputPassword4" class="form-label">Email</label>
									<input required type="text" class="form-control" id="inputPassword4" name="email">
								</div>
								<div class="col-md-6">
									<label for="inputAddress" class="form-label">Phone</label>
									<input required type="number" class="form-control" id="inputAddress" placeholder=""
										name="phone">
								</div>
								<div class="col-md-6">
									<label for="inputCity" class="form-label">Password</label>
									<input required type="password" class="form-control" id="inputCity" name="password">
								</div>
								<div class="col-md-12">
									<label for="inputCity" class="form-label">Address</label>
									<input required type="text" class="form-control" id="inputCity" name="address">
								</div>
								<div class="col-md-12">
									<label for="inputCity" class="form-label">Photo</label>
									<input required type="file" class="form-control" id="inputCity" name="photo">
								</div>
								<div class="col-6">
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
								<div class="col-6">
									<button type="reset" class="btn btn-danger">Clear</button>
								</div>
							</form>
							<script>
								const commonApiPath = window.location.origin+"/trust/api/";

								document.getElementById("addUserForm").addEventListener("submit", function (event) {
									event.preventDefault();

									const formData = new FormData(this);

									fetch(commonApiPath + 'subadmin.php', {
										method: 'POST',
										body: formData,
									})
										.then(response => response.json())
										.then(data => {
											if (data.status === 'success') {
												alert('User added successfully!');
												document.getElementById("addUserForm").reset();
											} else {
												alert('Error adding user!');
											}
										})
										.catch(error => {
											console.error('Error:', error);
											alert('An error occurred while adding the user.');
										});
								});

							</script>
						</div>
					</div>
				</div>
			</div>
			</div>
		</main>
	</section>

	<script src="script.js"></script>
</body>

</html>