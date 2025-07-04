<main>
	<?php if (!empty($_GET['status'])) {
		$status = $_GET['status'];

		if ($status == 1) {
			?>
			<br>
			<div class="alert alert-success" role="alert">
				Verified Successfully
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
				View Other Activities</h1>
			<li><i class='bx bx-chevron-right'></i></li>
			<ul class="breadcrumb">
				<li>
					View Other Activities</a>
				</li>

			</ul>
		</div>

	</div>




	<div class="table-data ">
		<div class="container ">

			<div class="order">
				<div class="head">
					<h3>List</h3>
					<i class='bx bx-search'></i><span><input id="searchInput" type="text" class="form-control"></span>
					<i class='bx bx-filter'></i>
				</div>
				<style>
					th {
						text-align: center;
						vertical-align: middle;
					}
				</style>
				<table>
					<thead>
						<tr>
							<th style="text-align: center;
	vertical-align: middle;">ID</th>
							<th>Volunteer Id</th>
							<th>Activity Name</th>
							<th>Date</th>
							<th>Purpose</th>
							<th>Description</th>
							<th>Address</th>
							<th>Photo</th>
							<?php if($_SESSION['aId']){  ?>   <th>Delete</th>  <?php } ?>
          </tr>

					</thead>
					<tbody>
						<?php
						if (isset($_SESSION['aId'])) {
							$sl_id = mysqli_query($conn, "select * from otheractivities");
          } else {
						$ref = $_SESSION['userId'];
						$sl_id = mysqli_query($conn, "select * from otheractivities where ref='$ref'");
		  }


						while ($j = mysqli_fetch_array($sl_id)) {
							?>
							<tr>
								<td style="text-align: center; display: table-cell; vertical-align: middle;">
									<?php echo "OA-" . $j['id']; ?>
								</td>


								<td>
									<?php echo $j['userid']; ?>
								</td>
								<td>
									<?php echo $j['Name']; ?>
								</td>
								<td>
									<?php echo $j['A_date']; ?>
								</td>
								<td>
									<?php echo $j['purpose']; ?>
								</td>
								<td>
									<?php echo $j['description']; ?>
								</td>
								<td>
									<?php echo $j['address']; ?>
								</td>
								<td>
									<button class='btn btn-warning'
										onclick=" openMedicalphotoModal(<?php echo $j['id']; ?>)">View
										Photos</button>
									<div class="modal" id="modalphoto<?php echo $j['id']; ?>">
										<div class="container-fluid">
											<div class="modal-content">
												<div class="row">
													<div class="col-8">
														<h4>Photos</h4>
													</div>
													<div class="col-4">
														<span class="close" style="color:red; float:right;"
															onclick="openMedicalphotoModalclose(<?php echo $j['id']; ?>)">&times;</span>
													</div>
												</div>
												<div style="display:flex;">
													<br>
												</div>
												<div>
													<?php
													if (isset($j['photo']) && is_array(json_decode($j['photo']))) {
														foreach (json_decode($j['photo']) as $filename) {
    														$imagePath= htmlspecialchars($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/trust/api/borewell/' .  $filename , ENT_QUOTES, 'UTF-8');
															//  = window.location.origin+"/trust/api/borewell/" . $filename;
															if (file_exists($imagePath)) {
																echo "<img src='$imagePath' alt='Borewell Image' style='width: 200px; height: 200px; margin:5px;'>";
															} else {
																echo "Image '$filename' not found.<br>";
															}
														}
													} else {
														echo "No photos found or invalid data.";
													}
													?>
												</div>
											</div>
										</div>
									</div>
									<?php if (!empty($_SESSION['aId'])) { ?>
								</td>

								<?php if (!empty($_SESSION['aId'])) { ?>
									<td>
                <button type="button" onclick="window.location.href='../../api/delete.php?id=<?php echo $j['id']; ?>&type=8&admin=2';" class="btn btn-outline-danger">
                  🗑
                </button>
			</td>
              <?php } else { ?>
                <button type="button" onclick="window.location.href='../../api/delete.php?id=<?php echo $j['id']; ?>&type=8&admin=1';" class="btn btn-outline-danger">
                  🗑
                </button>
              <?php } ?>
			   <?php } ?>

							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	</div>
	</div>
	</div>
</main>