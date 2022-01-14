<?php
    include 'server.php';
    include 'notification.php';
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
    <title>SafeAlert Davao</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- GIS data -->


    <!-- CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <!-- JavaScript -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-geometryutil@0.9.3/src/leaflet.geometryutil.min.js"></script>
    <script type="text/javascript" src="jquery/jquery.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="sorttable.js"></script>
    <!--script type="text/javascript" src="js/leaflet.snogylop.js"></script-->

    <!--script type="text/javascript">
        $('.notify').each(function() {
            $(this).before($('<div>').text(" "));
        });
    </script-->

    <!--Main Tab-->
    <script>
        alert("SafeAlert Davao geolocation may take a few seconds to gain accuracy, please be patient\r\nStay safe, stay alert");

        $(document).ready(function(){
            $("#dashboard a").click(function(e){
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>
    <?php

    ?>
</head>
<body>

<!--form>
    <label for="latitude">Latitude:</label>
    <input id="latitude" type="text" />
    <label for="longitude">Longitude:</label>
    <input id="longitude" type="text" />
</form-->

<div id="title" style="background-color: white;">
    <span style="color: #00C8FF;">Safe</span><span style="color: red;">Alert</span>
    <span style="color: black;"> Davao</span>
</div>

<div class="main">
    <!-- Dashboard -->
    <ul id="dashboard" class="nav nav-pills">

        <li class="nav-item">
            <a href="#dashmap" class="nav-attend nav-link active">Map</a>
        </li>

        <li class="nav-item">
            <a href="#info" class="nav-attend nav-link">Info</a>
        </li>

        <li class="nav-item">
            <a href="#status" class="nav-attend nav-link">Status</a>
        </li>

        <!--li class="nav-item">
            <a href="#about" class="nav-attend nav-link"></a>
        </li-->
    </ul>

    <div class="tab-content">

        <!-- Map Tab -->
        <div class="tab-pane fade show active" id="dashmap">
            <h4 class="acch mt-2">SafeAlert Map</h4>
            <!--button onclick="safeadmap.fitBounds(featureGroup.getBounds());">Go to Me</button-->
            <label id="focus">Focus Me: </label>
            <label class="switch">
                <input id="focusme" type="checkbox" checked>
                <span class="slider round"></span>
            </label>
            <div id="map"></div>
        </div>

        <!-- Info Tab -->
        <div class="tab-pane fade" id="info">
            <h4 class="acch mt-2">Essential COVID-19 Information</h4>
            <div class="covupdate">
                <span>COVID-19 Information in Davao City as of January 9-16, 2022</span>
            </div>
            <!-- Info Table -->
            <table id="risktable" class="infotable sortable table table-striped">
                <thead>
                <tr>
                    <th>Area</th>
                    <th>Risk Assessment</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($safealertdb, "SELECT * FROM riskarea");

                    while($row = mysqli_fetch_array($result)){
                        if($row['risk']=='Critical') {
                            $color = '#E7B6C8';
                        }
                        elseif($row['risk']=='High') {
                            $color = '#FF9E9E';
                        }
                        elseif ($row['risk']=='Moderate')
                        {
                            $color = '#F6FF9E';
                        }
                        echo "<tr>";
                        echo "<td style='background-color: whitesmoke;border-color:#A7A7A7'>" . $row['area'] . "</td>";
                        echo "<td style='background-color: ".$color.";'>" . $row['risk'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Status Tab -->
        <div  class="tab-pane fade" id="status">
            <h4 class="acch mt-2">Current Local Status</h4>
            <div class="covupdate">
                <span>COVID-19 Status and Mandates in Davao City as of January 9-16, 2022</span>
            </div>
            <div id="locstat">
                <b>
                    Alert Level: 3<br/><br/>

                    Face-Shield Requirement: ✕<br/>
                    Face-Mask Requirement: ✓<br/>
                </b>
            </div>
        </div>

        <!-- About Tab -->
        <!--div  class="tab-pane fade" id="about">
            <h4 class="acch mt-2">About this Web App</h4>

        </div-->

    </div>
    SafeAlert v0.7.65
</div>

</body>

<!--Map v2-->
<script>
    // Map initialization
    var safeadmap = L.map('map').setView([7.1907, 125.4553], 10);
    var trackme = true;
    var time = 2500;
    //var time2 = 125;
    //osm layer
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });
    osm.addTo(safeadmap);

    //toggle focus
    /*
    var switchStatus = true;
    $("#focusme").on('change', function() {
        if ($(this).is(':checked')) {
            switchStatus = $(this).is(':checked');
            alert(switchStatus);// To verify
        }
        else {
            switchStatus = $(this).is(':checked');
            alert(switchStatus);// To verify
        }
    });
    */

    //toggle focus v2


    //gps
    if(!navigator.geolocation) {
        console.log("Your device location is disabled, please enable it. If your device or browser doesn't" +
            " support geolocation feature, you would not be able to fully utilize SafeAlert Davao web app")
        alert("Your device location is disabled, please enable it. If your device or browser doesn't" +
            " support geolocation feature, you would not be able to fully utilize SafeAlert Davao web app")
    } else {
        //alert("Geolocation is enabled. Safealert Davao is in full functionality")
        setInterval(() => {
            navigator.geolocation.getCurrentPosition(getPosition)
        },time);
    }
    var markerme, circleme;

    //alert(trackme);


    //update marker
    function getPosition(position){
        // console.log(position)
        var lat = position.coords.latitude
        var long = position.coords.longitude
        var accuracy = position.coords.accuracy

        if(markerme) {
            safeadmap.removeLayer(markerme)
        }

        if(circleme) {
            safeadmap.removeLayer(circleme)
        }





        var trackme=document.getElementById("focusme").checked
        console.log(trackme)

        markerme = L.marker([lat, long], {color:'blue'})
        circleme = L.circle([lat, long], {color:'#00C8FF',fillColor: '#00C8FF', fillOpacity: 0.25,radius: accuracy})
        var featureGroup = L.featureGroup([markerme, circleme]).addTo(safeadmap)


        if (trackme){
            safeadmap.fitBounds(featureGroup.getBounds())
            if (typeof code_run === 'undefined') {
                window.code_run = true;
                markerme.bindPopup("You are here<br/>Stay safe, stay alert!").openPopup();
            }
        }
        //inQuadrant(Quadrant1,markerme)
        //inQuadrant(Quadrant2,markerme)
        //inQuadrant(Quadrant3,markerme)
        //inQuadrant(Quadrant4,markerme)
        //markerme.bindPopup("You are here<br/>Stay safe, stay alert!")
        console.log("My coordinates: Lat: "+ lat +" Long: "+ long+ " Accuracy: "+ accuracy)
    }


</script>
<?php
    include 'davaoborder.php';
    include 'miscmarker.php';
    include 'riskmarker.php';
    include 'detectarea.php';
?>
</html>
