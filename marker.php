<?php
if (session_status()==PHP_SESSION_NONE)
{
    session_start();
}

?>
<html>
<head>

//preinserted data
<script>

    //panacan
    var circle1 = L.circle([7.1524, 125.6588], {
        color: 'red',
        fillColor: '#ff6',
        fillOpacity: 0.5,
        radius: 1500
    }).addTo(map);

    //maa
    var circle2 = L.circle([7.101813, 125.582199], {
        color: 'red',
        fillColor: '#ff6',
        fillOpacity: 0.5,
        radius: 1500
    }).addTo(map);

    //cabantian
    var circle3 = L.circle([7.1290, 125.6173], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 1500
    }).addTo(map);

    //tibungco
    var circle4 = L.circle([7.1959, 125.6416], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 1500
    }).addTo(map);

    //buhangin
    var circle4 = L.circle([7.1590, 125.5986], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 1500
    }).addTo(map);


</script>
</head>
<body>

</body>
</html>