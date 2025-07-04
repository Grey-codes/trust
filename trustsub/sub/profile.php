<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['userId'])) {
	header("location:../index.php");
}
include 'includes/head.php';
$act = 1;
include '../../config.php';
$userId = $_SESSION['userId'];
$sl_id = mysqli_query($conn, "select * from subadmin where id= $userId");


while ($j = mysqli_fetch_array($sl_id)) {
	$name = $j['username'];
	$email = $j['email'];
	$phone = $j['phone'];
	$photo = $j['photo'];
	$address = $j['location'];
	$password = $j['password'];
}
?>
<script>
	function openModal() {
		var modal = document.getElementById("modal1");
		modal.style.display = "block";
	}
	function openModal1() {
		var modal = document.getElementById("modal2");
		modal.style.display = "block";
	}
</script>

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
						Edited Successfully
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
					<h1>Profile</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Profile</a>
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
							$usercount = mysqli_query($conn, "SELECT * FROM user WHERE refer='$userId'");
							if (!$usercount) {
								die('Error: ' . mysqli_error($conn));
							}
							$rowCount = mysqli_num_rows($usercount);
							echo $rowCount;
							?>

						</h3>
						<p>Total Volunteers</p>
					</span>
				</li>

			</ul>


			<div class="table-data ">
				<div class="container text-center">
					<div class="row ">
						<div class="col-5 border m-2 p-4 rounded-5">

							<div class="row p-3  rounded-4 ">
								<div class="col-2 p-2">
									<img src="<?php echo 'http://localhost/trust/api/' . $photo; ?>" alt=""
										style="height: 70px; width: 70px; border-radius:50%">
								</div>
							</div>
							<div class="p-2 row border rounded-4 mt-2 text-start" style="font-size:14px;">
								<div class="row mt-3">
									<div class="fw-light">Your Name</div>
									<div class="fw-bold">
										<?php echo $name; ?>
									</div>
								</div>
								<div class="row mt-3">
									<div class="fw-light">Your Email</div>
									<div class="fw-bold">
										<?php echo $email; ?>
									</div>
								</div>
								<div class="row mt-3">
									<div class="fw-light">Your Phone</div>
									<div class="fw-bold">
										<?php echo $phone; ?>
									</div>
								</div>
								<div class="row mt-3">
									<div class="fw-light">Your Location</div>
									<div class="fw-bold">
										<?php echo $address; ?>
									</div>

								</div>

								<div class="modal" id="modal1">
									<div class="container-fluid">
										<div class="modal-content">
											<div class="row">
												<div class="col-8">
													<h4>Edit</h4>
												</div>
												<div class="col-4"> <span class="close" style="color:red; float:right;"
														onclick="closeModal(1)">&times;</span>
												</div>
											</div>
											<div style="display:flex; ">



												<br>
											</div>
											<form action="editsub.php" method="POST">
												<div class="row g-3">
													<?php echo $userId; ?>
													<input type="hidden" name="id" value="<?php echo $userId; ?>">
													<div class=" col-6">
														<label for="exampleInputEmail1"
															style="color:black; font-weight:600; font-size:18px; ">User
															Name</label>
														<input type="text" class="form-control" id="exampleInputEmail1"
															value="<?php echo $name; ?>" name="name">
													</div>


													<div class=" col-6">
														<label for="exampleInputPassword1"
															style="color:black; font-weight:600; font-size:18px; ">Email</label>
														<input type="email" class="form-control"
															id="exampleInputPassword1" value="<?php echo $email; ?>"
															name="email">
													</div>
													<div class=" col-6">
														<label for="exampleInputPassword1"
															style="color:black; font-weight:600; font-size:18px; ">Phone</label>
														<input type="number" class="form-control"
															id="exampleInputPassword1" value="<?php echo $phone; ?>"
															name="phone">
													</div>
													<div class=" col-6">
														<label for="exampleInputPassword1"
															style="color:black; font-weight:600; font-size:18px; ">Password</label>
														<input type="password" class="form-control"
															id="exampleInputPassword1" value="<?php echo $password; ?>"
															name="password">
													</div>
													<div class=" col-12">
														<label for="exampleInputPassword1"
															style="color:black; font-weight:600; font-size:18px; ">Address</label>
														<input type="text" class="form-control"
															id="exampleInputPassword1" value=" <?php echo $address; ?>"
															name="address">
													</div>

													<br>
													<div class="row">
														<button type="submit"
															class="btn btn-success col-3 m-3">Submit</button>
														<button type="reset"
															class="btn btn-danger col-3 m-3">Cancel</button>
													</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="modal1" id="modal2">
								<div class="container-fluid">
									<div class="modal-content">
										<div class="row">
											<div class="col-8">
												<h4>Edit</h4>
											</div>
											<div class="col-4"> <span class="close" style="color:red; float:right;"
													onclick="closeModal(2)">&times;</span>
											</div>
										</div>
										<div style="display:flex; ">



											<br>
										</div>
										<form action="editsubPhoto.php" method="POST" enctype="multipart/form-data">
											<div class="row g-3">
												<input type="hidden" name="id" value="<?php echo $userId; ?>">
												<div class=" col-6">
													<label for="exampleInputEmail1"
														style="color:black; font-weight:600; font-size:18px; ">Upload
														Profile</label>
													<input type="file" class="form-control" id="exampleInputEmail1"
														name="profile">
												</div>
												<div class="row">
													<button type="submit"
														class="btn btn-success col-3 m-3">Submit</button>
													<button type="reset"
														class="btn btn-danger col-3 m-3">Cancel</button>
												</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	</section>
	<script>
		let modal2 = document.getElementById('modal2');
		modal2.style.display = 'none';
	</script>

	<script src="script.js"></script>
</body>

</html>