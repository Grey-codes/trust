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
date_default_timezone_set("Asia/Kolkata"); 
?>

<body>
	<?php include 'includes/sidebar.php'; ?>

	<section id="content">
		<?php include 'includes/navbar.php'; ?>

		<main>
			<?php if (!empty($_GET['status'])): ?>
				<br>
				<div class="alert alert-<?= $_GET['status'] == 1 ? 'success' : 'danger' ?>" role="alert">
					<?= $_GET['status'] == 1 ? 'Submitted Successfully' : 'Error! Incorrect Data Found' ?>
				</div>
			<?php endif; ?>

			<div class="head-title">
				<div class="left">
					<h1>Create Borewell Application</h1>
					<ul class="breadcrumb">
						<li><a href="#">Create Borewell Application</a></li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li><a class="active" href="#">Home</a></li>
					</ul>
				</div>
			</div>

			<div class="table-data">
				<div class="container">
					<div class="row p-3">
						<div class="col-12 border p-5 rounded-5">
							<form class="row g-3" action="insertBorewell.php" method="POST">
								<?php
								$date = date('Y-m-d');
								$time = date('H:i:s');
								echo "<input type='hidden' name='date' value='" . htmlspecialchars($date) . "'>";
								echo "<input type='hidden' name='time' value='" . htmlspecialchars($time) . "'>";
								echo "<input type='hidden' name='ref' value='" . htmlspecialchars($_SESSION['userId']) . "'>";

								$query = "SELECT * FROM borewell WHERE id = 1 LIMIT 1";
								$result = mysqli_query($conn, $query);
								$row = mysqli_fetch_assoc($result);
								$flag = 0;

								if ($row) {
									foreach ($row as $key => $value) {
										$flag++;
										if ($flag > 4 && $flag <56) { // Skip first 4 fields (id, time, date, ref maybe)
											$escapedKey = htmlspecialchars($key);
											$escapedValue = htmlspecialchars($value);
											echo "<div class='input-group input-group-sm mb-3'>";
											echo "<span style='width:300px;' class='input-group-text'>{$escapedKey}</span>";
											echo "<input type='text' class='form-control' id='{$escapedKey}' name='{$escapedKey}' value='{$escapedValue}'>";
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
		</main>
	</section>

	<script src="script.js"></script>
</body>
</html>
