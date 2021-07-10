<!DOCTYPE html>
<html>
  <head>
    <title>SafeAlert</title>

    <!-- (A) LOAD MAPBOX API - REGISTER & GET YOUR OWN KEYS FIRST -->
    <!-- https://www.mapbox.com/ | https://docs.mapbox.com/ -->
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css">

    <script>
    // (B) GET GPS COODINATES + DRAW MAP
    window.addEventListener("DOMContentLoaded", function () {
      // (B1) INSERT ACCESS TOKEN HERE!
      //mapboxgl.accessToken = 'TOKEN';
      mapboxgl.accessToken = 'pk.eyJ1Ijoia3J5c2UiLCJhIjoiY2txeDBvc2UwMDNmajJ2bzdneXZneHBwcCJ9.9n_6E_yA1aDN3Qz6jeMLLQ';

      navigator.geolocation.getCurrentPosition(
        // (B2) ON SUCCESSFULLY GETTING GPS COORDINATES
        function (pos) {
          // DRAW MAP
          let map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [pos.coords.longitude, pos.coords.latitude],
            zoom: 13
          });
          // DRAW MARKER
          let marker = new mapboxgl.Marker()
            .setLngLat([pos.coords.longitude, pos.coords.latitude])
            .addTo(map);
        },

        // (B3) ON FAILING TO GET GPS COORDINATES
        function (err) {
          console.log(err);
        },

        // (B4) GPS OPTIONS
        {
          enableHighAccuracy: true,
          timeout: 5000,
          maximumAge: 0
        }
      );
    });
    </script>
  </head>
  <body>
    <h2>SafeAlert Map</h2>
    <!-- (C) CONTAINER TO RENDER MAP -->
    <div id="map" style="width:100%; height:400px;"></div>
    <script type="text/javascript">
      var map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({
            source: new ol.source.OSM()
          })
        ],
        view: new ol.View({
          //center: [pos.coords.longitude, pos.coords.latitude],
          center: ol.proj.fromLonLat([37.41, 8.82]),
          zoom: 4
        })
      });
    </script>
  </body>
</html>