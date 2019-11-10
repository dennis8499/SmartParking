<?php
// 使用者點選放棄新增按鈕
if (isset($_POST['Abort']) && !empty($_POST['Abort'])) {
    header("Location: parkingblock.php");
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



if (!isset($BlockID)) $BlockID = '';
if (!isset($CurrentUser)) $CurrentUser = '';
if (!isset($Time)) $Time = '';

if (isset($Confirm)) {   // 確認按鈕
    if (empty($BlockID)) $ErrMsg = '停車格代號不可為空白\n';	
    if (empty($Time)) $ErrMsg = '可用時間不可為空白\n';	  
    $sqlcmd = "SELECT * FROM parkingblock WHERE blockid='$BlockID' AND valid='Y'";
	$result = querydb($sqlcmd, $db_conn);
	if(count($result) >= 1) $ErrMsg = 'BlockID重複';	
	if (empty($ErrMsg)) { 	
			
        $sqlcmd="INSERT INTO parkingblock(blockid, currentuser ,time) VALUES('$BlockID', '$CurrentUser','$Time')";
        $result = updatedb($sqlcmd, $db_conn);			
        header("Location: parkingblock.php");
        exit();		
    }
}
?>
<html>
	<head>
		<title>新增停車格</title>
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
				<h1><a href="#">停車格資料</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="parkingblock.php">Home</a></li>
					</ul>
				</nav>
			</header>			
		<!-- One -->
			<section id="one" class="wrapper style1">
				<header class="major">
					<h2>註冊系統</h2>
					<p>請於輸入框中輸入停車格代號、使用者...等，然後按「存檔送出」按鈕送出。</p>
				</header>
				<form method="POST" name = "" action="">
				<div class="container">
					<div class="row">					
						<div class="4u">
							<section class="special box">
							<h3>停車格代號：</h3>	
							 <input type="text" name="BlockID" value="<?php echo $BlockID ?>" >
							</section>
						</div>
						<div class="4u">
							<section class="special box">
							<h3>使用者名稱：</h3>	
							<input type="text" name="CurrentUser" value="<?php echo $CurrentUser ?>" >
							</section>						
						</div>
						<div class="4u">						 
							<section class="special box">
							<h3>時間:</h3>	
							<input type="text" name="Time" value="<?php echo $Time ?>" >
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