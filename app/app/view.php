<?php $active = 4;
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:../index.php");
}
include '../../config.php';
?>
<!doctype html>
<html lang="en">

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
                name = $(this).find('#name strong').text().toUpperCase();
                location = $(this).find('#location').text().toUpperCase();
                status = $(this).find('#status').text().toUpperCase();

                if (name.indexOf(input) > -1 || location.indexOf(input) > -1 || status.indexOf(input) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    </script>
</head>

<body>

    <!-- <div id="loading">
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
            <div class="sectionTitle mt-4 mb-0">
                <div class="text-muted">View</div>
                <div class="title">
                    <h1>Applications</h1>
                </div>
            </div>

            <div class="divider mt-1 mb-2"></div>

            <div class="row">
            </div>

            <div class="row">
                <div class="col-6">
                    <a href="viewChild.php">
                        <div class="iconedBox">
                            <div class="iconWrap " style=" background: #00FF00;">
                                <i class=""><iconify-icon icon="mingcute:print-line"
                                        style="font-size: 30px;"></iconify-icon></i>
                            </div>
                            <h4 class="title"> &nbsp;View Child &nbsp;Application</h4>
                            Click on the above icon to View application.

                        </div>
                </div></a>

                <div class="col-6">
                    <a href="viewPregnant.php">
                        <div class="iconedBox">
                            <div class="iconWrap bg-warning">
                                <i class=""><iconify-icon icon="mingcute:print-line"
                                        style="font-size: 30px;"></iconify-icon></i>
                            </div>
                            <h4 class="title">View Pregnant Application</h4>
                            Click on the above icon to View application.

                        </div>
                </div></a>

                <div class="col-6">
                    <a href="viewWidow.php">
                        <div class="iconedBox">
                            <div class="iconWrap bg-success">
                                <i class=""><iconify-icon icon="mingcute:print-line"
                                        style="font-size: 30px;"></iconify-icon></i>
                            </div>
                            <h4 class="title">View Widow Application</h4>
                            Click on the above icon to View application.

                        </div>
                </div></a>

                <div class="col-6">
                    <a href="viewAged.php">
                        <div class="iconedBox">
                            <div class="iconWrap bg-info">
                                <i class=""><iconify-icon icon="mingcute:print-line"
                                        style="font-size: 30px;"></iconify-icon></i>
                            </div>
                            <h4 class="title">View Aged People Application</h4>
                            Click on the above icon to View application.

                        </div>
                </div></a>

                <div class="col-6">
                    <a href="viewVillage.php">
                        <div class="iconedBox">
                            <div class="iconWrap bg-danger">
                                <i class=""><iconify-icon icon="mingcute:print-line"
                                        style="font-size: 30px;"></iconify-icon></i>
                            </div>
                            <h4 class="title">View Village Application</h4>
                            Click on the above icon to View application.

                        </div>
                </div>

            </div>

            <?php include '../includes/appBottomMenu.php' ?>

            <!-- <script src="../assets/js/lib/bootstrap.bundle.min.js"></script>
            <script src="../assets/js/plugins/splide/splide.min.js"></script>
            <script src="../assets/js/app.js"></script> -->
</body>


<!-- Mirrored from bitter.bragherstudio.com/preview2/search.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 21 Jul 2023 13:48:25 GMT -->

</html>