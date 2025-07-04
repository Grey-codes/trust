<?php $active = 2;
session_start();
if (!isset($_SESSION['userid'])) {
  header("location:../index.php");
}
include '../../config.php';
?>
<!doctype html>
<html lang="en">


<!-- Mirrored from bitter.bragherstudio.com/preview2/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 21 Jul 2023 13:47:48 GMT -->

<head>
<?php
include 'head.php';
?>
  <script>
    function getLocation() {
      // Check if Geolocation is supported by the browser
      if (navigator.geolocation) {
        // Request the user's location
        navigator.geolocation.getCurrentPosition(
          // Success callback z
          function (position) {
            // Extract latitude and longitude
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            // Display the coordinates
            var latitudeElements = document.getElementsByClassName("latitude");
            for (var i = 0; i < latitudeElements.length; i++) {
              latitudeElements[i].value = latitude;
            }
            var longitudeElements = document.getElementsByClassName("longitude");
            for (var j = 0; j < longitudeElements.length; j++) {
              longitudeElements[j].value = longitude;
            }

            // Set the value of an input element with the id "longitudeInput"
            document.getElementById("longitudeInput").value = longitude;

            // Clear status message
            document.getElementById("statusMessage").innerHTML = "";
          },
          // Error callback
          function (error) {
            // Handle errors (e.g., user denied access)
            console.error("Error getting location:", error);

            // Display error message
            var longitudeElements = document.getElementsByClassName("statusMessage");
            for (var j = 0; j < longitudeElements.length; j++) {
              longitudeElements[j].innerHTML = "Please Enable Location Services";
            }

            // If permission is denied, suggest enabling it

          }
        );
      } else {
        // Geolocation is not supported
        console.error("Geolocation is not supported by this browser.");

        // Display error message
        document.getElementById("statusMessage").innerHTML = "Geolocation is not supported by this browser.";
      }
    }

    // Call the function to get the location
  </script>
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
      max-height: 550px;
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

    #latitude,
    #longitude {
      display: none;
    }
  </style>
  <script>

    function openModal(a) {
      document.getElementById("modal" + a).style.display = "block";
      getLocation();
    }

    function closeModal(a) {
      document.getElementById("modal" + a).style.display = "none";
    }

    // Close the modal if the user clicks outside the modal content
    window.onclick = function (event) {
      const modal = document.getElementById("modal");
      if (event.target === modal) {
        closeModal();
      }
    };

  </script>

  <script>
    function preventSubmission(event) {
      event.preventDefault();
    }
  </script>
  <script>
    function validateDate() {
      var dobInput = document.getElementById('dob');
      var errorMessage = document.getElementById('error-message');

      // Check if a date is selected
      if (!dobInput.value) {
        errorMessage.textContent = 'Please enter your Date of Birth.';
        return;
      }

      // Get the entered date
      var dob = new Date(dobInput.value);

      // Get the current date
      var currentDate = new Date();

      // Calculate the minimum allowed date (50 years ago)
      var minDate = new Date();
      minDate.setFullYear(currentDate.getFullYear() - 50);

      // Compare the entered date with the minimum allowed date
      if (dob < minDate) {
        errorMessage.textContent = ''; // Clear previous error message
        // You can proceed with further actions here
      } else {
        errorMessage.textContent = 'You must be at least 50 years old.';
      }
    }
  </script>
  <script>
    function validateDate1() {
      var dobInput = document.getElementById('dob1');
      var errorMessage = document.getElementById('error-message1');

      // Check if a date is selected
      if (!dobInput.value) {
        errorMessage.textContent = 'Please enter your Date of Birth.';
        return;
      }

      // Get the entered date
      var dob = new Date(dobInput.value);

      // Get the current date
      var currentDate = new Date();

      // Calculate the minimum allowed date (50 years ago)
      var minDate = new Date();
      minDate.setFullYear(currentDate.getFullYear() - 10);

      // Compare the entered date with the minimum allowed date
      if (dob < minDate) {
        errorMessage.textContent = ''; // Clear previous error message
        // You can proceed with further actions here
      } else {
        errorMessage.textContent = 'You must be at least 10 years old.';
      }
    }
  </script>

</head>

<body>

  <!-- Page loading -->
  <!-- <div id="loading">
    <div class="spinner-grow"></div>
  </div> -->

  <?php include '../includes/appHeader.php'; ?>

  <div id="appCapsule">

    <div class="appContent">

      <?php if (!empty($_GET['status'])) {
        $status = $_GET['status'];

        if ($status == 1) {
          ?>
          <br>
          <div class="alert alert-success" role="alert">
            Submited Successfully,<br> Request Will Be Verified Soon
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

      <div class="sectionTitle mb-2 mt-4">
        <div class="text-muted">Create</div>
        <div class="title">
          <h1>Application </h1>
        </div>
      </div>

      <div class="row">
        <div class="col-6">
          <div class="iconedBox">
            <div class="iconWrap " style=" background: #00FF00;" onclick="openModal(1)">
              <i class=""><iconify-icon icon="ph:student-fill" style="font-size: 30px;"></iconify-icon></i>
            </div>
            <h4 class="title"> &nbsp;New Child &nbsp;Application</h4>
            Click on the above icon to Create application.

          </div>
        </div>

        <div class="col-6">
          <div class="iconedBox">
            <div class="iconWrap bg-warning" onclick="openModal(2)">
              <i class=""><iconify-icon icon="healthicons:pregnant-outline" style="font-size: 30px;"></iconify-icon></i>
            </div>
            <h4 class="title">New Pregnant Application</h4>
            Click on the above icon to Create application.
          </div>
        </div>

        <div class="col-6">
          <div class="iconedBox">
            <div class="iconWrap bg-success" onclick="openModal(3)">
              <i class=""><iconify-icon icon="ion:woman-outline" style="font-size: 30px;"></iconify-icon></i>
            </div>
            <h4 class="title">New Widow Application</h4>
            Click on the above icon to Create application.
          </div>
        </div>

        <div class="col-6">
          <div class="iconedBox">
            <div class="iconWrap bg-info" onclick="openModal(4)">
              <i class=""><iconify-icon icon="healthicons:old-woman-outline"
                  style="font-size: 30px;"></iconify-icon></i>
            </div>
            <h4 class="title">New Aged People Application</h4>
            Click on the above icon to Create application.
          </div>
        </div>

        <div class="col-6">
          <div class="iconedBox">
            <div class="iconWrap bg-danger" onclick="openModal(5)">
              <i class=""><svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1em" viewBox="0 0 36 24">
                  <path fill="currentColor"
                    d="M20.912 18.228h2.091v2.091h-2.091zm7.228 0h2.091v2.091H28.14zm-1.754-7.416v-2.09h-2.898V9.74l1.081 1.073z" />
                  <path fill="currentColor"
                    d="M33.552 22.112v-4.409h.665l.618-.611l-7.322-7.322h-.909v1.269h-2.13L23.205 9.77h-3.516l-7.314 7.314l.618.618h.979v4.409h-1.911C9.203 19.377 8.443 13.176 8.71 8.563l.047-.094h.023c1.25 0 2.358.606 3.048 1.54l.007.01c.52.703.833 1.588.833 2.545c0 .66-.148 1.285-.414 1.844l.011-.026a3.842 3.842 0 0 0 1.518-.78l-.006.005a4.254 4.254 0 0 0 1.461-3.213c0-.955-.314-1.836-.844-2.546l.008.011A3.71 3.71 0 0 0 10.28 6.48l.026-.007c.265-.165.57-.311.891-.422l.032-.01a3.891 3.891 0 0 1 1.363-.241c1.083 0 2.064.433 2.781 1.134l-.001-.001a3.516 3.516 0 0 0-.093-1.685l.007.025a3.786 3.786 0 0 0-4.991-2.293l.025-.009a5.067 5.067 0 0 0-.702.303l.029-.014a4.551 4.551 0 0 0-.301-.909l.012.029C8.478.407 6.46-.525 4.847.29a2.989 2.989 0 0 0-1.09.95l-.006.01A3.664 3.664 0 0 1 6.53 3.003l.009.016a5.048 5.048 0 0 0-1.179-.417l-.034-.006C2.846 2.063.486 3.41.063 5.611a3.74 3.74 0 0 0 .109 1.812l-.007-.026a4.553 4.553 0 0 1 4.543-1.402l-.032-.007c.409.086.771.21 1.11.373l-.029-.013a4.114 4.114 0 0 0-4.117 2.04l-.011.02a4.59 4.59 0 0 0-.643 2.357c0 1.568.777 2.954 1.968 3.794l.015.01a4.028 4.028 0 0 0 1.709.648l.021.002a4.665 4.665 0 0 1-.671-2.423c0-.873.237-1.691.651-2.392l-.012.022a4.204 4.204 0 0 1 2.927-2.048l.025-.004c-1.417 6.453-1.809 10.949-.64 13.736H3.573v1.88h32.148v-1.88h-2.169zm-7.95-4.307h7.166v4.307h-7.166zm-10.861-.854l4.95-4.95l4.95 4.95v5.161h-5.435v-3.884h-2.749v3.884h-1.722v-5.161z" />
                </svg></i>
            </div>
            <h4 class="title">New Village Application</h4>
            Click on the above icon to Create application.
          </div>
        </div>
        <div class="col-6">
          <div class="iconedBox">
            <div class="iconWrap bg-secondary" onclick="openModal(6)">
              <i class=""><iconify-icon icon="ci:list-add" style="font-size: 30px;"></iconify-icon></i>
            </div>
            <h4 class="title">Other Activities</h4>
            Click on the above icon to Create application.
          </div>
        </div>

        <div class="modal" id="modal1">
          <div class="container-fluid">
            <div class="modal-content">
              <div class="row">
                <div class="col-8">
                  <h4>Fill The Child Details</h4>
                </div>
                <div class="col-4"> <span class="close" style="color:red; float:right;"
                    onclick="closeModal(1)">&times;</span>
                </div>
              </div>
              <div style="display:flex; ">
                <br>
              </div>

              <form id="myForm" enctype="multipart/form-data">
                <input type="text" id="latitude" name="latitude" class="latitude" required>
                <input type="text" id="longitude" name="longitude" class="longitude" required>
                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Name Of The
                    Child</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name" name="name"
                    required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Date Of
                    Birth</label>
                  <input type="date" id="dob1" class="form-control" placeholder="Enter Date Of Birth" name="dob"
                    required onchange="validateDate1()">
                  <p id="error-message1" style="color: red;"></p>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Class</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Class" name="class"
                    required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Parent Contact
                    Number (optional)</label>
                  <input type="number" max="9999999999" class="form-control" id="exampleInputEmail1"
                    placeholder="Enter Parent contact Number" name="number">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Location</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Location"
                    name="address">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Photo</label>
                  <input type="file" id="fileInput" class="form-control" name="photo" onchange="validateFileSize()"
                    required>
                  <p id="fileSizeError" style="color: red;"></p>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Full
                    Photo</label>
                  <input type="file" id="fileInput" class="form-control" name="full_photo" onchange="validateFileSize()"
                    required>
                  <p id="fileSizeError" style="color: red;"></p>
                </div>

                <div class="form-check">
                  <input type="checkbox" checked class="form-check-input" id="exampleCheck1">
                  <label class="form-check-label" for="exampleCheck1">I Agree With T&C</label>
                </div>
                <br>
                <p id="statusMessage" style="color:red;" class="statusMessage"></p>
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="reset" class="btn btn-danger">Cancel</button>
              </form>

              <script>
                const commonApiPath = window.location.origin+"/trust/api/";
                document.getElementById('myForm').addEventListener('submit', function (event) {
                  event.preventDefault();

                  if (validateForm()) {
                    var formData = new FormData(document.getElementById('myForm'));

                    fetch(commonApiPath + 'student.php', {
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
                        alert('An error occurred.');
                      });
                  } else {
                    alert('Please fix the errors in the form.');
                  }
                });

                function validateForm() {
                  if (!document.querySelector('[name="name"]').value || !document.querySelector('[name="dob"]').value) {
                    alert('Please fill in all required fields.');
                    return false;
                  }
                  return true;
                }

                function validateFileSize() {
                  const fileInput = document.getElementById('fileInput');
                  const file = fileInput.files[0];
                  const maxSize = 5 * 1024 * 1024;
                  if (file && file.size > maxSize) {
                    document.getElementById('fileSizeError').innerText = 'File size exceeds 5MB';
                  } else {
                    document.getElementById('fileSizeError').innerText = '';
                  }
                }
              </script>
            </div>
          </div>
        </div>

        <div class="modal" id="modal2">
          <div class="container-fluid">
            <div class="modal-content">
              <div class="row">
                <div class="col-8">
                  <h4>Fill The Pregnant Details</h4>
                </div>
                <div class="col-4"> <span class="close" style="color:red; float:right;"
                    onclick="closeModal(2)">&times;</span>
                </div>
              </div>
              <div style="display:flex; ">
                <br>
              </div>
              <form id="pregnantform" enctype="multipart/form-data">
                <input type="text" id="latitude" name="latitude" class="latitude" required>
                <input type="text" id="longitude" name="longitude" class="longitude" required>
                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Name Of The
                    Pregnant</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name" name="name"
                    required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Date Of
                    Birth</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" placeholder="Enter Date Of Birth"
                    name="dob" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Number Of
                    Months</label>
                  <input type="number" max="12" class="form-control" id="exampleInputEmail1"
                    placeholder="Enter Present Month Ex 0-9" name="month" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Husband
                    Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Husband Name"
                    name="husband" required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Contact Number
                    (optional)</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Contact Number"
                    name="number">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Delivery
                    Date</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" placeholder="Enter Delivery Date"
                    name="ddate" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Location</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Location"
                    name="address" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Photo</label>
                  <input type="file" id="fileInput" class="form-control" name="photo" required>
                  <p id="fileSizeError" style="color: red;"></p>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Full
                    Photo</label>
                  <input type="file" id="fileInput" class="form-control" name="full_photo" required>
                  <p id="fileSizeError" style="color: red;"></p>
                </div>
                <div class="form-check">
                  <input type="checkbox" checked class="form-check-input" id="exampleCheck1">
                  <label class="form-check-label" for="exampleCheck1">I Agree With T&C</label>
                </div>
                <br>
                <p id="statusMessage" style="color:red;" class="statusMessage"></p>
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="reset" class="btn btn-danger">Cancel</button>
              </form>

              <script>
                document.getElementById("pregnantform").addEventListener("submit", function (event) {
                  event.preventDefault();

                  if (validateForm()) {
                    var formData = new FormData(this);

                    fetch(commonApiPath + 'pregnant.php', {
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
                        alert('An error occurred.');
                      });
                  } else {
                    alert('Please fix the errors in the form.');
                  }
                });

                function validateForm() {
                  return true;
                }
              </script>

            </div>
          </div>
        </div>

        <div class="modal" id="modal3">
          <div class="container-fluid">
            <div class="modal-content">
              <div class="row">
                <div class="col-8">
                  <h4>Fill The widow Details</h4>
                </div>
                <div class="col-4"> <span class="close" style="color:red; float:right;"
                    onclick="closeModal(3)">&times;</span>
                </div>
              </div>
              <div style="display:flex; ">
                <br>
              </div>
              <form id="windowform" enctype="multipart/form-data">
                <input type="text" id="latitude" name="latitude" class="latitude" required>
                <input type="text" id="longitude" name="longitude" class="longitude" required>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px; ">Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name" name="name"
                    required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px; ">Date Of
                    Birth</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" placeholder="Enter Date Of Birth"
                    name="dob" required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px; ">Husband
                    Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Husband Name"
                    name="husband" required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px; ">Contact
                    Number</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Contact Number"
                    name="number">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px; ">Photo</label>
                  <input type="file" id="fileInput" class="form-control" name="photo" required>
                  <p id="fileSizeError" style="color: red;"></p>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px; ">Full
                    Photo</label>
                  <input type="file" id="fileInput" class="form-control" name="full_photo" required>
                  <p id="fileSizeError" style="color: red;"></p>
                </div>

                <div class="form-check">
                  <input type="checkbox" checked class="form-check-input" id="exampleCheck1" required>
                  <label class="form-check-label" for="exampleCheck1">I Agree With T&C</label>
                </div>

                <br>
                <p id="statusMessage" style="color:red;" class="statusMessage"></p>
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="reset" class="btn btn-danger">Cancel</button>
              </form>
            </div>
          </div>
        </div>

        <script>
          document.getElementById('windowform').addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);

            formData.append('app_type', 0)

            fetch(commonApiPath + 'widow_aged.php', {
              method: 'POST',
              body: formData,
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
                alert('An error occurred while submitting the form.');
              });
          });

        </script>

        <div class="modal" id="modal4">
          <div class="container-fluid">
            <div class="modal-content">
              <div class="row">
                <div class="col-8">
                  <h4>Fill The Aged Women Details</h4>
                </div>
                <div class="col-4"> <span class="close" style="color:red; float:right;"
                    onclick="closeModal(4)">&times;</span>
                </div>
              </div>
              <div style="display:flex; ">
                <br>
              </div>
              <form id="agedForm" enctype="multipart/form-data">
                <input type="text" id="latitude" name="latitude" class="latitude" required>
                <input type="text" id="longitude" name="longitude" class="longitude" required>

                <div class="form-group">
                  <label for="name" style="color:black; font-weight:700; font-size:18px;">Name</label>
                  <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" required>
                </div>

                <div class="form-group">
                  <label for="dob" style="color:black; font-weight:700; font-size:18px;">Date Of Birth</label>
                  <input type="date" id="dob" class="form-control" placeholder="Enter Date Of Birth" name="dob"
                    required>
                  <p id="error-message" style="color: red;"></p>
                </div>

                <div class="form-group">
                  <label for="number" style="color:black; font-weight:700; font-size:18px;">Contact Number</label>
                  <input type="text" class="form-control" id="number" placeholder="Enter Contact Number" name="number"
                    required>
                </div>

                <div class="form-group">
                  <label for="photo" style="color:black; font-weight:700; font-size:18px;">Photo</label>
                  <input type="file" id="photo" class="form-control" name="photo" required>
                  <p id="fileSizeError" style="color: red;"></p>
                </div>

                <div class="form-group">
                  <label for="full_photo" style="color:black; font-weight:700; font-size:18px;">Full Photo</label>
                  <input type="file" id="full_photo" class="form-control" name="full_photo" required>
                  <p id="fileSizeError" style="color: red;"></p>
                </div>

                <div class="form-check">
                  <input type="checkbox" checked class="form-check-input" id="exampleCheck1" required>
                  <label class="form-check-label" for="exampleCheck1">I Agree With T&C</label>
                </div>

                <br>
                <p id="statusMessage" style="color:red;" class="statusMessage"></p>
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="reset" class="btn btn-danger">Cancel</button>
              </form>

              <script>
                document.getElementById('agedForm').addEventListener('submit', function (event) {
                  event.preventDefault();

                  const formData = new FormData();
                  const latitude = document.getElementById('latitude').value;
                  const longitude = document.getElementById('longitude').value;
                  const name = document.getElementById('name').value;
                  const dob = document.getElementById('dob').value;
                  const number = document.getElementById('number').value;
                  const photo = document.getElementById('photo').files[0];
                  const fullPhoto = document.getElementById('full_photo').files[0];

                  formData.append('latitude', latitude);
                  formData.append('longitude', longitude);
                  formData.append('name', name);
                  formData.append('dob', dob);
                  formData.append('number', number);
                  formData.append('photo', photo);
                  formData.append('full_photo', fullPhoto);

                  formData.append('app_type', 1)

                  fetch(commonApiPath + 'widow_aged.php', {
                    method: 'POST',
                    body: formData,
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
                      alert('An error occurred during submission.');
                    });
                });
              </script>

            </div>
          </div>
        </div>

        <div class="modal" id="modal5">
          <div class="container-fluid">
            <div class="modal-content">
              <div class="row">
                <div class="col-8">
                  <h4>Fill The Village Details</h4>
                </div>
                <div class="col-4"> <span class="close" style="color:red; float:right;"
                    onclick="closeModal(5)">&times;</span>
                </div>
              </div>
              <div style="display:flex; ">
                <br>
              </div>
              <form id="surveyForm" enctype="multipart/form-data">
                <input type="text" id="latitude" name="latitude" class="latitude" required>
                <input type="text" id="longitude" name="longitude" class="longitude" required>

                <div class="form-group">
                  <label for="villageName" style="color:black; font-weight:700; font-size:18px;">Village Name</label>
                  <input type="text" class="form-control" id="villageName" name="villageName" required>
                </div>

                <div class="form-group">
                  <label for="villagePopu" style="color:black; font-weight:700; font-size:18px;">Village
                    Population</label>
                  <input type="number" class="form-control" id="villagePopu" name="villagePopu" required>
                </div>

                <div class="form-group">
                  <label for="requesttype" style="color:black; font-weight:700; font-size:18px;">Select Request</label>
                  <select class="form-select" name="requesttype" id="requesttype">
                    <!-- <option value="Bore well">Bore well</option> -->
                    <option value="Medical Camp">Medical Camp</option>
                    <option value="Day Care Center">Day Care Center</option>
                    <option value="Community Problem">Community Problem</option>
                    <option value="Regular Problem">Regular Problem</option>
                    <option value="Meterial Problem">Meterial Problem</option>
                  </select>
                </div>

                <div class="form-check">
                  <input type="checkbox" checked class="form-check-input" id="exampleCheck1" required>
                  <label class="form-check-label" for="exampleCheck1">I Agree With T&C</label>
                </div>

                <br>
                <p id="statusMessage" style="color:red;" class="statusMessage"></p>
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="reset" class="btn btn-danger">Cancel</button>
              </form>

              <script>
                document.getElementById('surveyForm').addEventListener('submit', function (event) {
                  event.preventDefault();

                  const formData = new FormData();
                  const latitude = document.getElementById('latitude').value;
                  const longitude = document.getElementById('longitude').value;
                  const villageName = document.getElementById('villageName').value;
                  const villagePopu = document.getElementById('villagePopu').value;
                  const requesttype = document.getElementById('requesttype').value;

                  formData.append('latitude', latitude);
                  formData.append('longitude', longitude);
                  formData.append('villageName', villageName);
                  formData.append('villagePopu', villagePopu);
                  formData.append('requesttype', requesttype);

                  fetch(commonApiPath + 'village_survey.php',{
                    method: 'POST',
                    body: formData,
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
                      document.getElementById('statusMessage').textContent = "An error occurred. Please try again.";
                      document.getElementById('statusMessage').style.color = 'red';
                    });
                });
              </script>

            </div>
          </div>
        </div>

        <div class="modal" id="modal6">
          <div class="container-fluid">
            <div class="modal-content">
              <div class="row">
                <div class="col-8">
                  <h4>Fill The Activity Details</h4>
                </div>
                <div class="col-4"> <span class="close" style="color:red; float:right;"
                    onclick="closeModal(6)">&times;</span>
                </div>
              </div>
              <div style="display:flex; ">
                <br>
              </div>

              <form id="addotherform" enctype="multipart/form-data">
                <input type="text" id="latitude" name="latitude" class="latitude" required>
                <input type="text" id="longitude" name="longitude" class="longitude" required>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Name Of The
                    Activity</label>
                  <select class="form-select" name="name">
                    <option value="kids activities">Kids Activities</option>
                    <option value="Widows activities">Widows Activities</option>
                    <option value="Old age activities">Old Age Activities</option>
                    <option value="Pregnant ladies activities">Pregnant Ladies Activities</option>
                    <option value="Medical activities">Medical Activities</option>
                    <option value="Community activities">Community Activities</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Activity Held
                    On</label>
                  <input type="date" class="form-control" name="dates" required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Purpose</label>
                  <input type="text" class="form-control" name="purpose" required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1"
                    style="color:black; font-weight:700; font-size:18px;">Description</label>
                  <input type="text" class="form-control" name="description" required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Location</label>
                  <input type="text" class="form-control" name="address" placeholder="Enter Location">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1" style="color:black; font-weight:700; font-size:18px;">Photo</label>
                  <input type="file" id="fileInput" multiple class="form-control" name="photo[]"
                    onchange="validateFileSize()" required>
                  <p id="fileSizeError" style="color: red;"></p>
                </div>

                <div class="form-check">
                  <input type="checkbox" checked class="form-check-input" id="exampleCheck1" required>
                  <label class="form-check-label" for="exampleCheck1">I Agree With T&C</label>
                </div>

                <br>
                <p id="statusMessage" style="color:red;" class="statusMessage"></p>
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="reset" class="btn btn-danger">Cancel</button>
              </form>
              <script>
                document.getElementById("addotherform").addEventListener("submit", function (event) {
                  event.preventDefault();

                  const submitButton = document.querySelector("button[type='submit']");
                  submitButton.disabled = true;

                  var formData = new FormData(this);

                  document.getElementById("statusMessage").textContent = "Submitting...";

                  fetch(commonApiPath+"other-activities.php", {
                    method: "POST",
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
                      submitButton.disabled = false;
                    });
                });

              </script>

            </div>
          </div>
        </div>

      </div>

      <?php include '../includes/appBottomMenu.php' ?>
      <!-- 
      <script src="../assets/js/lib/bootstrap.bundle.min.js"></script>
      <script src="../assets/js/plugins/splide/splide.min.js"></script>
      <script src="../assets/js/app.js"></script> -->
</body>

</html>