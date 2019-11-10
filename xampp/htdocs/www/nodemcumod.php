<?php
// 使用者點選放棄修改按鈕
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
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
// 確認參數是否正確
if (!isset($seqno)) die ("Parameter error!");
// 找出此用戶的群組
$sqlcmd = "SELECT * FROM user WHERE loginid='$LoginID' AND valid='Y'";
$rs = querydb($sqlcmd, $db_conn);
if (count($rs) <= 0) die ('Unknown or invalid user!');

// 處理使用者異動之資料
if (isset($Confirm)) {   // 確認按鈕
    if (!isset($Topic) || empty($Topic)) $ErrMsg = '主題不可為空白\n';
    if (!isset($BlockNo) || empty($BlockNo)) $ErrMsg = '所屬車位不可為空白\n';   
    if (empty($ErrMsg)) {   // 資料經初步檢核沒問題
    // Demo for XSS
    //    $Name = xssfix($Name);
    //    $Phone = xssfix($Phone);
    // Demo for the reason to use addslashes
        if (!get_magic_quotes_gpc()) {            
            $Topic = addslashes($Topic);   
            $BlockNo = addslashes($BlockNo); 			
        }		
        $sqlcmd="UPDATE nodemcu SET topic='$Topic',blockno='$BlockNo' WHERE seqno='$seqno'";            
        $result = updatedb($sqlcmd, $db_conn);
        header("Location: nodemcu.php");
        exit();
    }
}
if (!isset($Topic)) {    
// 此處是在contactlist.php點選後進到這支程式，因此要由資料表將欲編輯的資料列調出
    $sqlcmd = "SELECT * FROM nodemcu WHERE seqno='$seqno'";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) <= 0) die('No data found');      // 找不到資料，正常應該不會發生
	$ChipID = $rs[0]['chipid'];
    $Topic = $rs[0]['topic'];
    $BlockNo = $rs[0]['blockno'];        
} else {    // 點選送出後，程式發現有錯誤
// Demo for stripslashes
    if (get_magic_quotes_gpc()) {
        $ChipID = stripslashes($ChipID);
        $Topic = stripslashes($Topic);
        $BlockNo = stripslashes($BlockNo);        
    }
}
?>
<html>
	<head>
		<title>NodeMcu修改</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<link rel="stylesheet" href="css/main.css" />
	</head>
	<body id="top">
    <div style="text-align:center;margin-top:5px;font-size:20px;font-weight:bold;">
    NodeMcu</div>
	<div align="center">
	<div align="text-align:center">
	<form action="" method="post" name="inputform">
	<input type="hidden" name="seqno" value="<?php echo $seqno ?>">
	<b>修改NodeMcu資料</b>
	<table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">

	<tr height="30">
	  <th>Topic:</th>
	  <td><input type="text" name="Topic" value="<?php echo $Topic ?>" size="20"></td>
	</tr>
	<tr height="30">
	  <th>BlockNo:</th>
	  <td><input type="text" name="BlockNo" value="<?php echo $BlockNo ?>" size="50"></td>
	</tr>    	
	</table>
	<input type="submit" name="Confirm" value="存檔送出">&nbsp;
	<input type="submit" name="Abort" value="放棄修改">
	<?php if (!empty($ErrMsg)) echo '<br />' . '<font color="RED">'.$ErrMsg.'</font>'; ?>
	</form>
	</div>
			<!-- Scripts -->
			<script src="js/jquery.min.js"></script>
			<script src="js/jquery.poptrox.min.js"></script>
			<script src="js/skel.min.js"></script>
			<script src="js/main.js"></script>

	</body>
</html>