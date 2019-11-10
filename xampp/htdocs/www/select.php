<html>
<script>
	function showHint(str) {		
		  if(window.ActiveXObject)
		{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			
		}
		else if(window.XMLHttpRequest)
		{
			xmlhttp=new XMLHttpRequest();			
		}
		if (str.length == 0) { 
			document.getElementById("txtHint").innerHTML = "";
			return;
		} else {			
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("txtHint").innerHTML = this.responseText;
				}
			};
			xmlhttp.open("GET", "gethint.php?q=" + str, true);
			xmlhttp.send();
		}
	}
</script>
<head>
	<title>Search</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
	<link rel="stylesheet" href="css/main.css" />
<style>
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
   }
#map {
   height: 100%;
}
.controls {
  margin-top: 10px;
  border: 1px solid transparent;
  border-radius: 2px 0 0 2px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  height: 32px;
  outline: none;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

#pac-input {
  background-color: #ff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 300px;
}

#pac-input:focus {
  border-color: #4d90fe;
}

.pac-container {
  font-family: Roboto;
}

#type-selector {
  color: #fff;
  background-color: #4d90fe;
  padding: 5px 11px 0px 11px;
}

#type-selector label {
  font-family: Roboto;
  font-size: 13px;
  font-weight: 300;
}
#target {
width: 345px;
}
</style>
</head>
	<body>
		<div id="wrapper">
		<!-- Header -->
				<header id="header">						
					<h1><a href="index.php">Home</a></h1>
					<ul class="icons">
					<li><a href="index.php" class="icon style2 fa-home">Home</a></li>	
					</ul>
				</header>				
		<!-- One -->
		<section id = "main">
		<span id="txtHint"></span>
		<input id="pac-input" class="controls" type="text" placeholder="Search Box" onkeyup="showHint(this.value)" style="color:black">
	    <div id="map"></div>
		 <script>
function initAutocomplete() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 25.0673666, lng: 121.5212688},
    zoom: 13,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  
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
			icon: 'http://maps.google.co.jp/mapfiles/ms/icons/cabs.png',
			title:"Hello Parkinglot!"
	  });		
	 } 
	 
  // Create the search box and link it to the UI element.
  var input = document.getElementById('pac-input');
  input.value="輸入你想找的地點"
  var searchBox = new google.maps.places.SearchBox(input);

  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });

  var markers = [];
  // [START region_getplaces]
  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    // Clear out the old markers.
    markers.forEach(function(marker) {
      marker.setMap(null);
    });
    markers = [];

    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      markers.push(new google.maps.Marker({
        map: map,
        icon: icon,
        title: place.name,
        position: place.geometry.location
      }));

      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });
  // [END region_getplaces]
}
    </script>
	 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoYNxQcqdHwslGwjiKbbIzWJhP8_Bi-wA&libraries=places&callback=initAutocomplete"
    async defer></script>
		  
		</section>
		   
		<!-- Footer -->
			<footer id="footer">
						<p>Created by TTU I102 Smartparking</p>
					</footer>
			</div>
		<!-- Scripts -->
			<script src="js/jquery.min.js"></script>
			<script src="js/jquery.poptrox.min.js"></script>
			<script src="js/skel.min.js"></script>
			<script src="js/main.js"></script>

	</body>
</html>