<?php $active = 5;
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:../index.php");
}
include '../../config.php';
$id = $_SESSION['userid'];
$sl_id = mysqli_query($conn, "select * from user where id='$id' ");

while ($j = mysqli_fetch_array($sl_id)) {
    $name = $j['Name_of_the_User'];
    $phone = $j['Phone_Number'];
    $password = $j['Password'];
    $refer = $j['refer'];
    $photo = $j['photo'];
    $address = '';
}
?>
<!doctype html>
<html lang="en">

<head>
<?php
include 'head.php';
?>

<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

            width: 90%;
            max-height: 700px;
            overflow: scroll;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        .modal-button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .modal-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <script>
        function openModal() {
            document.getElementById("modal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("modal").style.display = "none";
        }

        window.onclick = function (event) {
            const modal = document.getElementById("modal");
            if (event.target === modal) {
                closeModal();
            }
        };

    </script>
    <!-- <div id="loading">
        <div class="spinner-grow"></div>
    </div> -->

    <div class="appHeader">
        <div class="left">
            <a href="#" class="icon goBack">
                <i class="icon ion-ios-arrow-back"></i>
            </a>
        </div>
        <div class="pageTitle">Profile</div>
        <div class="right">
            <a href="../logout.php"> <label class="mb-0 icon ">
                    <i class="icon ion-ios-log-out"></i>
                </label></a>
        </div>
    </div>

    <div id="searchBox">
        <form>
            <span class="inputIcon">
                <i class="icon ion-ios-search"></i>
            </span>
            <input type="text" class="form-control" id="searchInput" placeholder="Search...">
            <a href="javascript:;" class="toggleSearchbox closeButton">
                <i class="icon ion-ios-close-circle"></i>
            </a>
        </form>
    </div>

    <div id="appCapsule">

        <div class="appContent">
            <?php if (!empty($_GET['status'])) {
                $status = $_GET['status'];

                if ($status == 1) {
                    ?>
                    <br>
                    <div class="alert alert-success" role="alert">
                        Successfully Edited
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
            <div class="profileDetail mt-2">
                <div class="profileBox">
                    <div class="image">
                    <img
    src="/trust/api/userphotos/<?php echo urlencode($photo); ?>"
    alt="avatar"
    class="avatar"
/>

                    </div>
                    <div class="info">
                        <strong>
                            <?php echo $name; ?>
                        </strong>
                        <div class="text-muted">
                            <i class="icon ion-ios-pin"></i>
                            <?php echo $address; ?>
                        </div>
                    </div>
                </div>

                <div class="stats">
                    <div class="row">
                        <div class="col-6">
                            Phone<strong>
                                <?php echo $phone; ?>
                            </strong>
                        </div>
                        <div class="col-6">
                            Admin ID<strong>
                                <?php echo $refer; ?>
                            </strong>
                        </div>
                        <br>
                        <br>
                        <Center>
                    </div>
                </div>
                </Center>
                <div class="row pt-2 pb-2">
                    <div class="col" onclick="openModal()">
                        <a href="javascript:;" class="btn btn-primary btn-sm btn-block">
                            <i class="icon ion-ios-create"></i>
                            Edit
                        </a>
                    </div>

                    <div class="modal" id="modal">
                        <div class="container-fluid">
                            <div class="modal-content">
                                <div class="row">
                                    <div class="col-8">
                                        <h4>Edit</h4>
                                    </div>
                                    <div class="col-4"> <span class="close" style="color:red; float:right;"
                                            onclick="closeModal()">&times;</span>
                                    </div>
                                </div>
                                <div style="display:flex; ">



                                    <br>
                                </div>
                                <script>
                                    function validateForm() {
                                        var password = document.getElementById('exampleInputPassword1');
                                        var confirmPassword = document.getElementById('exampleInputPassword2');
                                        if (password.value.trim() === '') {
                                            password.style.border = '1px solid red';
                                            alert('Please fill in all fields.');
                                            return false;
                                        } else if (confirmPassword.value.trim() === '') {
                                            confirmPassword.style.border = '1px solid red';
                                            alert('Please fill in all fields.');
                                            return false;
                                        }
                                        else if (password?.value !== confirmPassword?.value) {
                                            password.style.border = '1px solid red';
                                            confirmPassword.style.border = '1px solid red';
                                            alert('Password does not match.');
                                            return false;
                                        }
                                        return true;
                                    }
                                </script>
                                <form id="editUserForm" onsubmit="return submitForm(event)">
                                    <div class="row g-3">
                                        <input style="display: none" class="form-control" name="id"
                                            value="<?php echo $id ?>">

                                        <div class="col-12">
                                            <label for="exampleInputPassword1"
                                                style="color:black; font-weight:600; font-size:18px;">Password</label>
                                            <input required type="password" class="form-control"
                                                id="exampleInputPassword1" value="<?php echo $password; ?>"
                                                name="password">
                                        </div>

                                        <div class="col-12">
                                            <label for="exampleInputPassword2"
                                                style="color:black; font-weight:600; font-size:18px;">Confirm
                                                Password</label>
                                            <input required type="password" class="form-control"
                                                id="exampleInputPassword2" value="<?php echo $password; ?>"
                                                name="confirmPassword">
                                        </div>

                                        <br>
                                        <div class="row">
                                            <button type="submit" class="btn btn-success col-3 m-3">Submit</button>
                                            <button type="reset" class="btn btn-danger col-3 m-3"
                                                onclick="closeModal()">Cancel</button>
                                        </div>
                                    </div>
                                </form>

                                <script>
                                    function submitForm(event) {
                                        event.preventDefault();

                                        const form = document.getElementById('editUserForm');
                                        const formData = new FormData(form);

                                        const password = formData.get('password');
                                        const confirmPassword = formData.get('confirmPassword');

                                        if (password !== confirmPassword) {
                                            alert('Passwords do not match');
                                            return false;
                                        }

                                        fetch('edituser.php', {
                                            method: 'POST',
                                            body: formData
                                        })
                                            .then(response => response.json())
                                            .then(data => {
                                                let currentUrl = window.location.href;
                                                let newUrl = new URL(currentUrl);

                                                newUrl.searchParams.set('status', data.status === 'success' ? 1 : 2);

                                                window.location.replace(newUrl.href);
                                            })
                                            .catch(error => {
                                                console.error('Error:', error);
                                                alert('Something went wrong. Please try again.');
                                            });
                                    }
                                </script>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="divider mt-2 mb-4"></div>
            <div class="sectionTitle mb-2">
                <div class="text-muted">Your</div>
                <div class="title">
                    <h1>Overview</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="iconedBox">
                        <div class="iconWrap bg-warning">
                            <i class=""><iconify-icon icon="lucide:list-x"
                                    style="font-size: 30px; color:black;"></iconify-icon></i>
                        </div>
                        <div class="col">
                            <a href="" class="btn btn-warning btn-sm btn-block">

                                Pending : 10
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="iconedBox">
                        <div class="iconWrap bg-success">
                            <i class=""><iconify-icon icon="icon-park-outline:list"
                                    style="font-size: 30px; color:black;"></iconify-icon></i>
                        </div>
                        <div class="col">
                            <a href="" class="btn btn-success btn-sm btn-block">

                                Aproved : 20
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

    <?php include '../includes/appBottomMenu.php' ?>

    <!-- <script src="../assets/js/lib/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/plugins/splide/splide.min.js"></script> -->
    <!-- <script src="../assets/js/app.js"></script> -->
<!--  -->

</body>


<!-- Mirrored from bitter.bragherstudio.com/preview2/social-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 21 Jul 2023 13:48:28 GMT -->

</html>