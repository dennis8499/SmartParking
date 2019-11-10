<?php
   require_once("../include/configure.php");
   require_once("../include/db_func.php");
   require_once("../include/aux_func.php");
   header("Content-Type:text/html;charset=utf-8");
   header("Access-Control-Allow-Origin: *");  
   
   if($_SERVER['REQUEST_METHOD']=='GET'){		
		$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
		$sqlcmd = "SELECT * FROM parking WHERE type = 'business'";		
		$Contacts = querydb($sqlcmd, $db_conn);	
		
		$result = array();
		
	foreach($Contacts AS $item){
	    array_push($result,array("name"=>$item['name'],"address"=>$item['address'],"html"=>$item['html']));			
    } 		
		
		echo json_encode(array("result"=>$result));	         		
		
	}



?>