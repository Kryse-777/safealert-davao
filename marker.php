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
//risk areas
    //panacan

    var circle1 = L.circle([7.1524, 125.6588], {
        color: 'red',
        fillColor: '#ff6',
        fillOpacity: 0.5,
        radius: 1500
    }).addTo(safeadmap);

    //maa
    var circle2 = L.circle([7.101813, 125.582199], {
        color: 'red',
        fillColor: '#ff6',
        fillOpacity: 0.5,
        radius: 1500
    }).addTo(safeadmap);

    //cabantian
    var circle3 = L.circle([7.1290, 125.6173], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 1500
    }).addTo(safeadmap);

    //tibungco
    var circle4 = L.circle([7.1959, 125.6416], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 1500
    }).addTo(safeadmap);
    circle4.bindPopup("Tibungco<br/>Risk Assessment: High Risk");

    //buhangin
    var circle4 = L.circle([7.1590, 125.5986], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 1500
    }).addTo(safeadmap);


    //19-b
    var circle4 = L.circle([7.0929, 125.6068], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 1500
    }).addTo(safeadmap);


//testing sites
    //spmc
    var markertest1 = L.marker([7.0984, 125.6198], {color:'white'})
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

</body>
</html>