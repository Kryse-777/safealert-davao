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
    var markertest1 = L.marker([7.0984, 125.6198])
    var circle4 = L.circle([7.0984, 125.6198], {
        color: 'white',
        fillColor: 'white',
        fillOpacity: 0.5,
        radius: 500
    }).addTo(safeadmap);

    //davao one world
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

</script>
</head>
<body>
<?php

    $query = mysqli_query($safealertdb, "SELECT * FROM miscarea");
    while($row = mysqli_fetch_array($query))
    {
        echo "<script>";
        if($row['type']){
            echo     "var circle". $row['id'] ." = L.circle([". $row['coordinates'] ."], {
                    color: 'white',";

            if($row['type']=='Test') {
                $type = 'COVID-19 Testing';
                $radius = 500;
                $color = '#FFF';
            }
            elseif($row['type']=='Vaccine') {
                $type = 'COVID-19 Vaccination';
                $radius = 50;
                $color = 'cyan';
            }
        }

        echo "fillColor: '". $color ."',
            fillOpacity: 0.5,
                radius:". $radius ."
            }).addTo(safeadmap)
            circle". $row['id'] .".bindPopup('". $row['area'] ."<br/>Medical Facility: " . $type ."')";
        echo "</script>";
    }
    ?>
</body>
</html>