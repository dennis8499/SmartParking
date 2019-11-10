﻿<?php
if (isset($_POST['Register']) && !empty($_POST['Register'])) {
    header("Location: register.php");
    exit();
}
function userauth($ID, $PWD, $db_conn) {
    $sqlcmd = "SELECT * FROM user WHERE loginid='$ID' AND valid='Y'";
    $rs = querydb($sqlcmd, $db_conn);   
    $retcode = 0;
    if (count($rs) > 0) {
        $Password = sha1($PWD);		
        if ($Password == $rs[0]['password']) $retcode = 1;
    }
    return $retcode;
}
session_start();
session_unset();
require_once("include/gpsvars.php");

$ErrMsg = "";
if (!isset($ID)) $ID = "";
if (isset($Submit)) {
	require ("include/configure.php");
    require ("include/db_func.php");
	$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
    if (strlen($ID) > 0 && strlen($ID)<=16 && $ID==addslashes($ID)) {
        if($ID == 'adminuser'){
		  $Authorized = userauth($ID,$PWD,$db_conn);		
			if($Authorized){
				$sqlcmd = "SELECT * FROM user WHERE loginid='$ID' AND valid='Y'";
				$rs = querydb($sqlcmd, $db_conn);
				$LoginID = $rs[0]['loginid'];
				$_SESSION['LoginID'] = $LoginID;				
				header ("Location:contactlist.php");	                			
				exit();	
			}	
		}	
		else{
		 $Authorized = userauth($ID,$PWD,$db_conn);		
			if($Authorized){
			$sqlcmd = "SELECT * FROM user WHERE loginid='$ID' AND valid='Y'";
			$rs = querydb($sqlcmd, $db_conn);
			$LoginID = $rs[0]['loginid'];
			$_SESSION['LoginID'] = $LoginID;				
			header ("Location:menu.php");	                			
			exit();	
		    }
		}
		$ErrMsg = '<font color="Red">'
			. '您並非合法使用者或是使用權已被停止</font>';
    } else {
		$ErrMsg = '<font color="Red">'
			. 'ID錯誤，您並非合法使用者或是使用權已被停止</font>';
	}
  if (empty($ErrMsg)) $ErrMsg = '<font color="Red">登入錯誤</font>';  	
}
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<title>登入系統</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />		

			<link rel="stylesheet" href="css/main.css" />

	</head>
	<body id="top">

		<!-- Header -->
			<header id="header" class="skel-layers-fixed">
				<h1>智慧雲端停車場</h1>
				
					<ul class="icons">
						<li><a href="index.php" class="icon style2 fa-home"><span class="label">home</span></a></li>					
						<li><a href="register.php" class="icon style2 fa-book"></a></li>
					</ul>
				
			</header>	
<!-- One -->
			<section id="one" class="wrapper style1">
				<header class="major">
					<h2>登入系統</h2>
					<p>請於輸入框中輸入帳號與密碼，然後按「登入」按鈕登入。</p>
				</header>
				<form method="POST" name = "" action="">	
				<div class="container">
					<div class="row">										
					      <div class="4u">
							<section class="special box">
							<h3>帳號：</h3>	
							 <input type="text" name="ID" value="<?php echo $ID; ?>">
							</section>
						 </div>						
						<div class="4u">
							<section class="special box">
							<h3>密碼：</h3>	
							<input type="password" name="PWD" >
							</section>						
						</div>	
						<div class="4u">
							<section class="special box">
							<input type="submit" name="Submit" value="登入">
							<input type="submit" name="Register" value="註冊">
							<?php if (!empty($ErrMsg)) echo '</br>'.$ErrMsg; ?>
							</section>	
						</div>	
					</div>
				</div>
				</form>
			</section>
					<!-- Scripts -->
			<script src="js/jquery.min.js"></script>
			<script src="js/jquery.poptrox.min.js"></script>
			<script src="js/skel.min.js"></script>
			<script src="js/main.js"></script>

	</body>
</html>