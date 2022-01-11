<?php
if (session_status()==PHP_SESSION_NONE)
{
    session_start();
}
    var circle = L.circle([50.895763, -1.150556], {
    color: 'red',
    fillColor: '#f03',
    fillOpacity: 0.5,
    radius: 200
}).addTo(mymap);
?>
<html>
<head>

</head>
<body>

</body>
</html>