<?php
// 使用者點選放棄新增按鈕
if (isset($_POST['Abort']) && !empty($_POST['Abort'])) {
    header("Location: parking.php");
    exit();
}
// Authentication 認證
require_once("include/auth.php");
// 變數及函式處理，請注意其順序
require_once("include/gpsvars.php");
require_once("include/configure.php");
require_once("include/db_func.php");
$ErrMsg = "";
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);



if (!isset($ParkID)) $ParkID = '';
if (!isset($Name)) $Name = '';
if (!isset($Address)) $Address = '';
if (!isset($HeightLimit)) $HeightLimit = '';
if (!isset($Lat)) $Lat = '';
if (!isset($Lng)) $Lng = '';
if (!isset($NoOfBlocks)) $NoOfBlocks = '';
if (!isset($Type)) $Type = '';
if (!isset($Html)) $Html = '';

if (isset($Confirm)) {   // 確認按鈕
    if (empty($ParkID)) $ErrMsg = '停車場代號不可為空白\n';
	if (empty($Name)) $ErrMsg = '停車場名稱不可為空白\n';
    if (empty($Address)) $ErrMsg = '地址不可為空白\n';
	
    if (empty($Lat)) $ErrMsg = '經度不可為空白\n';
    if (empty($Lng)) $ErrMsg = '緯度不可為空白\n';	
	
    if (empty($Type)) $ErrMsg = '種類不可為空白\n';
    if (empty($Html)) $ErrMsg = '網址不可為空白\n';	
    $sqlcmd = "SELECT * FROM parking WHERE parkid='$ParkID' AND valid='Y'";
	$result = querydb($sqlcmd, $db_conn);
	if(count($result) >= 1) $ErrMsg = 'ParkID重複';	
	if (empty($ErrMsg)) {
        $sqlcmd="INSERT INTO parking(parkid, name ,address, heightlimit, lat, lng, noofblocks, type, html) VALUES('$ParkID', '$Name','$Address', '$HeightLimit', '$Lat', '$Lng', '$NoOfBlocks', '$Type', '$Html')";
        $result = updatedb($sqlcmd, $db_conn);			
        header("Location: parking.php");
        exit();		
    }
}
?>
<html>
	<head>
		<title>新增地標</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<link rel="stylesheet" href="css/main.css" />
	</head>
	<body id="top">
		<!-- Header -->
			<header id="header" class="skel-layers-fixed">
				<h1>地標資料</h1>
				
					<ul class="icons">
						<li><a href="parking.php">Parking</a></li>
					</ul>
				
			</header>			
		<!-- One -->
			<section id="one" class="wrapper style1">
				<header class="major">
					<h2>註冊系統</h2>
					<p>請於輸入框中輸入地標代號、名稱...等，然後按「存檔送出」按鈕送出。</p>
				</header>
				<form method="POST" name = "" action="">
				<div class="container">
					<div class="row">					
						<div class="4u">
							<section class="special box">
							<h3>地標代號：</h3>	
							 <input type="text" name="ParkID" value="<?php echo $ParkID ?>" >
							</section>
						</div>
						<div class="4u">
							<section class="special box">
							<h3>地標名稱：</h3>	
							<input type="text" name="Name" value="<?php echo $Name ?>" >
							</section>						
						</div>
						<div class="4u">						 
							<section class="special box">
							<h3>地址:</h3>	
							<input type="text" name="Address" value="<?php echo $Address ?>" >
							</section>
						</div>
                        <div class="4u">						 
							<section class="special box">
							<h3>限高:</h3>	
							<input type="text" name="HeightLimit" value="<?php echo $HeightLimit ?>" >
							</section>
						</div>
						<div class="4u">
							<section class="special box">
							<h3>Lat:</h3>	
							 <input type="text" name="Lat" value="<?php echo $Lat ?>" >
							</section>
						</div>
						<div class="4u">
							<section class="special box">
							<h3>Lng:</h3>	
							 <input type="text" name="Lng" value="<?php echo $Lng ?>" >
							</section>
						</div>
						<div class="4u">
							<section class="special box">
							<h3>車位數:</h3>	
							<input type="text" name="NoOfBlocks" value="<?php echo $NoOfBlocks ?>" >
							</section>
						</div>
                        <div class="4u">
							<section class="special box">
							<h3>Type:</h3>	
							 <input type="text" name="Type" value="<?php echo $Type ?>" >
							</section>
						</div>
                        <div class="4u">
							<section class="special box">
							<h3>Html:</h3>	
							 <input type="text" name="Html" value="<?php echo $Html ?>" >
							</section>
						</div>						
					</div>
					<div align="center">
						<input type="submit" name="Confirm" value="存檔送出">
						<input type="submit" name="Abort" value="清除"> 
						<?php if (!empty($ErrMsg)) echo '<br />' . '<font color="RED">'.$ErrMsg.'</font>'; ?>
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