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
			<h1>View Medical Camps</h1>
			<ul class="breadcrumb">
				<li>View Application</li>
				<li><i class='bx bx-chevron-right'></i></li>
			</ul>
		</div>
	</div>

	<div class="table-data">
		<div class="container">
			<div class="order">
				<div class="head">
					<h3>List</h3>
					<i class='bx bx-search'></i>
					<span><input id="searchInput" type="text" class="form-control"></span>
					<i class='bx bx-filter'></i>
				</div>

				<?php
				// Pagination logic
				$limit = 100;
				$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
				$offset = ($page - 1) * $limit;

				$totalQuery = "SELECT COUNT(*) as total FROM medicalcamp WHERE id > 1";
				$totalResult = mysqli_fetch_assoc(mysqli_query($conn, $totalQuery));
				$totalRecords = $totalResult['total'];
				$totalPages = ceil($totalRecords / $limit);

				$sl_id = mysqli_query($conn, "SELECT * FROM medicalcamp WHERE id > 1 ORDER BY id DESC LIMIT $limit OFFSET $offset");
				?>

				<table>
					<thead>
						<tr>
							<th>Id</th>
							<th>Admin ID</th>
							<th>Campaign Place</th>
							<th>Date</th>
							<th>Village</th>
							<th>Mandal</th>
							<th>District</th>
							<th>State</th>
							<th>Edit</th>
							<?php if(!empty($_SESSION['aId'])){  ?>   <th>Delete</th>  <?php } ?>
          </tr>
						</tr>
					</thead>
					<tbody>
						<?php while ($j = mysqli_fetch_array($sl_id)) { ?>
							<tr id="row_<?php echo $j['id']; ?>">
								<td style="text-align:center;"><?php echo "MC-" . $j['id']; ?></td>
								<td><?php echo $j['ref']; ?></td>
								<td><?php echo $j['campaign_place']; ?></td>
								<td><?php echo $j['date']; ?></td>
								<td><?php echo $j['VILLAGE_NAME']; ?></td>
								<td><?php echo $j['mandal']; ?></td>
								<td><?php echo $j['district']; ?></td>
								<td><?php echo $j['state']; ?></td>
								<td>
									<button type='button' onclick='window.location.href="medical-camp-details.php?id=<?php echo $j['id']; ?>&type=1"' class='btn btn-warning'>Edit</button>
								</td>
								<td>
									<?php if (!empty($_SESSION['aId'])) { ?>
										<button type="button" onclick="window.location.href='../../api/delete.php?id=<?php echo $j['id']; ?>&type=6&admin=2';" class="btn btn-outline-danger">🗑</button>
									<?php } elseif(!empty($_SESSION['aId'])) { ?>
										<button type="button" onclick="window.location.href='../../api/delete.php?id=<?php echo $j['id']; ?>&type=6&admin=1';" class="btn btn-outline-danger">🗑</button>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>

				<!-- Pagination UI -->
				<div class="pagination d-flex justify-content-center mt-3">
					<?php if ($page > 1): ?>
						<a class="btn btn-sm btn-primary mx-1" href="?page=<?php echo $page - 1; ?>">Prev</a>
					<?php endif; ?>
					<?php for ($i = 1; $i <= $totalPages; $i++): ?>
						<a class="btn btn-sm mx-1 <?php echo ($i == $page) ? 'btn-dark' : 'btn-outline-dark'; ?>" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
					<?php endfor; ?>
					<?php if ($page < $totalPages): ?>
						<a class="btn btn-sm btn-primary mx-1" href="?page=<?php echo $page + 1; ?>">Next</a>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</div>

	<script>
		const commonApiPath = window.location.origin + "/trust/api/";
		function deleteMedicalCamp(event, id, campId) {
			event.preventDefault();
			if (confirm('Are you sure you want to delete this medical camp?')) {
				var xhr = new XMLHttpRequest();
				xhr.open("POST", commonApiPath + "deleteMedicalCamp.php", true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.onreadystatechange = function () {
					if (xhr.readyState === 4 && xhr.status === 200) {
						var row = document.getElementById("row_" + id);
						if (row) {
							row.remove();
						}
					}
				};
				xhr.send("campId=" + id);
			}
		}
	</script>
</main>
