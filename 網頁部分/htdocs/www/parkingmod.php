<?php
// 使用者點選放棄修改按鈕
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
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
// 確認參數是否正確
if (!isset($seqno)) die ("Parameter error!");
// 找出此用戶的群組
$sqlcmd = "SELECT * FROM user WHERE loginid='$LoginID' AND valid='Y'";
$rs = querydb($sqlcmd, $db_conn);
if (count($rs) <= 0) die ('Unknown or invalid user!');

// 處理使用者異動之資料
if (isset($Confirm)) {   // 確認按鈕
    if (!isset($ParkID) || empty($ParkID)) $ErrMsg = '停車場代號不可為空白\n';
    if (!isset($Name) || empty($Name)) $ErrMsg = '停車場名稱不可為空白\n';
    if (!isset($Address) || empty($Address)) $ErrMsg = '地址不可為空白\n';
    if (!isset($HeightLimit) || empty($HeightLimit)) $ErrMsg = '限高不可為空白\n';
    if (!isset($GpsLocation) || empty($GpsLocation)) $ErrMsg = 'GPS位置不可為空白\n';
    if (!isset($NoOfBlocks) || empty($NoOfBlocks)) $ErrMsg = '車位數不可為空白\n';		
    if (empty($ErrMsg)) {   // 資料經初步檢核沒問題
    // Demo for XSS
    //    $Name = xssfix($Name);
    //    $Phone = xssfix($Phone);
    // Demo for the reason to use addslashes
        if (!get_magic_quotes_gpc()) {
            $ParkID = addslashes($ParkID);
            $Name = addslashes($Name);   
            $Address = addslashes($Address); 
            $HeightLimit = addslashes($HeightLimit);
            $GpsLocation = addslashes($GpsLocation);   
            $NoOfBlocks = addslashes($NoOfBlocks);			
        }		
        $sqlcmd="UPDATE parking SET parkid='$ParkID',name='$Name', address='$Address', heightlimit='$HeightLimit', gpslocation='$GpsLocation', noofblocks='$NoOfBlocks' WHERE seqno='$seqno'";            
        $result = updatedb($sqlcmd, $db_conn);
        header("Location: parking.php");
        exit();
    }
}
if (!isset($Nickname)) {    
// 此處是在contactlist.php點選後進到這支程式，因此要由資料表將欲編輯的資料列調出
    $sqlcmd = "SELECT * FROM parking WHERE seqno='$seqno'";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) <= 0) die('No data found');      // 找不到資料，正常應該不會發生
	$ParkID = $rs[0]['parkid'];
    $Name = $rs[0]['name'];
    $Address = $rs[0]['address'];
    $HeightLimit = $rs[0]['heightlimit'];
    $GpsLocation = $rs[0]['gpslocation'];
    $NoOfBlocks = $rs[0]['noofblocks'];   
} else {    // 點選送出後，程式發現有錯誤
// Demo for stripslashes
    if (get_magic_quotes_gpc()) {
        $ParkID = stripslashes($ParkID);
        $Name = stripslashes($Name);
        $Address = stripslashes($Address);
        $HeightLimit = stripslashes($HeightLimit);
        $GpsLocation = stripslashes($GpsLocation);
        $NoOfBlocks = stripslashes($NoOfBlocks);         
    }
}
?>
<html>
	<head>
		<title>停車場修改</title>
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
    停車場修改</div>
	<div align="center">
	<div align="text-align:center">
	<form action="" method="post" name="inputform">
	<input type="hidden" name="seqno" value="<?php echo $seqno ?>">
	<b>修改停車場資料</b>
	<table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">
	<tr height="30">
	  <th width="40%">停車場代號：</th>	
      <td><input type="text" name="ParkID" value="<?php echo $ParkID ?>" size="20"></td>
	</tr>	
	<tr height="30">
	  <th>停車場名稱：</th>
	  <td><input type="text" name="Name" value="<?php echo $Name ?>" size="20"></td>
	</tr>
	<tr height="30">
	  <th>地址:</th>
	  <td><input type="text" name="Address" value="<?php echo $Address ?>" size="50"></td>
	</tr>
    <tr height="30">
	  <th>限高:</th>
	  <td><input type="text" name="HeightLimit" value="<?php echo $HeightLimit ?>" size="50"></td>
	</tr>
    <tr height="30">
	  <th>GPS:</th>
	  <td><input type="text" name="GpsLocation" value="<?php echo $GpsLocation ?>" size="20"></td>
	</tr>
	<tr height="30">
	  <th>剩餘車位:</th>
	  <td><input type="text" name="NoOfBlocks" value="<?php echo $NoOfBlocks ?>" size="50"></td>
	</tr>    	
	</table>
	<input type="submit" name="Confirm" value="存檔送出">&nbsp;
	<input type="submit" name="Abort" value="放棄修改">
	</form>
	</div>
	</body>
</html>