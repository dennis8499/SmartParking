<?php
// 使用者點選放棄新增按鈕
if (isset($_POST['Abort']) && !empty($_POST['Abort'])) {
    header("Location: index.php");
    exit();
}
session_start();
session_unset();
// 變數及函式處理，請注意其順序
require_once("include/gpsvars.php");
require_once("include/configure.php");
require_once("include/db_func.php");
$ErrMsg = "";
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

if (!isset($LoginID)) $LoginID = '';
if (!isset($Password)) $Password = '';
if (!isset($Nickname)) $Nickname = '';
if (!isset($LPN)) $LPN = '';

function str_is_special($l1)
{
    $l2 = "&,',\",<,>,!,%,#,$,@,=,?,/,(,),[,],{,},.,+,*,_";
    $I2 = explode(',', $l2);
    $I2[] = ",";
 
    foreach ($I2 as $v) {
       if (strpos($l1, $v) !== false) {
           return true;
       }
    }
    return false;
}

if (isset($Confirm)) {   // 確認按鈕
    if (empty($LoginID)) $ErrMsg = '姓名不可為空白';
    if (empty($Password)) $ErrMsg= '密碼不可為空白';
	if (empty($Nickname)) $ErrMsg = '暱稱不可為空白';
    if (empty($LPN)) $ErrMsg = '車牌不可為空白';
	if (str_is_special($LoginID)==true) $ErrMsg ='請勿包含特殊字元';
    $sqlcmd = "SELECT * FROM user WHERE loginid='$LoginID' AND valid='Y'";
	$result = querydb($sqlcmd, $db_conn);
	if(count($result) >= 1) $ErrMsg = 'ID重複';	
	if (empty($ErrMsg)) {  	
		$Password = sha1($Password);	
        $sqlcmd="INSERT INTO user(loginid, password, nickname, lpn) VALUES('$LoginID', '$Password', '$Nickname', '$LPN')";
        $result = updatedb($sqlcmd, $db_conn);			
        header("Location: index.php");
        exit();		
    }
}
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<title>Register</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />


			<link rel="stylesheet" href="css/main.css" />


	</head>
	<body id="top">
		<!-- Header -->
			<header id="header" >
				<h1>智慧雲端停車場</h1>
				
					<ul class="icons">
						<li><a href="index.php" class="icon style2 fa-home"><span class="label">home</span></a></li>					
						<li><a href="sign.php" class="icon style2 fa-key"></a></li>
					</ul>
				
			</header>			
		<!-- One -->
			<section id="one" class="wrapper style1">
				<header class="major">
					<h2>註冊系統</h2>
					<p>請於輸入框中輸入帳號、密碼、暱稱和車牌號碼，然後按「存檔送出」按鈕送出。</p>
					<?php if (!empty($ErrMsg)) echo '<br />' . '<font color="RED">'.$ErrMsg.'</font>'; ?>
				</header>
				<form method="POST" name = "" action="">
				<div class="container">
					<div class="row">					
						<div class="4u">
							<section class="special box">
							<h3>帳號：</h3>	
							 <input type="text" name="LoginID" value="<?php echo $LoginID ?>" >
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