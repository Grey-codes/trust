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
				Create volunteer</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">
						Create volunteer</a>
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
			<i class='bx bx-group'><iconify-icon icon="clarity:users-solid"></iconify-icon></i>
			<span class="text">
				<?php
				$sl_id = mysqli_query($conn, "select * from user");
				$rowCount = mysqli_num_rows($sl_id);
				echo $rowCount;
				?>
				<p>Total Volunteers</p>
			</span>
		</li>
	</ul>


	<div class="table-data ">
		<div class="container ">
			<div class="row p-3 ">
				<div class="col-12 border p-5 rounded-5">

					<form class="row g-3" id="addUserForm" method="POST" enctype="multipart/form-data">
						<?php
						$date = date('d/m/y');
						date_default_timezone_set("Asia/Kolkata");
						date_default_timezone_get();
						$time = date('h:i:s');
						echo "<input type='hidden' name='date' value='" . $date . "'>";
						echo "<input type='hidden' name='time' value='" . $time . "'>";
						echo "<input type='hidden' name='refer' value='" . $_SESSION['userId'] . "'>";
						require '../../config.php';
						$query = "SELECT * FROM user WHERE `id` = 1";
						$result = mysqli_query($conn, $query);
						$row = mysqli_fetch_assoc($result);
						$flag = 0;
						foreach ($row as $key => $value) {
							$flag = $flag + 1;
							if ($flag > 4 && $flag < 28) {
								echo "<div class='col-md-12'>";
								echo "<label for='{$key}'>{$key} :</label>";
								echo "<input type='text' class='form-control' id='{$key}' name='{$key}' >";
								echo "</div>";
							} else if ($flag == 28) {
								echo "<div class='col-md-12'>";
								echo "<label for='{$key}'>{$key} :</label>";
								echo "<input type='file' class='form-control' id='{$key}' name='{$key}'>";
								echo "</div>";
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

					<script>
						const commonApiPath = 'http://localhost/trust/api/'
						document.getElementById('addUserForm').addEventListener('submit', function (event) {
							event.preventDefault();

							const formData = new FormData(this);

							fetch(commonApiPath+'volunteer.php', {
								method: 'POST',
								body: formData
							})
								.then(response => response.json())
								.then(data => {
									let currentUrl = window.location.href;
									let newUrl = new URL(currentUrl);

									newUrl.searchParams.set('status', data.success ? 1 : 2);

									window.location.replace(newUrl.href);
								})
								.catch(error => {
									console.error('Error:', error);
									alert('An error occurred while submitting the form.');
								});
						});
					</script>
				</div>
			</div>
		</div>
	</div>
	</div>
</main>