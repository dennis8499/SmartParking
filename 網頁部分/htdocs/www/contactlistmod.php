<?php
// 使用者點選放棄修改按鈕
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
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
// 確認參數是否正確
if (!isset($seqno)) die ("Parameter error!");
// 找出此用戶的群組
$sqlcmd = "SELECT * FROM user WHERE loginid='$LoginID' AND valid='Y'";
$rs = querydb($sqlcmd, $db_conn);
if (count($rs) <= 0) die ('Unknown or invalid user!');

// 處理使用者異動之資料
if (isset($Confirm)) {   // 確認按鈕
    if (!isset($Password) || empty($Password)) $ErrMsg = '密碼不可為空白\n';
    if (!isset($Nickname) || empty($Nickname)) $ErrMsg = '暱稱不可為空白\n';
    if (!isset($LPN) || empty($LPN)) $ErrMsg = '車牌不可為空白\n';	
    if (empty($ErrMsg)) {   // 資料經初步檢核沒問題
	$Passwordcode=sha1($Password);
    // Demo for XSS
    //    $Name = xssfix($Name);
    //    $Phone = xssfix($Phone);
    // Demo for the reason to use addslashes
        if (!get_magic_quotes_gpc()) {
            $Password = addslashes($Password);
            $Nickname = addslashes($Nickname);   
            $LPN = addslashes($LPN); 			
        }
		$Password = sha1($Password);
        $sqlcmd="UPDATE user SET password='$Passwordcode',nickname='$Nickname', lpn='$LPN' WHERE seqno='$seqno'";            
        $result = updatedb($sqlcmd, $db_conn);
        header("Location: contactlist.php");
        exit();
    }
}
if (!isset($Nickname)) {    
// 此處是在contactlist.php點選後進到這支程式，因此要由資料表將欲編輯的資料列調出
    $sqlcmd = "SELECT * FROM user WHERE seqno='$seqno'";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) <= 0) die('No data found');      // 找不到資料，正常應該不會發生
	$Name = $rs[0]['loginid'];
    $Password = $rs[0]['password'];
    $Nickname = $rs[0]['nickname'];
    $LPN = $rs[0]['lpn'];    
} else {    // 點選送出後，程式發現有錯誤
// Demo for stripslashes
    if (get_magic_quotes_gpc()) {
        $Password = stripslashes($Password);
        $Nickname = stripslashes($Nickname);
        $LPN = stripslashes($LPN);        
    }
}
?>
<html>
	<head>
		<title>人員修改</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />		
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>		
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
	</head>
	<body id="top">
    <div style="text-align:center;margin-top:5px;font-size:20px;font-weight:bold;">
    用戶資料修改</div>
	<div align="center">
	<div align="text-align:center">
	<form action="" method="post" name="inputform">
	<input type="hidden" name="seqno" value="<?php echo $seqno ?>">
	<b>修改人員資料</b>
	<table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">

	<tr height="30">
	  <th>Password:</th>
	  <td><input type="password" name="Password" value="<?php echo $Password ?>" size="20"></td>
	</tr>
	<tr height="30">
	  <th>Nickname:</th>
	  <td><input type="text" name="Nickname" value="<?php echo $Nickname ?>" size="50"></td>
	</tr>
    <tr height="30">
	  <th>LPN:</th>
	  <td><input type="text" name="LPN" value="<?php echo $LPN ?>" size="50"></td>
	</tr>		
	</table>
	<input type="submit" name="Confirm" value="存檔送出">&nbsp;
	<input type="submit" name="Abort" value="放棄修改">
	</form>
	</div>
	</body>
</html>