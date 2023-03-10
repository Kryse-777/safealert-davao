<!DOCTYPE html>
<html>
<head>
    <title></title>

<?php

    $i=0;
    $query = mysqli_query($safealertdb, "SELECT * FROM `riskarea` WHERE risk <>''");
    while($row = mysqli_fetch_array($query))
    {
        $i++;
        $area = $row['area'];
        //create circle
        echo "<script>";
            echo     "var circle". $row['id'] ." = new L.circle([". $row['coordinates'] ."], {
            color: '#E3044B', title:'".addslashes($area)."',";

            if($row['risk']=='Critical') {
                $color = '#803';
            }
            elseif($row['risk']=='High') {
                $color = '#b00';
            }
            elseif ($row['risk']=='Moderate')
            {
                $color = '#c62';
            }
            elseif ($row['risk']=='Low')
            {
                $color = 'yellow';
            }




        echo "fillColor: '". $color ."',
        fillOpacity: 0.5,
            radius: ". $row['radius'] ."
        }).addTo(safeadmap);
        circle". $row['id'] ."
        .bindPopup('".addslashes($area)."<br/><br/><b>COVID-19 Risk:</b><br/>" . $row['risk'] ." Risk"."<br/><br/><b>Cases during the past 2 Weeks:</b><br/>" . $row['casetwoweeks'] . "<br/><br/><b>Total cases:</b><br/>" . $row['casetotal'] ."');
        
        markersLayer.addLayer(circle". $row['id'] .");
        
        //create quadrants for circle
        var Quadrant1". $row['id'] ." = createQuadrant(circle". $row['id'] .",0).addTo(safeadmap);
        var Quadrant2". $row['id'] ." = createQuadrant(circle". $row['id'] .",90).addTo(safeadmap);
        var Quadrant3". $row['id'] ." = createQuadrant(circle". $row['id'] .",180).addTo(safeadmap);
        var Quadrant4". $row['id'] ." = createQuadrant(circle". $row['id'] .",270).addTo(safeadmap);
    
        Quadrant1". $row['id'] .".bindPopup('".addslashes($area)."<br/><br/><b>COVID-19 Risk:</b><br/>" . $row['risk'] ." Risk"."<br/><br/><b>Cases during the past 2 Weeks:</b><br/>" . $row['casetwoweeks'] . "<br/><br/><b>Total cases:</b><br/>" . $row['casetotal'] ."');
        Quadrant2". $row['id'] .".bindPopup('".addslashes($area)."<br/><br/><b>COVID-19 Risk:</b><br/>" . $row['risk'] ." Risk"."<br/><br/><b>Cases during the past 2 Weeks:</b><br/>" . $row['casetwoweeks'] . "<br/><br/><b>Total cases:</b><br/>" . $row['casetotal'] ."');
        Quadrant3". $row['id'] .".bindPopup('".addslashes($area)."<br/><br/><b>COVID-19 Risk:</b><br/>" . $row['risk'] ." Risk"."<br/><br/><b>Cases during the past 2 Weeks:</b><br/>" . $row['casetwoweeks'] . "<br/><br/><b>Total cases:</b><br/>" . $row['casetotal'] ."');
        Quadrant4". $row['id'] .".bindPopup('".addslashes($area)."<br/><br/><b>COVID-19 Risk:</b><br/>" . $row['risk'] ." Risk"."<br/><br/><b>Cases during the past 2 Weeks:</b><br/>" . $row['casetwoweeks'] . "<br/><br/><b>Total cases:</b><br/>" . $row['casetotal'] ."');
        
        //react to detection
        function inQuadrant(quadrant,markerme,area,risk){
            var parea = area;
            var prisk = risk;
            var popup = 'Focus Override<br/><b>Warning:</b> You are on or near '+parea+', a '+prisk
                +' Risk Area, be wary of your surroundings'
                +' and vacate the premises as soon as possible';
            //console.log('inquadrant function called');
            //var popup = markerme.bindPopup('You are not in a high risk area')
            var inPolygon = isMarkerInsidePolygon(markerme,quadrant);            
            if(inPolygon){
                quadrant.setStyle({color: 'red'});
                //markerme.setStyle({textColor: 'red'});
                markerme.bindPopup(popup);
                markerme.openPopup()
                markerme.getPopup().getElement().children[0].style.color = 'white'; 
                markerme.getPopup().getElement().children[0].style.background = '#CF4B4B'; 
                markerme.getPopup().getElement().children[1].children[0].style.background = '#CF4B4B';
                //notifPlay();
                //notifPlayonce;
                //setInterval(notifPlayonce, 500);
                //notifyMe();
            }
            else{
                quadrant.setStyle({color: 'none'});
                //
            }
        }
    
        //detect marker
        function isMarkerInsidePolygon(markerme, poly) {
            //console.log('ismarkerinsidepolygon function called');
            var inside = false;
            var x = markerme.getLatLng().lat, y = markerme.getLatLng().lng;
            for (var ii=0;ii<poly.getLatLngs().length;ii++){
                var polyPoints = poly.getLatLngs()[ii];
                for (var i = 0, j = polyPoints.length - 1; i < polyPoints.length; j = i++) {
                    var xi = polyPoints[i].lat, yi = polyPoints[i].lng;
                    var xj = polyPoints[j].lat, yj = polyPoints[j].lng;
    
                    var intersect = ((yi > y) != (yj > y))
                        && (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
                    if (intersect) inside = !inside;
                }
            }
    
            return inside;
        };
    
        //create circle hitbox
        function createQuadrant(circle". $row['id'] .",degree){
        //console.log('createquadrant function called');
        var degree
        var p1 = L.GeometryUtil.destination(circle". $row['id'] .".getLatLng(), degree, circle". $row['id'] .".getRadius());
        var p2 = L.GeometryUtil.destination(circle". $row['id'] .".getLatLng(), degree+22.5, circle". $row['id'] .".getRadius());
        var p3 = L.GeometryUtil.destination(circle". $row['id'] .".getLatLng(), degree+45, circle". $row['id'] .".getRadius());
        var p4 = L.GeometryUtil.destination(circle". $row['id'] .".getLatLng(), degree+67.5, circle". $row['id'] .".getRadius());
        var p5 = L.GeometryUtil.destination(circle". $row['id'] .".getLatLng(), degree+90, circle". $row['id'] .".getRadius());
        return L.polygon([circle". $row['id'] .".getLatLng(),p1,p2,p3,p4,p5]);
        }";
        echo "</script>";
    }
?>
</head>
<body>
</body>
</html>
