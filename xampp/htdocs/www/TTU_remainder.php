<?php 
   require_once("include/configure.php");
   require_once("include/db_func.php");
   require_once("include/aux_func.php");
   header("Content-Type:text/html;charset=utf-8");
   
   $db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
   $sqlcmd = "SELECT * FROM parkingblock WHERE parkingID = 'TTU' AND carstate = 'N'";
   $Contacts = querydb($sqlcmd, $db_conn);	  
   $sum = count($Contacts);  
   
   if($sum <= 0) echo "0";
   else echo $sum;  
?>