<!DOCTYPE html>
<html>
  <head>
    <style type="text/css">
      html, body { height: 100%; margin: 0; padding: 0; }
      #map { height: 100%; }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script type="text/javascript">

var map;
function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: -34.397, lng: 150.644},
    zoom: 18,
	mapTypeId: google.maps.MapTypeId.ROADMAP
  });
	
	var taipei = new google.maps.LatLng(25.08, 121.45);   

	if(window.navigator.geolocation){   
		var geolocation=window.navigator.geolocation;   
		geolocation.getCurrentPosition(getPositionSuccess);   
	}else{   
		alert("你的瀏覽器不支援地理定位");   
		map.setCenter(taipei);   
	}   
	function getPositionSuccess(position){   
		initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);   
		//定位到目前位置   
		map.setCenter(initialLocation); 
		//marker.setMap(map);
				var marker = new google.maps.Marker({
		position: initialLocation,
		map: map,
		title:"Hello Parkinglot!"
	});		
	} 
   
	
}

    </script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoYNxQcqdHwslGwjiKbbIzWJhP8_Bi-wA&callback=initMap">
    </script>
  </body>
</html>