<?php
$act = 1;
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="style1.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://code.iconify.design/iconify-icon/2.0.0/iconify-icon.min.js"></script>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="icon" href="assets/images/logo.png" type="image/png">
  <link href="assets/css/bootstrap.css" rel="stylesheet" />
  <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet" />
  <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
  <link href="assets/css/lightbox.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script
    src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js"></script>
  <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>
  <script src="https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js"></script>

  <title>Trust</title>
  <style>
    li {
      list-style: none;
    }

    a {
      text-decoration: none;
    }
  </style>
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

      transform: translate(-30%, -30%);

      width: 50%;
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
  <script>
    // Replace these values with your desired latitude and longitude
    function map(lati, long, mapid) {
      var mapId = 'map' + mapid;

      // Check if map already exists

      // Create map container if needed


      // Initialize map
      var map = L.map(mapId).setView([lati, long], 30);

      // Add tile layer
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);

      // Add marker with popup
      L.marker([lati, long]).addTo(map)
        .bindPopup('Your content here');
    }



  </script>

  <script>
    let openedModelId;
    function openModal(lati, long, a) {

      document.getElementById("modal" + a).style.display = "block";
      // console.log(a)
      map(lati, long, a);
      let openedModelId = a;
    }
    function openModal1(a) {

      document.getElementById("modal" + a).style.display = "block";
      // map(lati, long, a);
      let openedModelId = a;
    }

    function closeModal(a) {
      document.getElementById("modal" + a).style.display = "none";
      let openedModelId;
    }

    // Close the modal if the user clicks outside the modal content
    window.onclick = function (event) {
      const modal = document.getElementById("modal" + openedModelId);
      if (event.target === modal) {
        closeModal();
      }
    };
  </script>
  <script>
    $(document).ready(function () {
      $('#searchInput').on('input', function () {
        searchTable();
      });
    });

    function searchTable() {
      var input, filter, table, tr, td, i, txtValue;
      input = $('#searchInput').val().toUpperCase();
      table = $('table');
      tr = table.find('tbody tr');

      tr.each(function () {
        td = $(this).find('td');
        var showRow = false;

        td.each(function () {
          txtValue = $(this).text().toUpperCase();
          if (txtValue.indexOf(input) > -1) {
            showRow = true;
            return false; // Break the inner loop if match found in this row
          }
        });

        if (showRow) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    }
    function openMedicalCampModal(a) {
      document.getElementById("modalupdate" + a).style.display = "block";
    }

    function closeUpdateModal(a) {
      document.getElementById("modalupdate" + a).style.display = "none";
    }

    function openMedicalphotoModal(a) {
      console.log(document.getElementById("modalphoto" + a), a)
      document.getElementById("modalphoto" + a).style.display = "block";
    }
    function openMedicalphotoModalclose(a) {
      document.getElementById("modalphoto" + a).style.display = "none";
    }
  </script>

  <script src="script.js"></script>




</head>