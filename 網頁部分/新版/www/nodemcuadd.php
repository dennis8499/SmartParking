<?php
// 使用者點選放棄新增按鈕
if (isset($_POST['Abort']) && !empty($_POST['Abort'])) {
    header("Location: nodemcu.php");
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



if (!isset($ChipID)) $ChipID = '';
if (!isset($Topic)) $Topic = '';
if (!isset($BlockNo)) $BlockNo = '';


if (isset($Confirm)) {   // 確認按鈕
    if (empty($ChipID)) $ErrMsg = '晶片ID不可為空白\n';
    if (empty($Topic)) $ErrMsg = '主題不可為空白\n';
	if (empty($BlockNo)) $ErrMsg = '所屬車位不可為空白\n';   
	
    $sqlcmd = "SELECT * FROM nodemcu WHERE chipid='$ChipID' AND valid='Y'";
	$result = querydb($sqlcmd, $db_conn);
	if(count($result) >= 1) $ErrMsg = 'ID重複';	
	if (empty($ErrMsg)) {  				
        $sqlcmd="INSERT INTO nodemcu(chipid, topic, blockno) VALUES('$ChipID', '$Topic', '$BlockNo')";
        $result = updatedb($sqlcmd, $db_conn);			
        header("Location: nodemcu.php");
        exit();		
    }
}
?>
<html>
	<head>
		<title>新增Nodemcu</title>
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
				<h1><a href="#">Nodemcu資料</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="nodemcu.php">Home</a></li>
					</ul>
				</nav>
			</header>			
		<!-- One -->
			<section id="one" class="wrapper style1">
				<header class="major">
					<h2>註冊系統</h2>
					<p>請於輸入框中輸入ChipID、Topic和所屬車位，然後按「存檔送出」按鈕送出。</p>
				</header>
				<form method="POST" name = "" action="">
				<div class="container">
					<div class="row">					
						<div class="4u">
							<section class="special box">
							<h3>ChipID: </h3>	
							 <input type="text" name="ChipID" value="<?php echo $ChipID ?>" >
							</section>
						</div>
						<div class="4u">
							<section class="special box">
							<h3>Topic: </h3>	
							<input type="text" name="Topic" value="<?php echo $Topic ?>" >
							</section>						
						</div>
						<div class="4u">						 
							<section class="special box">
							<h3>BlockNo:</h3>	
							<input type="text" name="BlockNo" value="<?php echo $BlockNo ?>" >
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