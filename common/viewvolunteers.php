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
			<h1>
				View Volunteer</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">
						View Volunteer</a>
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
				$sl_id = mysqli_query($conn, "select * from user ");
				$rowCount = mysqli_num_rows($sl_id);
				echo $rowCount;
				?>
				<p>Total volunteers</p>
			</span>
		</li>

	</ul>


	<div class="table-data ">
		<div class="container ">

			<div class="order">
				<div class="head">
					<h3>List</h3>
					<i class='bx bx-search'></i><span><input required id="searchInput" type="text"
							class="form-control"></span>
					<i class='bx bx-filter'></i>
				</div>
				<table>
					<thead>
						<tr>
							<th>User ID</th>
							<th>User Name</th>

							<th>Village</th>
							<th>Mandal</th>
							<th>Phone </th>
							<th>Edit</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (isset($_SESSION['aId'])) {
							$sl_id = mysqli_query($conn, "SELECT * FROM user");
						} else {
							$userId = $_SESSION['userId'];
							$sl_id = mysqli_query($conn, "SELECT * FROM user WHERE refer='$userId'");
						}

						while ($j = mysqli_fetch_array($sl_id)) {
							?>
							<tr>
								<td style="text-align:center;">
									<?php echo $j['id']; ?>
								</td>
								<td>
									<?php echo $j['Name_of_the_User']; ?>
								</td>
								<td>
									<?php echo $j['Village']; ?>
								</td>
								<td>
									<?php echo $j['Mandal']; ?>
								</td>
								<td>
									<?php echo $j['Phone_Number']; ?>
								</td>
								<td>
									<?php
									echo "<button type='button' onclick='window.location.href=\"user.php?id=" . $j['id'] . "\"' class='btn btn-warning'>View / Edit</button>";
									?>
								</td>
							</tr>
						<?php }
						?>
				</table>
			</div>
		</div>
	</div>

	</div>
	</div>
	</div>
</main>