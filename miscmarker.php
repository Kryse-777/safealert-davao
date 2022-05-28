<?php
if (session_status()==PHP_SESSION_NONE)
{
    session_start();
}

?>
<html>
<head>


 <!--preinserted data-->
<script>
    /*
    var latlngs = L.polygon[[
        [125.4847183227539,6.968949794769344],
        [125.43668365478538,6.968349933624211],
        [125.40583801269577,6.965499877929688],
        [125.48906707763706,6.984350204467773],
        [125.4847183227539,6.968949794769344]
    ]];
    var davaopolygontest = L.polygon(latlngs, {color: 'green'}).addTo(safeadmap);
    */
    /*
    var latlngs = L.polygon[[
        [6.968949794769344, -125.4847183227539],
        [6.968349933624211, -125.43668365478538],
        [6.965499877929688, -125.40583801269577],
        [6.984350204467773, -125.48906707763706],
        [6.968949794769344, -125.4847183227539]
    ]];
    var davaopolygontest = L.polygon(latlngs, {color: 'green'}).addTo(safeadmap);
    */

//testing sites

    //spmc
    /*
    var markertest1 = L.marker([7.0701,125.6042]).addTo(safeadmap);
    //markertest1.bindPopup('Test Area1<br/>Medical Facility: Test Facility1')"
    markertest1.bindPopup("Test Area1<br/>Medical Facility: Test Facility1");
    markertest2 = L.marker([7.0984, 125.6198],{color:'blue'}).addTo(safeadmap);
    //markertest2.bindPopup('Test Area2<br/>Medical Facility: Test Facility2')"
    var featureGroup = L.featureGroup([markertest1]).addTo(safeadmap);
    //featureGroup.bindPopup('Test Area3<br/>Medical Facility: Test Facility3')";
    var circle4 = L.circle([7.0846, 125.6154], {
        color: 'white',
        fillColor: 'white',
        fillOpacity: 0.5,
        radius: 500
    }).addTo(safeadmap);
    circle4.bindPopup("Test Area2<br/>Medical Facility: Test Facility2");

    options = {
        icon: 'leaf',
        iconShape: 'marker'
    };
    L.marker([7.0612, 125.5702], {
        icon: L.BeautifyIcon.icon(options),
        draggable: true
    }).addTo(safeadmap).bindPopup("popup").bindPopup("This is a BeautifyMarker");
    */


    //test1
    /*
    var redMarker = L.AwesomeMarkers.icon({
        icon: 'coffee',
        markerColor: 'red'
    });
    L.marker([7.0612, 125.5702], {icon: redMarker}).addTo(safeadmap);
    redMarker.bindPopup("Test Area3<br/>Medical Facility: Test Facility3");
    */

    //davao one world
    /*
    var circle5 = L.circle([7.0612, 125.5702], {
        color: 'white',
        fillColor: 'white',
        fillOpacity: 0.5,
        radius: 500
    }).addTo(safeadmap);

    //davao doctors hospital
    var circle6 = L.circle([7.0701,125.6042], {
        color: 'white',
        fillColor: 'white',
        fillOpacity: 0.5,
        radius: 500
    }).addTo(safeadmap);


//vaccination sites

    //usep gym
    var circle6 = L.circle([7.0846, 125.6154], {
        color: 'green',
        fillColor: 'green',
        fillOpacity: 0.5,
        radius: 50
    }).addTo(safeadmap);

     */

</script>
</head>
<body>
<?php

    $query = mysqli_query($safealertdb, "SELECT * FROM miscarea");
    $i=0;
    while($row = mysqli_fetch_array($query))
    {
        $i++;
        echo "<script>";

        if($row['type']=='Test') {
            $type = 'COVID-19 Testing';
            $iconcolor = '#00AEFF';
            $color = 'white';
            $tag = 'Testing Facility';
        }
        elseif($row['type']=='Vaccine') {
            $type = 'COVID-19 Vaccination';
            $iconcolor = '#61FF00';
            $color = '#61FF00';
            $tag = 'Vaccination Facility';
        }

        echo "options = {
            icon: 'medkit',
            iconShape: 'marker',
            borderColor: '".$color."',
            textColor: '".$iconcolor."'            
        };
        marker".$i." = new L.marker([". $row['coordinates'] ."], {
            icon: L.BeautifyIcon.icon(options),
        tags: ['".$tag."']";
        echo ", title:'". $row['area'];
        echo "'}).addTo(safeadmap).bindPopup('popup').bindPopup('". $row['area'] ."<br/>Medical Facility: " . $type ."');";
        echo "markersLayer.addLayer(marker".$i.");";
        echo "</script>";
    }

?>
</body>
</html>