<?php
   require_once("../include/configure.php");
   require_once("../include/db_func.php");
   require_once("../include/aux_func.php");
   header("Content-Type:text/html;charset=utf-8");
   header("Access-Control-Allow-Origin: *"); 
   $db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);  
   
   	$lat = "";
	$lng = "";
	$latP = "";
	$lngP = "";
	
   
    function getDis($lat1, $lat2, $lng1, $lng2){
      $radLat1 = deg2rad($lat1);
	  $radLat2 = deg2rad($lat2);
	  $a = $radLat1 - $radLat2;
	  $b = deg2rad($lng1) - deg2rad($lng2);
	  $s = 2 * asin(sqrt(pow(sin($a * 0.5), 2) + cos($radLat1)*cos($radLat2)*pow(sin($b*0.5), 2)));
	   $s = $s*6378137;	  
	  return $s;	  
	}	
   
   if($_SERVER['REQUEST_METHOD']=='GET'){		
        $lat = $_GET['lat'];
        $lng = $_GET['lng'];	
		$sqlcmd = "SELECT * FROM parking WHERE type = 'parking'";		
		$Contacts = querydb($sqlcmd, $db_conn);			
		$result = array();
		
	foreach($Contacts AS $item){
		$latP = $item['lat'];
		$lngP = $item['lng'];		
		if(getDis($lat, $latP, $lng, $lngP) <= 500){
		   array_push($result,array("name"=>$item['name'],"address"=>$item['address'],"noofblocks"=>$item['noofblocks']));			
		}	
	    
    } 		
		
		echo json_encode(array("result"=>$result));	         		
		
	}



?>