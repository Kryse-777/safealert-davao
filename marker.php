<?php
if (session_status()==PHP_SESSION_NONE)
{
    session_start();
}
    var circle2 = L.circle([7.1524, 125.6588], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 200
    }).addTo(map);
?>
<html>
<head>

</head>
<body>

</body>
</html>