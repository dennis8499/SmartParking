<?php
// 使用者點選放棄新增按鈕
if (isset($_POST['Abort']) && !empty($_POST['Abort'])) {
    header("Location: owner.php");
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

if (!isset($Name)) $Name = '';
if (!isset($BlockNo)) $BlockNo = '';
if (!isset($Profile)) $Profile = '';

if (isset($Confirm)) {   // 確認按鈕
    if (empty($Name)) $ErrMsg = '姓名不可為空白\n';
    if (empty($BlockNo)) $ErrMsg = '擁有車位不可為空白\n';
	if (empty($Profile)) $ErrMsg = '簡介不可為空白\n';
    
    $sqlcmd = "SELECT * FROM owner WHERE name='$Name' AND valid='Y'";
	$result = querydb($sqlcmd, $db_conn);
	if(count($result) >= 1) $ErrMsg = 'ID重複';	
	if (empty($ErrMsg)) {  	
		$Password = sha1($Password);	
        $sqlcmd="INSERT INTO owner(Name, BlockNo, Profile) VALUES('$Name', '$BlockNo', '$Profile')";
        $result = updatedb($sqlcmd, $db_conn);			
        header("Location: owner.php");
        exit();		
    }
}
?>
<html>
	<head>
		<title>新增人員</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<link rel="stylesheet" href="css/main.css" />
	</head>
	<body id="top">
		<!-- Header -->
			<header id="header" class="skel-layers-fixed">
				<h1><a href="#">會員資料</a></h1>
				
					<ul class="icons">
						<li><a href="owner.php">Owner</a></li>
					</ul>
				
			</header>			
		<!-- One -->
			<section id="one" class="wrapper style1">
				<header class="major">
					<h2>註冊系統</h2>
					<p>請於輸入框中輸入名稱、擁有車位和簡介，然後按「存檔送出」按鈕送出。</p>
				</header>
				<form method="POST" name = "" action="">
				<div class="container">
					<div class="row">					
						<div class="4u">
							<section class="special box">
							<h3>名稱</h3>	
							 <input type="text" name="Name" value="<?php echo $Name ?>" >
							</section>
						</div>
						<div class="4u">
							<section class="special box">
							<h3>擁有車位</h3>	
							<input type="text" name="BlockNo" value="<?php echo $BlockNo ?>" >
							</section>						
						</div>
						<div class="4u">						 
							<section class="special box">
							<h3>簡介:</h3>	
							<input type="text" name="Profile" value="<?php echo $Profile ?>" >
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