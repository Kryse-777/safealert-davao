<?php
    echo "<script>";
    echo "setInterval(() => {
                        navigator.geolocation.getCurrentPosition(getQuadrant)
                    },time)
                    function getQuadrant(){";
    $query = mysqli_query($safealertdb, "SELECT * FROM `riskarea` WHERE risk <>''");
    while($row = mysqli_fetch_array($query))
    {
        //$row1=$row;
        //$row1--;
        echo "inQuadrant(Quadrant1" . $row['id'] . ",markerme,'". $row['area'] ."','" . $row['risk'] . "');
            inQuadrant(Quadrant2" . $row['id'] . ",markerme,'". $row['area'] ."','" . $row['risk'] . "');
            inQuadrant(Quadrant3" . $row['id'] . ",markerme,'". $row['area'] ."','" . $row['risk'] . "');
            inQuadrant(Quadrant4" . $row['id'] . ",markerme,'". $row['area'] ."','" . $row['risk'] . "');";


    }
    echo"}";
    echo "</script>";
?>