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
    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/icon.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no,
    shrink-to-fit=no">

    <!-- GIS data -->


    <!-- CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="css/leaflet-search.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/leaflet.awesome-markers.css">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css">
    <link rel="stylesheet" href="css/leaflet-beautify-marker-icon.css">
    <link rel="stylesheet" href="css/leaflet-easy-button.css" />
    <link rel="stylesheet" href="css/leaflet-tag-filter-button.css" />
    <link rel="stylesheet" href="css/ripple.min.css" />
    

    <!-- JavaScript -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-geometryutil@0.9.3/src/leaflet.geometryutil.min.js"></script>
    <script type="text/javascript" src="js/leaflet-search.js"></script>
    <script type="text/javascript" src="jquery/jquery.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/sorttable.js"></script>
    <script type="text/javascript" src="js/leaflet.awesome-markers.js"></script>
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
    <script type="text/javascript" src="js/leaflet-beautify-marker-icon.js"></script>
    <script type="text/javascript" src="js/leaflet-easy-button.js"></script>
    <script type="text/javascript" src="js/leaflet-tag-filter-button.js"></script>

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

    <!--Risk Table Search-->
    <script>
        function searchRiskarea() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("tblsearchrsk");
            filter = input.value.toUpperCase();
            table = document.getElementById("risktable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    }
                    else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

    <!--Misc Table Search-->
    <script>
        function searchMiscarea() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("tblsearchmsc");
            filter = input.value.toUpperCase();
            table = document.getElementById("misctable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    }
                    else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>


    <!--Hide/Show Toggle-->
    <script>
        $(document).ready(function(){
            $("#protcontent").hide();
            $("#genstatcontent").hide();
            $("#risktblbtn").click(function(){
                $(".risksearchdiv").toggle(150);
                //$("#risktable").toggle(150);
            });
            $("#misctblbtn").click(function(){
                $(".miscsearchdiv").toggle(150);
                //$("#misctable").toggle(150);

            });
            $("#protbtn").click(function(){
                $("#protcontent").toggle(150);
            });
            $("#genstatbtn").click(function(){
                $("#genstatcontent").toggle(150);
            });
        });
    </script>

    <!--Return to Top-->
    <script>
        //Get the button
        var returnbutton = document.getElementById("topbtn");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
            if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                returnbutton.style.display = "block";
            } else {
                returnbutton.style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function returntopFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
</head>
<body>

<!--form>
    <label for="latitude">Latitude:</label>
    <input id="latitude" type="text" />
    <label for="longitude">Longitude:</label>
    <input id="longitude" type="text" />
</form-->
<div style="text-align: right; margin-right: 10px;">
    <a href="admin.php" class="hidden-mobile">Admin<a>
</div>
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
            <h4 id="maptitle" class="acch mt-2">SafeAlert Davao Map</h4>
            <!--button onclick="safeadmap.fitBounds(featureGroup.getBounds());">Go to Me</button-->
            <div id="focusbtn">
                <label id="focus">Focus Me:</label>
                <label class="switch">
                    <input id="focusme" type="checkbox" checked>
                    <span class="slider round"></span>
                </label>
            </div>
            <div id="map"></div></br></br>
            <div id="legendtext">Map Legend</div></br>
            <img id="legend" src="images/legend.png" alt="SafeAlert Davao Map Legend">
            <button onclick="returntopFunction()" id="topbtn" title="Go back to top">Return to Top</button>
        </div>

        <!-- Info Tab -->
        <div class="tab-pane fade" id="info">
            <h4 class="acch mt-2">Additional COVID-19 Information</h4>
            <div class="covupdate">
                <span>COVID-19 Area Information in Davao City as of May 1-7, 2022</span>
            </div>
            <!-- Info Table -->
                <!-- Risk Table -->
                <div class="tablename">
                    <button id="risktblbtn" class="infobtn">▽</button> <a style="color: #2D8795"> RISK  AREAS</a>
                    <div class="risksearchdiv">Area Search:
                    <input type="text" id="tblsearchrsk" onkeyup="searchRiskarea()" placeholder="" title="">
                    </div>
                </div>
                <div class="risksearchdiv table-wrapper">
                <div class="risksearchdiv table-scroll">
                <table id="risktable" class="risksearchdiv assesstable infotable sortable table table-striped">
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
                                $color = '#FFDC9E';
                            }
                            elseif ($row['risk']=='Low')
                            {
                                $color = '#F6FF9E';
                            }
                            elseif ($row['risk']=='Minimal')
                            {
                                $color = '#83FF00';
                            }

                            echo "<tr>";
                            if($row['risk']) {
                                echo "<td style='background-color: whitesmoke;border-color:#A7A7A7'>" . $row['area'] . "</td>";
                                echo "<td style='background-color: " . $color . ";'>" . $row['risk'] . "</td>";
                            }
                            echo "</tr>";
                        }?>
                    </tbody>
                    </table>
                </div>
                </div>
                <br/><br/>

                <!-- Misc Table -->
                <div class="tablename">
                    <button id="misctblbtn" class="infobtn">▽</button> <a style="color: #2D8795"> MISCELLANEOUS  AREAS</a>
                    <div class="miscsearchdiv">Area Search:
                    <input type="text" id="tblsearchmsc" onkeyup="searchMiscarea()" placeholder="" title="">
                    </div>
                </div>
                <div class="miscsearchdiv table-wrapper">
                <div class="miscsearchdiv table-scroll">
                <table id="misctable" class="miscsearchdiv assesstable infotable sortable table table-striped">
                    <thead>
                    <tr>
                        <th>Area</th>
                        <th>Facility Type</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = mysqli_query($safealertdb, "SELECT * FROM miscarea");

                            while($row = mysqli_fetch_array($result)){
                                if($row['type']=='Test') {
                                    $type = 'COVID-19 Testing Facility';
                                    $color = 'white';
                                }
                                elseif($row['type']=='Vaccine') {
                                    $type = 'COVID-19 Vaccination Facility';
                                    $color = 'cyan';
                                }

                                echo "<tr>";
                                if($row['type']) {
                                    echo "<td style='background-color: whitesmoke;border-color:#A7A7A7'>" . $row['area']
                                    . "</td>";
                                    echo "<td style='background-color: " . $color . ";'>" . $row['type'] . "</td>";
                                }
                                echo "</tr>";
                            }

                        ?>
                    </tbody>
                    </table>
                </div>
                </div>
        </div>

        <!-- Status Tab -->
        <div  class="tab-pane fade" id="status">
            <h4 class="acch mt-2">Current Local Status</h4>
            <div class="covupdate">
                <span>COVID-19 Status and Mandates in Davao City as of May 1-7, 2022</span>
            </div>
            <b>
            <div id="riskclass">

                Davao City Overall Risk Classification:<br/>
                <div style="margin-top:10px">
                <?php
                    $result = mysqli_query($safealertdb, "SELECT * FROM status");
                    while($row = mysqli_fetch_array($result)){
                        if($row['class']=='Critical') {
                            $color = '#E7B6C8';
                        }
                        elseif($row['class']=='High') {
                            $color = '#FF9E9E';
                        }
                        elseif ($row['class']=='Moderate')
                        {
                            $color = '#FFDC9E';
                        }
                        elseif ($row['class']=='Low')
                        {
                            $color = '#F6FF9E';
                        }
                        elseif($row['class']=='Minimal') {
                            $color = '#83FF00';
                        }
                        echo " <a style='background-color:" . $color . "; padding:5px'>" . $row['class'] . "</a><br/>";
                ?>

                </div>
            </div>
            <div class="locstat">
                <div class="stathead">
                    <button id="protbtn" class="statbtn">▽</button> Protocols
                </div>
                <div id="protcontent" class="statcontent" value="">
                <?php
                    $qrid= null;
                    if($row['qrid']=='true'){
                        $qrid='✓';
                        $qcolor='blue';
                    }
                    elseif ($row['qrid']=='false'){
                        $qrid='✕';
                        $qcolor='red';
                    }

                    $shield= null;
                    if($row['shield']=='true'){
                        $shield='✓';
                        $scolor='blue';
                    }
                    elseif ($row['shield']=='false'){
                        $shield='✕';
                        $scolor='red';
                    }
                    $mask= null;
                    if($row['mask']=='true'){
                        $mask='✓';
                        $mcolor='blue';
                    }
                    elseif ($row['mask']=='false'){
                        $mask='✕';
                        $mcolor='red';
                    }
                    echo "QR ID Requirement:  <a style='color: ".$qcolor."'>". $qrid ."</a><br/><br/>";
                    echo "Face-Shield Requirement: <a style='color: ".$scolor."'>". $shield ."</a><br/>";
                    echo "Face-Mask Requirement: <a style='color: ".$mcolor."'>". $mask ."</a><br/>";
                    ?>
                    <br/>
                </div>
            </div>
            <div class="locstat">
                <div class="stathead">
                    <button id="genstatbtn" class="statbtn">▽</button> Statistics
                </div>
                <div id="genstatcontent" class="statcontent">
                    City Alert Level: <?php echo $row['alert'] ?><br/><br/>

                    Cumulative Number of Cases: <a style='color: purple'><?php echo $row['cases'] ?></a><br/>
                    Cases in the past 2 weeks: <a style='color: purple'><?php echo $row['casetwowk'] ?></a><br/>
                    <br/><br/>
                </div>
            </div></b>
            <?php
                }
            ?>
        </div>

        <!-- About Tab -->
        <!--div  class="tab-pane fade" id="about">
            <h4 class="acch mt-2">About this Web App</h4>

        </div-->

    </div>

</div>
    <a class="main"><a><!--SafeAlert v0.8.2-->
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

    //Leaflet Filter
    L.control.tagFilterButton({
        data: ['Testing Facility', 'Vaccine Facility', 'None'],
        icon: '<img src="images/filter.png">',
        filterOnEveryClick: true
    }).addTo(safeadmap);


    //Leaflet Search Data
    var areadata = [
        <?php
            /*
        $sql ='SELECT area, coordinates FROM riskarea UNION ALL SELECT area, coordinates FROM miscarea';
        $query = mysqli_query($safealertdb, $sql);
        while($row = mysqli_fetch_array($query))
        echo "{'loc':[". $row['coordinates'] ."], 'title':'". $row['area'] ."'},";
        */
        ?>
    ];

    //Leaflet Search
    var markersLayer = new L.LayerGroup();	//layer contain searched elements
    safeadmap.addLayer(markersLayer);
    var controlSearch = new L.Control.Search({
        position:'topright',
        layer: markersLayer,
        initial: false,
        zoom: 15,
        marker: false
    });

    safeadmap.addControl(controlSearch);

    ////////////populate map with markers from sample data
    for(i in areadata) {
        var title = areadata[i].title,	//value searched
            loc = areadata[i].loc,		//position found
            marker = new L.Marker(new L.latLng(loc), {title: title} );//se property searched
        //marker.bindPopup('title: '+ title );
        markersLayer.addLayer(marker);
        //document.getElementById("checkbox").checked = false;
    }


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

        //Track User
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

        optionme = null;

        markerme = L.marker([lat, long], { icon: L.BeautifyIcon.icon({
                icon: 'user',
                iconShape: 'marker',
                borderColor: '#00F3FF',
                textColor: 'black'
            })})
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
        markerme.bindPopup("You are here<br/>Stay safe, stay alert!")
        console.log("My coordinates: Lat: "+ lat +" Long: "+ long+ " Accuracy: "+ accuracy)
    }



</script>
<?php
    //include 'admin.php';

    include 'davaoborder.php';
    include 'miscmarker.php';
    include 'riskmarker.php';
    include 'detectarea.php';

?>
</html>
