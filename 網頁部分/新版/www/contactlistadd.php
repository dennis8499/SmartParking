<?php
// 使用者點選放棄新增按鈕
if (isset($_POST['Abort']) && !empty($_POST['Abort'])) {
    header("Location: contactlist.php");
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



if (!isset($ID)) $ID = '';
if (!isset($Password)) $Password = '';
if (!isset($Nickname)) $Nickname = '';
if (!isset($LPN)) $LPN = '';

if (isset($Confirm)) {   // 確認按鈕
    if (empty($ID)) $ErrMsg = '姓名不可為空白\n';
    if (empty($Password)) $ErrMsg = '密碼不可為空白\n';
	if (empty($Nickname)) $ErrMsg = '暱稱不可為空白\n';
    if (empty($LPN)) $ErrMsg = '車牌不可為空白\n';	
    $sqlcmd = "SELECT * FROM user WHERE ID='$ID' AND valid='Y'";
	$result = querydb($sqlcmd, $db_conn);
	if(count($result) >= 1) $ErrMsg = 'ID重複';	
	if (empty($ErrMsg)) {  	
		$Password = sha1($Password);	
        $sqlcmd="INSERT INTO user(loginid, password, nickname, lpn) VALUES('$ID', '$Password', '$Nickname', '$LPN')";
        $result = updatedb($sqlcmd, $db_conn);			
        header("Location: contactlist.php");
        exit();		
    }
}
?>
<html>
	<head>
		<title>新增人員</title>
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
				<h1><a href="#">會員資料</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="contactlist.php">Home</a></li>
					</ul>
				</nav>
			</header>			
		<!-- One -->
			<section id="one" class="wrapper style1">
				<header class="major">
					<h2>註冊系統</h2>
					<p>請於輸入框中輸入帳號、密碼和暱稱，然後按「存檔送出」按鈕送出。</p>
				</header>
				<form method="POST" name = "" action="">
				<div class="container">
					<div class="row">					
						<div class="4u">
							<section class="special box">
							<h3>帳號：</h3>	
							 <input type="text" name="ID" value="<?php echo $ID ?>" >
							</section>
						</div>
						<div class="4u">
							<section class="special box">
							<h3>密碼：</h3>	
							<input type="text" name="Password" value="<?php echo $Password ?>" >
							</section>						
						</div>
						<div class="4u">						 
							<section class="special box">
							<h3>暱稱:</h3>	
							<input type="text" name="Nickname" value="<?php echo $Nickname ?>" >
							</section>
						</div>
                        <div class="4u">						 
							<section class="special box">
							<h3>車牌:</h3>	
							<input type="text" name="LPN" value="<?php echo $LPN ?>" >
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