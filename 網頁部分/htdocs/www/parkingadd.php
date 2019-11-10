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
if (!isset($GpsLocation)) $GpsLocation = '';
if (!isset($NoOfBlocks)) $NoOfBlocks = '';

if (isset($Confirm)) {   // 確認按鈕
    if (empty($ParkID)) $ErrMsg = '停車場代號不可為空白\n';
	if (empty($Name)) $ErrMsg = '停車場名稱不可為空白\n';
    if (empty($Address)) $ErrMsg = '地址不可為空白\n';
	if (empty($HeightLimit)) $ErrMsg = '限高不可為空白\n';
    if (empty($GpsLocation)) $ErrMsg = 'GPS位置不可為空白\n';	
	if (empty($NoOfBlocks)) $ErrMsg = '車位數不可為空白\n';	
    $sqlcmd = "SELECT * FROM parking WHERE parkid='$ParkID' AND valid='Y'";
	$result = querydb($sqlcmd, $db_conn);
	if(count($result) >= 1) $ErrMsg = 'ParkID重複';	
	if (empty($ErrMsg)) {
        $sqlcmd="INSERT INTO parking(parkid, name ,address, heightlimit, gpslocation, noofblocks) VALUES('$ParkID', '$Name','$Address', '$HeightLimit', '$GpsLocation', '$NoOfBlocks')";
        $result = updatedb($sqlcmd, $db_conn);			
        header("Location: parking.php");
        exit();		
    }
}
?>
<html>
	<head>
		<title>新增停車場</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />		
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
	</head>
	<body id="top">
		<!-- Header -->
			<header id="header" class="skel-layers-fixed">
				<h1><a href="#">停車場資料</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="parking.php">Home</a></li>
					</ul>
				</nav>
			</header>			
		<!-- One -->
			<section id="one" class="wrapper style1">
				<header class="major">
					<h2>註冊系統</h2>
					<p>請於輸入框中輸入停車場代號、名稱...等，然後按「存檔送出」按鈕送出。</p>
				</header>
				<form method="POST" name = "" action="">
				<div class="container">
					<div class="row">					
						<div class="4u">
							<section class="special box">
							<h3>停車場代號：</h3>	
							 <input type="text" name="ParkID" value="<?php echo $ParkID ?>" >
							</section>
						</div>
						<div class="4u">
							<section class="special box">
							<h3>停車場名稱：</h3>	
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
							<h3>GPS:</h3>	
							 <input type="text" name="GpsLocation" value="<?php echo $GpsLocation ?>" >
							</section>
						</div>
						<div class="4u">
							<section class="special box">
							<h3>剩餘車位:</h3>	
							<input type="text" name="NoOfBlocks" value="<?php echo $NoOfBlocks ?>" >
							</section>
						</div>	
					</div>
					<div align="center">
						<input type="submit" name="Confirm" value="存檔送出">
						<input type="submit" name="Abort" value="清除"> 
						<?php if (!empty($ErrMsg)) echo '<br />' . $ErrMsg; ?>
					</div>
				</div>
				</form>
			</section>	
	</body>
</html>