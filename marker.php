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

    //create quadrants for circle
    var Quadrant1 = createQuadrant(circle4,0).addTo(safeadmap);
    var Quadrant2 = createQuadrant(circle4,90).addTo(safeadmap);
    var Quadrant3 = createQuadrant(circle4,180).addTo(safeadmap);
    var Quadrant4 = createQuadrant(circle4,270).addTo(safeadmap);

    //react to detection
    function inQuadrant(quadrant,markerme){
        //var popup = marker.bindPopup("You are not inside a high risk area")
        var inPolygon = isMarkerInsidePolygon(markerme,quadrant);
        if(inPolygon){
            quadrant.setStyle({color: 'red'});
            //marker.bindPopup("You are inside a high risk area<br/>aaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
            //marker.openPopup()
        }else{
            //marker.closePopup(popup)
            quadrant.setStyle({color: '#3388ff'});
        }
    }

    //detect marker
    function isMarkerInsidePolygon(markerme, poly) {
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
    function createQuadrant(circle,degree){
        var degree
        var p1 = L.GeometryUtil.destination(circle4.getLatLng(), degree, circle.getRadius());
        var p2 = L.GeometryUtil.destination(circle4.getLatLng(), degree+22.5, circle.getRadius());
        var p3 = L.GeometryUtil.destination(circle4.getLatLng(), degree+45, circle.getRadius());
        var p4 = L.GeometryUtil.destination(circle4.getLatLng(), degree+67.5, circle.getRadius());
        var p5 = L.GeometryUtil.destination(circle4.getLatLng(), degree+90, circle.getRadius());
        return L.polygon([circle.getLatLng(),p1,p2,p3,p4,p5]);
    }

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