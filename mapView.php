<!DOCTYPE html>
<html>
<head>
  <title></title>
  <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
  <script src="js/gmaps.js"></script>
  <style type="text/css">
    #map {
      width: 400px;
      height: 400px;
    }
  </style>
</head>
<body>
  <div id="map"></div>
  <script>
  var test=<?php echo json_encode("-12.043333"); ?>;
  alert(test);
    var map = new GMaps({
      el: '#map',
      lat: test ,
      lng: -77.028333
    });
	
	map.addMarker({
  lat: test,
  lng: -77.028333,
  title: 'Lima',
  click: function(e) {
    alert('You clicked in this marker');
  }
});



infoWindow: {
  content: '<p>HTML Content</p>'
}
	
  </script>
</body>
</html>