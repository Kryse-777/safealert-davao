<?php
if (session_status()==PHP_SESSION_NONE)
{
    session_start();
}

?>
<html>
<head>
<script>
    var circle1 = L.circle([7.1524, 125.6588], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 200
    }).addTo(map);
</script>
</head>
<body>

</body>
</html>