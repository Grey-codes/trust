<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Trust</title>
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
    <style>
        .leaflet-popup-tip {
            color: red;
            background-color: blue;
        }

        .leaflet-popup-content-wrapper {
            background-color: blue;
            color: red;
        }

        #mySelect {
            width: 300px;
            height: 40px;
            display: inline;
            margin-left: 20px;
            position: relative;
            top: -5;
        }
    </style>
</head>

<?php
session_start();
if (!isset($_SESSION['aId'])) {
    header("location:../index.php");
}
include '../../config.php';
$act = 12;
?>

<body>
    <?php
    include 'includes/sidebar.php';
    ?>
    <section id="content">

        <?php
        include 'includes/navbar.php';
        ?>

        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Profile</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Profile</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Home</a>
                        </li>
                    </ul>
                </div>

            </div>
            <div style="margin-top: 5%; padding-bottom: 30px">
                <center>
                    <div style="color: #cf3f3f; padding-bottom: 20px">
                        <div style="display: inline; font-size: 30px; color: #008742">
                            Source Type:
                        </div>
                        <select class="form-select" id="mySelect">
                            <option value="all">All</option>
                            <option value="students">Students</option>
                            <option value="old-age-women">Old Age Women</option>
                            <option value="pregnant-ladies">Pregnant Ladies</option>
                            <option value="widow">Widows</option>
                            <option value="bore-well">Bore Well</option>
                        </select>
                    </div>
                </center>
                <script>
                    let element = document.getElementById("loading");
                    const styleElement = document.createElement('style');
                    document.head.appendChild(styleElement);
                    const styleSheet = styleElement.sheet;
                    let value = 450 - (450 * 1);
                    const keyframesAnimation = `
                        @keyframes anim {
                            100% {
                                stroke-dashoffset: ${value};
                            }
                        }
                    `
                    var sleepSetTimeout_ctrl;
                    function sleep(ms) {
                        return new Promise(resolve => setTimeout(resolve, ms));
                    }
                    ;
                    styleSheet.insertRule(keyframesAnimation, styleSheet.cssRules.length);
                </script>
                <div>
                    <center>
                        <div id="mapid" style="height: 500px;width: 500px;display: flex;border: 2px solid red">
                        </div>
                    </center>
                </div>
                <?php
                echo '<script>
            var oldAgedWomenIcon = L.icon({
                iconUrl: "../images/oldwomen.png",
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                tooltipAnchor: [16, -28],
                shadowSize: [41, 41]
            });
            var studentIcon = L.icon({
                iconUrl: "../images/studentpointer.png",
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                tooltipAnchor: [16, -28],
                shadowSize: [41, 41]
            });
            var villageIcon = L.icon({
                iconUrl: "../images/village.png",
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                tooltipAnchor: [16, -28],
                shadowSize: [41, 41]
            });
            var pregnantsIcons = L.icon({
                iconUrl: "../images/pregnantpointer.png",
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                tooltipAnchor: [16, -28],
                shadowSize: [41, 41]
            });
            var widowsIcons = L.icon({
                // iconUrl: "../images/widow.png",
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                tooltipAnchor: [16, -28],
                shadowSize: [41, 41]
            });
            let markers = [];
            let data = {};
            data["students"] = []
            data["bore-well"] = []
            data["old-age-women"] = []
            data["pregnant-ladies"] = []
            data["widow"] = []
            let div = document.getElementById("mapType")
            var mymap = L.map("mapid", { minZoom: 1 }).fitWorld();
            let mapType = "https://api.maptiler.com/maps/basic-v2/{z}/{x}/{y}.png?key=Cc5OwwEIfY0lIuQYcR6q"
                let map = L.tileLayer(mapType, { attribution: `<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>`, maxZoom: 30, minZoom: 1, noWrap: true }).addTo(mymap);
                document.getElementsByClassName("leaflet-control-attribution leaflet-control")[0].remove()
            function removeMarkers() {
                console.log(data);
                markers.forEach(function(marker) {
                    marker.remove();
                });
                markers = [];
            }
            </script>';
                $studentsResult = mysqli_query($conn, 'select * from student');
                if (mysqli_num_rows($studentsResult) > 0) {
                    $latitudeAndLongitudes = [];
                    $coordinates = [];
                    while ($row = mysqli_fetch_assoc($studentsResult)) {
                        $coordinates[] = array(
                            "latitude" => $row["LATITUDE"],
                            "longitude" => $row["LONGITUDE"],
                            "text" => "Student"
                        );
                    }
                    ?>
                    <script>
                        var coordinates = <?php echo json_encode($coordinates); ?>;
                        coordinates.forEach(function (coordinate) {
                            var marker = L.marker([coordinate.latitude, coordinate.longitude], { icon: studentIcon }).addTo(mymap);
                            marker.bindPopup('<h5>' + coordinate.text + '</h5>', { maxHeight: 0 });
                            data["students"].push(coordinate);
                            markers.push(marker);
                        });
                    </script>
                    <?php
                } else {
                    echo "No records found<br>";
                }
                $boreWellResult = mysqli_query($conn, 'select * from borewell');
                if (mysqli_num_rows($boreWellResult) > 0) {
                    $latitudeAndLongitudes = [];
                    $coordinates = [];
                    while ($row = mysqli_fetch_assoc($boreWellResult)) {
                        $coordinates[] = array(
                            "latitude" => $row["Latitude"],
                            "longitude" => $row["Longitude"],
                            "text" => "Village"
                        );
                    }
                    ?>
                    <script>
                        var coordinates = <?php echo json_encode($coordinates); ?>;
                        coordinates.forEach(function (coordinate) {
                            var marker = L.marker([coordinate.latitude, coordinate.longitude], { icon: villageIcon }).addTo(mymap);
                            marker.bindPopup('<h5>' + coordinate.text + '</h5>', { maxHeight: 0 });
                            data["bore-well"].push(coordinate);
                            markers.push(marker);
                        });
                    </script>
                    <?php
                } else {
                    echo "No records found<br>";
                }
                $oldAgeWomenResults = mysqli_query($conn, 'select * from widow_aged');
                if (mysqli_num_rows($oldAgeWomenResults) > 0) {
                    $latitudeAndLongitudes = [];
                    $coordinates = [];
                    $widowCoordinates = [];
                    while ($row = mysqli_fetch_assoc($oldAgeWomenResults)) {
                        if ($row["app_type"] == 0) {
                            $coordinates[] = array(
                                "latitude" => $row["LATITUDE"],
                                "longitude" => $row["LONGITUDE"],
                                "text" => "Old aged women"
                            );
                        } else {
                            $widowCoordinates[] = array(
                                "latitude" => $row["LATITUDE"],
                                "longitude" => $row["LONGITUDE"],
                                "text" => "Widow"
                            );
                        }
                    }
                    ?>
                    <script>
                        var coordinates = <?php echo json_encode($coordinates); ?>;
                        coordinates.forEach(function (coordinate) {
                            var marker = L.marker([coordinate.latitude, coordinate.longitude], { icon: oldAgedWomenIcon }).addTo(mymap);
                            marker.bindPopup('<h5>' + coordinate.text + '</h5>', { maxHeight: 0 });
                            data["old-age-women"].push(coordinate);
                            markers.push(marker);
                        });
                        var coordinates1 = <?php echo json_encode($widowCoordinates); ?>;
                        coordinates1.forEach(function (coordinate) {
                            var marker = L.marker([coordinate.latitude, coordinate.longitude], { icon: widowsIcons }).addTo(mymap);
                            marker.bindPopup('<h5>' + coordinate.text + '</h5>', { maxHeight: 0 });
                            data["widow"].push(coordinate);
                            markers.push(marker);
                        });
                    </script>
                    <?php
                } else {
                    echo "No records found<br>";
                }
                $pregnantsResult = mysqli_query($conn, 'select * from pregnant');
                if (mysqli_num_rows($pregnantsResult) > 0) {
                    $latitudeAndLongitudes = [];
                    $coordinates = [];
                    while ($row = mysqli_fetch_assoc($pregnantsResult)) {
                        $coordinates[] = array(
                            "latitude" => $row["LATITUDE"],
                            "longitude" => $row["LONGITUDE"],
                            "text" => "Pregnant"
                        );
                    }
                    ?>
                    <script>
                        var coordinates = <?php echo json_encode($coordinates); ?>;
                        coordinates.forEach(function (coordinate) {
                            var marker = L.marker([coordinate.latitude, coordinate.longitude], { icon: pregnantsIcons }).addTo(mymap);
                            marker.bindPopup('<h5>' + coordinate.text + '</h5>', { maxHeight: 0 });
                            data["pregnant-ladies"].push(coordinate);
                            markers.push(marker);
                        });
                    </script>
                    <?php
                } else {
                    echo "No records found<br>";
                }
                ?>
                <script>
                    document.getElementById("mySelect").addEventListener("change", function (event) {
                        myFunction(event.target.value);
                        console.log(data)
                    });

                    function myFunction(value) {
                        if (value === "students") {
                            removeMarkers();
                            data?.[value].forEach(function (coordinate) {
                                var marker = L.marker([coordinate.latitude, coordinate.longitude], { icon: studentIcon }).addTo(mymap);
                                marker.bindPopup('<h5>' + coordinate.text + '</h5>', { maxHeight: 0 });
                                markers.push(marker);
                            });
                        }
                        else if (value === "bore-well") {
                            removeMarkers();
                            data?.[value].forEach(function (coordinate) {
                                var marker = L.marker([coordinate.latitude, coordinate.longitude], { icon: villageIcon }).addTo(mymap);
                                marker.bindPopup('<h5>' + coordinate.text + '</h5>', { maxHeight: 0 });
                                markers.push(marker);
                            });
                        }
                        else if (value === "old-age-women") {
                            removeMarkers();
                            data?.[value].forEach(function (coordinate) {
                                var marker = L.marker([coordinate.latitude, coordinate.longitude], { icon: oldAgedWomenIcon }).addTo(mymap);
                                marker.bindPopup('<h5>' + coordinate.text + '</h5>', { maxHeight: 0 });
                                markers.push(marker);
                            });
                        }
                        else if (value === "pregnant-ladies") {
                            removeMarkers();
                            data?.[value].forEach(function (coordinate) {
                                var marker = L.marker([coordinate.latitude, coordinate.longitude], { icon: pregnantsIcons }).addTo(mymap);
                                marker.bindPopup('<h5>' + coordinate.text + '</h5>', { maxHeight: 0 });
                                markers.push(marker);
                            });
                        }
                        else if (value === "widow") {
                            removeMarkers();
                            data?.[value].forEach(function (coordinate) {
                                var marker = L.marker([coordinate.latitude, coordinate.longitude], { icon: widowsIcons }).addTo(mymap);
                                marker.bindPopup('<h5>' + coordinate.text + '</h5>', { maxHeight: 0 });
                                markers.push(marker);
                            });
                        }
                        else {
                            data?.["pregnant-ladies"].forEach(function (coordinate) {
                                var marker = L.marker([coordinate.latitude, coordinate.longitude], { icon: pregnantsIcons }).addTo(mymap);
                                marker.bindPopup('<h5>' + coordinate.text + '</h5>', { maxHeight: 0 });
                                markers.push(marker);
                            });
                            data?.["students"].forEach(function (coordinate) {
                                var marker = L.marker([coordinate.latitude, coordinate.longitude], { icon: studentIcon }).addTo(mymap);
                                marker.bindPopup('<h5>' + coordinate.text + '</h5>', { maxHeight: 0 });
                                markers.push(marker);
                            });
                            data?.["old-age-women"].forEach(function (coordinate) {
                                var marker = L.marker([coordinate.latitude, coordinate.longitude], { icon: oldAgedWomenIcon }).addTo(mymap);
                                marker.bindPopup('<h5>' + coordinate.text + '</h5>', { maxHeight: 0 });
                                markers.push(marker);
                            });
                            data?.["bore-well"].forEach(function (coordinate) {
                                var marker = L.marker([coordinate.latitude, coordinate.longitude], { icon: villageIcon }).addTo(mymap);
                                marker.bindPopup('<h5>' + coordinate.text + '</h5>', { maxHeight: 0 });
                                markers.push(marker);
                            });
                            data?.["widow"].forEach(function (coordinate) {
                                var marker = L.marker([coordinate.latitude, coordinate.longitude], { icon: widowsIcons }).addTo(mymap);
                                marker.bindPopup('<h5>' + coordinate.text + '</h5>', { maxHeight: 0 });
                                markers.push(marker);
                            });
                        }
                    }
                </script>
            </div>
        </main>
        <script src="script.js"></script>
</body>

</html>