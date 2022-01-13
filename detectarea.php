<?php
    echo "<script>";
    echo "setInterval(() => {
                        navigator.geolocation.getCurrentPosition(getQuadrant)
                    },time)
                    function getQuadrant(){";
    $query = mysqli_query($safealertdb, "SELECT * FROM riskarea");
    while($row = mysqli_fetch_array($query))
    {
        //$row1=$row;
        //$row1--;
        echo "inQuadrant(Quadrant1" . $row['id'] . ",markerme);
            inQuadrant(Quadrant2" . $row['id'] . ",markerme);
            inQuadrant(Quadrant3" . $row['id'] . ",markerme);
            inQuadrant(Quadrant4" . $row['id'] . ",markerme);";
    }
    echo"}";
    echo "</script>";
?>