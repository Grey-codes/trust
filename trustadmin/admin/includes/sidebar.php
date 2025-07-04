<!-- SIDEBAR -->
<section id="sidebar" >
	<center>
		<a href="#" class="brand" style="padding:10px; margin:30px; background-color:white">

			<img src="includes/logo.png" style="height:120px; width:180px;" alt="">
			<span class="text" style="font-size:40px; color:#2EFF2E; font-family: Georgia, cursive;"></span>

		</a>
	</center>
	<ul class="side-menu top" style="height:70%; overflow-y:scroll; padding:2px; ">
		<li <?php if ($act == 1) {
			echo "class='active'";
		} ?>>
			<a href="profile.php">
				<i class='bx bxs-user bx-sm'><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
						viewBox="0 0 24 24">
						<path fill="currentColor" fill-rule="evenodd"
							d="M8 7a4 4 0 1 1 8 0a4 4 0 0 1-8 0m0 6a5 5 0 0 0-5 5a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3a5 5 0 0 0-5-5z"
							clip-rule="evenodd" />
					</svg></i>
				<span class="text">Profile</span>
			</a>
		</li>

		<li <?php if ($act == 2) {
			echo "class='active'";
		} ?>>
			<a href="createsub.php">
				<i class='bx  bx-sm'><iconify-icon icon="material-symbols:person-add-outline"></iconify-icon></i>
				<span class="text">Create Admin</span>
			</a>
		</li>
		<li <?php if ($act == 3) {
			echo "class='active'";
		} ?>>
			<a href="viewsub.php">
				<i class='bx  bx-sm'><iconify-icon icon="ic:outline-people"></iconify-icon></i>
				<span class="text">View Admin</span>
			</a>
		</li>
		<li <?php if ($act == 4) {
			echo "class='active'";
		} ?>>
			<a href="viewuser.php">
				<i class='bx bx-list-ul bx-sm'><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
						viewBox="0 0 24 24">
						<path fill="currentColor"
							d="M18 7H6V3h12zm0 5.5q.425 0 .713-.288T19 11.5q0-.425-.288-.712T18 10.5q-.425 0-.712.288T17 11.5q0 .425.288.713T18 12.5M16 19v-4H8v4zm2 2H6v-4H2v-6q0-1.275.875-2.137T5 8h14q1.275 0 2.138.863T22 11v6h-4z" />
					</svg></i>
				<span class="text">View volunteers</span>
			</a>
		</li>
		<li <?php if ($act == 5) {
			echo "class='active'";
		} ?>>
			<a href="viewStudent.php">
				<i class='bx bx-printer bx-sm'><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
						viewBox="0 0 24 24">
						<path fill="currentColor"
							d="M18 7H6V3h12zm0 5.5q.425 0 .713-.288T19 11.5q0-.425-.288-.712T18 10.5q-.425 0-.712.288T17 11.5q0 .425.288.713T18 12.5M16 19v-4H8v4zm2 2H6v-4H2v-6q0-1.275.875-2.137T5 8h14q1.275 0 2.138.863T22 11v6h-4z" />
					</svg></i>
				<span class="text">View Child Application</span>
			</a>
		</li>
		<li <?php if ($act == 6) {
			echo "class='active'";
		} ?>>
			<a href="viewPregnant.php">
				<i class='bx bx-printer bx-sm'><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
						viewBox="0 0 24 24">
						<path fill="currentColor"
							d="M18 7H6V3h12zm0 5.5q.425 0 .713-.288T19 11.5q0-.425-.288-.712T18 10.5q-.425 0-.712.288T17 11.5q0 .425.288.713T18 12.5M16 19v-4H8v4zm2 2H6v-4H2v-6q0-1.275.875-2.137T5 8h14q1.275 0 2.138.863T22 11v6h-4z" />
					</svg></i>
				<span class="text">View Pregnant Application</span>
			</a>
		</li>
		<li <?php if ($act == 7) {
			echo "class='active'";
		} ?>>
			<a href="viewWidow.php">
				<i class='bx bx-printer bx-sm'><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
						viewBox="0 0 24 24">
						<path fill="currentColor"
							d="M18 7H6V3h12zm0 5.5q.425 0 .713-.288T19 11.5q0-.425-.288-.712T18 10.5q-.425 0-.712.288T17 11.5q0 .425.288.713T18 12.5M16 19v-4H8v4zm2 2H6v-4H2v-6q0-1.275.875-2.137T5 8h14q1.275 0 2.138.863T22 11v6h-4z" />
					</svg></i>
				<span class="text">View Widow Application</span>
			</a>
		</li>
		<li <?php if ($act == 8) {
			echo "class='active'";
		} ?>>
			<a href="viewAged.php">
				<i class='bx bx-printer bx-sm'><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
						viewBox="0 0 24 24">
						<path fill="currentColor"
							d="M18 7H6V3h12zm0 5.5q.425 0 .713-.288T19 11.5q0-.425-.288-.712T18 10.5q-.425 0-.712.288T17 11.5q0 .425.288.713T18 12.5M16 19v-4H8v4zm2 2H6v-4H2v-6q0-1.275.875-2.137T5 8h14q1.275 0 2.138.863T22 11v6h-4z" />
					</svg></i>
				<span class="text">View Old Age Application</span>
			</a>
		</li>
		<li <?php if ($act == 9) {
			echo "class='active'";
		} ?>>
			<a href="viewVillage.php">
				<i class='bx bx-printer bx-sm'><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
						viewBox="0 0 24 24">
						<path fill="currentColor"
							d="M18 7H6V3h12zm0 5.5q.425 0 .713-.288T19 11.5q0-.425-.288-.712T18 10.5q-.425 0-.712.288T17 11.5q0 .425.288.713T18 12.5M16 19v-4H8v4zm2 2H6v-4H2v-6q0-1.275.875-2.137T5 8h14q1.275 0 2.138.863T22 11v6h-4z" />
					</svg></i>
				<span class="text">View Village Application</span>
			</a>
		</li>
		<li <?php if ($act == 10) {
			echo "class='active'";
		} ?>>
			<a href="viewBorewell.php">
				<i class='bx bx-printer bx-sm'><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
						viewBox="0 0 24 24">
						<path fill="currentColor"
							d="M18 7H6V3h12zm0 5.5q.425 0 .713-.288T19 11.5q0-.425-.288-.712T18 10.5q-.425 0-.712.288T17 11.5q0 .425.288.713T18 12.5M16 19v-4H8v4zm2 2H6v-4H2v-6q0-1.275.875-2.137T5 8h14q1.275 0 2.138.863T22 11v6h-4z" />
					</svg></i>
				<span class="text">View BoreWell Application</span>
			</a>
		</li>
		<li <?php if ($act == 14) {
			echo "class='active'";
		} ?>>
			<a href="viewMedicalCamp.php">
				<i class='bx bx-printer bx-sm'><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
						viewBox="0 0 24 24">
						<path fill="currentColor"
							d="M18 7H6V3h12zm0 5.5q.425 0 .713-.288T19 11.5q0-.425-.288-.712T18 10.5q-.425 0-.712.288T17 11.5q0 .425.288.713T18 12.5M16 19v-4H8v4zm2 2H6v-4H2v-6q0-1.275.875-2.137T5 8h14q1.275 0 2.138.863T22 11v6h-4z" />
					</svg></i>
				<span class="text">View Medical Camp</span>
			</a>
		</li>
		<li <?php if ($act == 11) {
			echo "class='active'";
		} ?>>
			<a href="viewActivities.php">
				<i class='bx bx-printer bx-sm'><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
						viewBox="0 0 24 24">
						<path fill="currentColor"
							d="M18 7H6V3h12zm0 5.5q.425 0 .713-.288T19 11.5q0-.425-.288-.712T18 10.5q-.425 0-.712.288T17 11.5q0 .425.288.713T18 12.5M16 19v-4H8v4zm2 2H6v-4H2v-6q0-1.275.875-2.137T5 8h14q1.275 0 2.138.863T22 11v6h-4z" />
					</svg></i>
				<span class="text">View Other Activities</span>
			</a>
		</li>
		<li <?php if ($act == 12) {
			echo "class='active'";
		} ?>>
			<a href="map.php">
				<i class='bx bx-printer bx-sm'><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
						viewBox="0 0 24 24">
						<path fill="currentColor"
							d="M18 7H6V3h12zm0 5.5q.425 0 .713-.288T19 11.5q0-.425-.288-.712T18 10.5q-.425 0-.712.288T17 11.5q0 .425.288.713T18 12.5M16 19v-4H8v4zm2 2H6v-4H2v-6q0-1.275.875-2.137T5 8h14q1.275 0 2.138.863T22 11v6h-4z" />
					</svg></i>
				<span class="text">Map</span>
			</a>
		</li>
		<li>
			<a href="../logout.php" class="logout">
				<i class='bx bxs-log-out-circle bx-sm'><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
						viewBox="0 0 24 24">
						<path fill="currentColor" fill-rule="evenodd"
							d="M6 2a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V5a3 3 0 0 0-3-3zm10.293 5.293a1 1 0 0 1 1.414 0l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414-1.414L18.586 13H10a1 1 0 1 1 0-2h8.586l-2.293-2.293a1 1 0 0 1 0-1.414"
							clip-rule="evenodd" />
					</svg></i>
				<span class="text">Logout</span>
			</a>
		</li>
	</ul>
	<ul class="side-menu" style="bottom-margin:50px;">
	
	</ul>
</section>
<!-- SIDEBAR -->