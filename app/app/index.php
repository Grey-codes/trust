<?php $active = 1;
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
?>>
</head>

<body>

    <!-- <div id="loading">
        <div class="spinner-grow"></div>
    </div> -->

    <?php include '../includes/appHeader.php'; ?>

    <div id="appCapsule">

        <div class="appContent">

            <div class="sectionTitle mb-2 mt-5">
                <div class="text-muted">Our</div>
                <div class="title">
                    <h1>Services</h1>
                    <a href="#">View All</a>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="iconedBox">
                        <div class="iconWrap " style=" background: #00FF00;">
                            <i class=""><iconify-icon icon="ph:student-fill"
                                    style="font-size: 30px;"></iconify-icon></i>
                        </div>
                        <h4 class="title">Child</h4>
                        Empowering children through education, fulfilling their needs with compassionate services.
                    </div>
                </div>
                <div class="col-6">
                    <div class="iconedBox">
                        <div class="iconWrap bg-danger">
                            <i class=""><iconify-icon icon="healthicons:pregnant-outline"
                                    style="font-size: 30px;"></iconify-icon></i>
                        </div>
                        <h4 class="title">Pregnant Ladies</h4>
                        Supporting pregnant women with essential services, care, and empowerment programs.
                    </div>
                </div>
                <div class="col-6">
                    <div class="iconedBox">
                        <div class="iconWrap bg-success">
                            <i class=""><iconify-icon icon="ion:woman-outline"
                                    style="font-size: 30px;"></iconify-icon></i>
                        </div>
                        <h4 class="title">Widow</h4>
                        Providing widows with comprehensive support, resources, and community empowerment initiatives.
                    </div>
                </div>
                <div class="col-6">
                    <div class="iconedBox">
                        <div class="iconWrap bg-info">
                            <i class=""><iconify-icon icon="healthicons:old-woman-outline"
                                    style="font-size: 30px;"></iconify-icon></i>
                        </div>
                        <h4 class="title">Old Age People</h4>
                        Enhancing elderly lives with tailored support, companionship, and community engagement programs.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/appBottomMenu.php' ?>

    </div>

    <!-- <script src="../assets/js/lib/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/plugins/splide/splide.min.js"></script> -->
    <!-- <script src="../assets/js/app.js"></script> -->


</body>


<!-- Mirrored from bitter.bragherstudio.com/preview2/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 21 Jul 2023 13:48:09 GMT -->

</html>