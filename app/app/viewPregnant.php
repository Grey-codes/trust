<?php $active = 4;
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:../index.php");
}
include '../../config.php';
?>
<!doctype html>
<html lang="en">


<!-- Mirrored from bitter.bragherstudio.com/preview2/search.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 21 Jul 2023 13:48:25 GMT -->

<head>
<?php
include 'head.php';
?>
    <script>

        $(document).ready(function () {
            $('#searchInput').on('input', function () {
                searchListItems();
            });
        });

        function searchListItems() {
            var input, filter, items, name, location, i;
            input = $('#searchInput').val().toUpperCase();
            items = $('.listItem');

            items.each(function () {
                name = $(this).find('#name span').text().toUpperCase();
                location = $(this).find('#location span').text().toUpperCase();
                id = $(this).find('#id span').text().toUpperCase();
                status = $(this).find('#status').text().toUpperCase();

                if (name.indexOf(input) > -1 || location.indexOf(input) > -1 || id.indexOf(input) > -1 || status.indexOf(input) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    </script>
</head>

<body>
<!-- 
    <div id="loading">
        <div class="spinner-grow"></div>
    </div> -->

    <div class="appHeader">
        <div class="left">
            <a href="javascript:;" class="icon goBack">
                <i class="icon ion-ios-arrow-back"></i>
            </a>
        </div>
        <div class="pageTitle">Applications</div>
        <div class="right">
        </div>
    </div>

    <div id="appCapsule">

        <div class="appContent">

            <div class="searchBlock mt-3">
                <form>
                    <span class="inputIcon">
                        <i class="icon ion-ios-search"></i>
                    </span>
                    <input type="text" class="form-control" id="searchInput" placeholder="Search...">
                </form>
            </div>


            <div class="sectionTitle mt-4 mb-0">
                <div class="text-muted">Pregnant</div>
                <div class="title">
                    <h1>Applications</h1>
                </div>
            </div>

            <div class="divider mt-1 mb-2"></div>

            <div class="row">

            </div>

            <div class="listView detailed" id="lists">
                <?php
                $userId = $_SESSION['userid'];
                $sl_id = mysqli_query($conn, "select * from pregnant where refer='$userId'");


                while ($j = mysqli_fetch_array($sl_id)) {
                    ?>
                    <a href="#" class="listItem">
                        <div class="image">
                            <img
                            src="<?php echo htmlspecialchars($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/trust/api/pregnant/' . $j['photo']); ?>"
                            alt="avatar"
                            style="border-radius:50%; height:80px; width:80px;"
                            class="avatar"
                            />
                        </div>
                        <div class="text" id="name">
                            <div>
                                Name : <span style="font-weight:500; color:black;"><?php echo $j['PREGNANT_NAME']; ?>
                                    </strong></span>
                                <div class="text-muted" style="display:flex" id="id">
                                    ID <span style="font-weight:500; color:black;">
                                        &nbsp; : &nbsp;PR-<?php echo "" . $j['id']; ?></span>
                                </div>
                                <div class="text-muted" id="location">
                                    <i class="icon ion-ios-pin me-1"></i>
                                    <span style="font-weight:500; color:black;"> <?php echo $j['Pincode']; ?></span>

                                </div>

                                <div class="text-muted" id="status">
                                    <i class=""><iconify-icon icon="majesticons:chat-status"
                                            style="font-size: 15px;"></iconify-icon></i>
                                    <?php if ($j['status'] == 0) {
                                        echo "<span class='badge  bg-warning'><iconify-icon icon='mdi:receipt-text-pending'></iconify-icon> Pending</span>";
                                    } else if ($j['status'] == 1) {
                                        echo "<span class='badge  bg-info'><iconify-icon icon='ic:baseline-verified-user'></iconify-icon></i> Verified</span>";
                                    } else if ($j['status'] == 3) {
                                        echo "<span class='badge  bg-danger'><iconify-icon icon='bx:x'></iconify-icon></i> Rejected</span>";
                                    } else {
                                        echo "<span class='badge  bg-success'><iconify-icon icon='ic:baseline-verified'></iconify-icon></i>  Aproved</span>";
                                    } ?>


                                </div>
                            </div>
                        </div>
                    </a>
                <?php } ?>

            </div>

            <?php include '../includes/appBottomMenu.php' ?>

            <!-- <script src="../assets/js/lib/bootstrap.bundle.min.js"></script>
            <script src="../assets/js/plugins/splide/splide.min.js"></script>
            <script src="../assets/js/app.js"></script> -->

</body>

</html>