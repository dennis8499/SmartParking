<?php 
   require_once("../include/configure.php");
   require_once("../include/db_func.php");
   require_once("../include/aux_func.php");
   header("Content-Type:text/html;charset=utf-8");
   header("Access-Control-Allow-Origin: *"); 
   
   $db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
   $sqlcmd = "SELECT * FROM parkingblock WHERE blockid = 'TTA001'";
   $Contacts = querydb($sqlcmd, $db_conn);	  
   foreach($Contacts AS $item){
	   $carstate = $item['carstate'];
   }  
   
   if($carstate == 'Y'){
	   echo "occupied";
   }else if($carstate == 'N'){
	   echo "empty";
   }
?>