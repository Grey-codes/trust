<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION['aId'])) {
	header("location:../index.php");
}
include '../../config.php';

include 'includes/head.php';
$act = 3;
?>

<body>
	<?php
	include 'includes/sidebar.php';
	?>
	<section id="content">

		<?php
		include 'includes/navbar.php';
		include '../../common/viewsubadmins.php';
		?>
	</section>

	<script src="script.js"></script>
</body>

</html>