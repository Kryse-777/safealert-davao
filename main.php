<?php

//include 'server.php';
if (session_status()==PHP_SESSION_NONE)
{
    session_start();
}

/*
if(!isset($_SESSION['username'])){
    header('location:login.php');
}
*/

//Time Value
//$time = '09:20:03.00';
//echo date("h:i A") . "\n";

//echo "</br>";

//Date Value
//echo(date("Y-m-d"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>SafeAlert Davao Heroku</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- GIS data -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet' />

    <!-- CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <!-- JavaScript -->
    <script type="text/javascript" src="jquery/jquery.min.js"></script>

    <!--script type="text/javascript" src="accsearch.js"></script-->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            width: 100%;
            height: 100vh;
        }
    </style>

    <!--script type="text/javascript">
        $('.notify').each(function() {
            $(this).before($('<div>').text(" "));
        });
    </script-->

    <!--Map-->
    <!--script>
        // (B) GET GPS COORDINATES + DRAW MAP
        window.addEventListener("DOMContentLoaded", function () {
          // (B1) INSERT ACCESS TOKEN HERE!
          //mapboxgl.accessToken = 'TOKEN';
          mapboxgl.accessToken = 'pk.eyJ1Ijoia3J5c2UiLCJhIjoiY2txeDBvc2UwMDNmajJ2bzdneXZneHBwcCJ9.9n_6E_yA1aDN3Qz6jeMLLQ';

            navigator.geolocation.getCurrentPosition(
                // (B2) ON SUCCESSFULLY GETTING GPS COORDINATES
                function (pos) {
                    // DRAW MAP
                    let map = new mapboxgl.Map({
                        container: 'map',
                        style: 'mapbox://styles/mapbox/streets-v11',
                        center: [pos.coords.longitude, pos.coords.latitude],
                        zoom: 15
                    });
                    navigator.geolocation.watchPosition(
                        function(mark){
                            let marker = new mapboxgl.Marker()
                                .setLngLat([pos.coords.longitude, pos.coords.latitude])
                                .addTo(map);
                        },
                        function (err) {
                            console.log(err);
                        },

                        // (B4) GPS OPTIONS
                        {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );

                },

                // DRAW MARKER



                // (B3) ON FAILING TO GET GPS COORDINATES
                function (err) {
                    console.log(err);
                },

                // (B4) GPS OPTIONS
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        });
    </script-->

    <!--Main Tab-->
    <script>
        $(document).ready(function(){
            $("#dashboard a").click(function(e){
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>
</head>
<body>
<div id="title" style="background-color: white;">
    <span style="color: #00C8FF;">Safe</span>
    <span style="color: red;">Alert</span>
</div>

<div class="main">
    SafeAlert v0.1.1

    <!-- Dashboard -->
    <ul id="dashboard" class="nav nav-pills">

        <li class="nav-item">
            <a href="#dashmap" class="nav-attend nav-link active">Map</a>
        </li>

        <li class="nav-item">
            <a href="#info" class="nav-attend nav-link">Info</a>
        </li>



        <li class="nav-item">
            <a href="#status" id="attendancetab" class="nav-attend nav-link">Status</a>
        </li>
    </ul>

    <div class="tab-content">

        <!-- Map Tab -->
        <div class="tab-pane fade show active" id="dashmap">
            <h4 class="acch mt-2">SafeAlert Map</h4>
            <div id="map"></div>
        </div>

        <!-- Info Tab -->
        <div class="tab-pane fade" id="info">
            <h4 class="acch mt-2">Essential COVID-19 Information</h4>
            Essential Info Content
        </div>

        <!-- Status Tab -->
        <div  class="tab-pane fade" id="status">
            <h4 class="acch mt-2">Current Local Status</h4>
            Local Status Content
        </div>

    </div>
</div>

</body>

<!--Map v2-->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    // Map initialization
    var map = L.map('map').setView([7.1957337, 125.6239334], 6);

    //osm layer
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });
    osm.addTo(map);

    if(!navigator.geolocation) {
        console.log("Your browser doesn't support geolocation feature!")
    } else {
        setInterval(() => {
            navigator.geolocation.getCurrentPosition(getPosition)
        }, 5000);
    }

    var marker, circle;

    function getPosition(position){
        // console.log(position)
        var lat = position.coords.latitude
        var long = position.coords.longitude
        var accuracy = position.coords.accuracy

        if(marker) {
            map.removeLayer(marker)
        }

        if(circle) {
            map.removeLayer(circle)
        }

        marker = L.marker([lat, long])
        circle = L.circle([lat, long], {radius: accuracy})

        var featureGroup = L.featureGroup([marker, circle]).addTo(map)

        map.fitBounds(featureGroup.getBounds())

        console.log("Your coordinate is: Lat: "+ lat +" Long: "+ long+ " Accuracy: "+ accuracy)
    }
</script>

</html>
