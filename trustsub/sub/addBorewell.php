<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['userId'])) {
	header("location:../index.php");
}
include 'includes/head.php';
include '../../config.php';
$act = 9;
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
						Create Borewell Application</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">
								Create Borewell Application</a>
						</li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>

			</div>


			<div class="table-data ">
				<div class="container ">
					<div class="row p-3 ">
						<div class="col-12 border p-5 rounded-5">

							<form class="row g-3 " action="insertBorewell.php" method="POST">
								<?php
								$date = date('d/m/y');
								date_default_timezone_set("Asia/Kolkata");

								date_default_timezone_get();
								$time = date('h:i:s');
								echo "<input type='hidden' name='date' value='" . $date . "'>";
								echo "<input type='hidden' name='time' value='" . $time . "'>";
								echo "<input type='hidden' name='ref' value='" . $_SESSION['userId'] . "'>";
								require '../../config.php';
								$query = "SELECT * FROM borewell WHERE id =1";
								$result = mysqli_query($conn, $query);
								$row = mysqli_fetch_assoc($result);
								$flag = 0;
								if ($row) {
									foreach ($row as $key => $value) {
										$flag = $flag + 1;
										if ($flag > 4) {
											echo "<div class='input-group input-group-sm mb-3'>";
											echo " <span style='width:300px;' class='input-group-text' id='inputGroup-sizing-sm'>{$key} </span> ";
											echo "<input type='text'   class='form-control' id='{$key}' name='{$key}' value='' >";
											echo "</div>";
										}
									}
								}


								mysqli_close($conn);
								?>

								<div class="col-6">
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
								<div class="col-6">
									<button type="reset" class="btn btn-danger">Clear</button>
								</div>
							</form>
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