<?php
require_once("include/configure.php");
require_once("include/db_func.php");
require_once("include/aux_func.php");
header("Content-Type:text/html;charset=utf-8");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$sqlcmd = "SELECT * FROM parking";
$Contacts = querydb($sqlcmd, $db_conn);	  
// get the q parameter from URL
function getDis($lat1,$lat2,$lng1,$lng2)
{
 $radLat1 = deg2rad($lat1);
 $radLat2 = deg2rad($lat2); 
 $a = $radLat1 - $radLat2;
 $b = deg2rad($lng1) - deg2rad($lng2); 
 $s = 2*asin(sqrt( pow(sin($a*0.5),2) + cos($radLat1)*cos($radLat2)*pow(sin($b*0.5),2) ));
 $s = $s*6378137;
 return $s;
}
$q = $_REQUEST["q"];

$hint = "";
$lat = "";
$lng = "";
$type = "";
// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    //$q = strtolower($q);
    $len=strlen($q);
    foreach($Contacts as $name) {
		$Name = $name['name'];		
        if (stristr($q, substr($Name, 0, $len))) {
            if ($hint === "") {
                $hint = $Name;
            } else {
                $hint .= ", $Name";
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values 
echo $hint === "" ? "搜尋失敗" : $hint;

$sqlcmd = "SELECT * FROM parking WHERE name = '$hint'";
$Result = querydb($sqlcmd, $db_conn);
foreach($Result as $item){
	$lat = $item['lat'];
	$lng = $item['lng'];
	$type = $item['type'];	
	//echo "\n".$lat."\n".$lng."\n".$type;
}

if($type == 'parking'){
	echo "\n附近500公尺的商家: ";
	$sqlcmd = "SELECT * FROM parking WHERE type = 'business'";
	$Result = querydb($sqlcmd, $db_conn);
	foreach($Result as $item){
		$latP = $item['lat'];
		$lngP = $item['lng'];        
		if (getDis($lat, $latP, $lng, $lngP) <= 500){			
			echo "\n".$item['name'];
		}
	}		
}
else if($type == 'business'){
	echo "\n"."附近500公尺的停車場和空間數: ";
	$sqlcmd = "SELECT * FROM parking WHERE type = 'parking'";
	$Result = querydb($sqlcmd, $db_conn);
	foreach($Result as $item){
		$latP = $item['lat'];
		$lngP = $item['lng'];        
		if (getDis($lat, $latP, $lng, $lngP) <= 500){			
			echo "\n<".$item['name'].",".$item['noofblocks'].">";
		}
	}		
}



?>
