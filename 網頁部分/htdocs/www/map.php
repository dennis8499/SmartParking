<!DOCTYPE html>
<?php 
// Authentication 認證
require_once("include/auth.php");
// 變數及函式處理，請注意其順序
require_once("include/gpsvars.php");
require_once("include/configure.php");
require_once("include/db_func.php");
require_once("include/aux_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
?>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	  <style type="text/css">
      html, body { height: 100%; margin: 0; padding: 0; }
      #map { height: 100%; }
    </style>
    <title>PHP/MySQL & Google Maps Example</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoYNxQcqdHwslGwjiKbbIzWJhP8_Bi-wA"
            type="text/javascript"></script>
<script type="text/javascript">
  var customIcons = {
      restaurant: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
      },
      parking: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
      }
    };
 function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(25.0673666, 121.5212688),
        zoom: 18,
        mapTypeId: 'roadmap'
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
			title:"Hello Parkinglot!"
	  });		
	 } 
	  
	  var infoWindow = new google.maps.InfoWindow;  
     
	  <?php 
	  $sqlcmd = "SELECT * FROM parking WHERE valid='Y'";
	  $Contacts = querydb($sqlcmd, $db_conn);	  
	  foreach ($Contacts AS $item) {
		  echo "var name ="."\"".$item['name']."\"".";\n";
		  echo "var address ="."\"".$item['address']."\"".";\n";
		  echo "var point = new google.maps.LatLng(parseFloat(".$item['lat']."), parseFloat(". $item['lng']."));\n";
		  echo "var ip ="."\"".$item['html']."\"".";\n";
	      echo "var html =  '<br>' + name +'</b> <br/>' + address + '<br/>' + ip;\n";
		  echo "var type = "."\"".$item['type']."\"".";\n";
		  echo "var icon = customIcons[type] || {};\n";
	      echo "var marker = new google.maps.Marker({map: map, position: point, icon:icon.icon});\n";
   		  echo "\n";	
		}
	  ?>
      bindInfoWindow(marker, map, infoWindow, html);
 }        

   

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
	 }  

</script>
  </head>
  <body onload="load()">
    <div id="map"></div>
  </body>
</html>