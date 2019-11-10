<?php 
   require_once("include/configure.php");
   require_once("include/db_func.php");
   require_once("include/aux_func.php");
   header("Content-Type:text/html;charset=utf-8");
   
   $db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
   $sqlcmd = "SELECT * FROM parkingblock WHERE blockid = 'TTU001'";
   $Contacts = querydb($sqlcmd, $db_conn);	  
   foreach($Contacts AS $item){
	   $carstate = $item['carstate'];
   }  
   
   if($carstate == 'Y'){
	   echo "<img src = 'parking/occupied.jpg' alt='' style = 'position:absolute;left:513px;top:550px;'>";	   
   }else if($carstate == 'N'){
	   echo "<img src = 'parking/empty.jpg' alt='' style = 'position:absolute;left:513px;top:550px;'>";
   }
?>