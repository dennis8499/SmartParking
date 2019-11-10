<?php
// Authentication 認證
require_once("include/auth.php");
// 變數及函式處理，請注意其順序
require_once("include/gpsvars.php");
require_once("include/configure.php");
require_once("include/db_func.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

//Using PDO
$sqlcmd = "SELECT * FROM user WHERE loginid=? AND valid='Y'";
$pdodb = $db_conn->prepare($sqlcmd);
$pdodb->bindParam(1, $LoginID, PDO::PARAM_STR, 12);
$pdodb->execute();
$rs = $pdodb->fetchAll();

if (count($rs) <= 0) die ('Unknown or invalid user!');

if (isset($action) && $action=='delete' && isset($seqno)) {
   
   $sqlcmd = "SELECT * FROM nodemcu WHERE seqno='$seqno' AND valid='Y'";
   $rs = querydb($sqlcmd, $db_conn);
   if (count($rs) > 0) {
		$sqlcmd = "delete FROM nodemcu WHERE seqno='$seqno'";
		$result = querydb($sqlcmd, $db_conn);
	}	
}

if (!isset($ItemPerPage)) $ItemPerPage = 2;
$PageTitle = 'NodeMcu';
$sqlcmd = "SELECT count(*) AS reccount FROM nodemcu";
$rs = querydb($sqlcmd, $db_conn);
$RecCount = $rs[0]['reccount'];
$TotalPage = (int) ceil($RecCount/$ItemPerPage);
if (!isset($Page)) {
    if (isset($_SESSION['CurPage'])) $Page = $_SESSION['CurPage'];
    else $Page = 1;
}
if ($Page > $TotalPage) $Page = $TotalPage;
$_SESSION['CurPage'] = $Page;
$StartRec = ($Page-1) * $ItemPerPage;

$sqlcmd = "SELECT * FROM nodemcu LIMIT $StartRec,$ItemPerPage";
$Contacts = querydb($sqlcmd, $db_conn);
$PrevPage = $NextPage = '';
if ($TotalPage > 1) {
    if ($Page>1) $PrevPage = $Page - 1;
    if ($Page<$TotalPage) $NextPage = $Page + 1;   
}
$PrevLink = $NextLink = '';
if (!empty($PrevPage)) 
    $PrevLink = '<a href="nodemcu.php?Page=' . $PrevPage . '">上一頁</a>';
if (!empty($NextPage)) 
    $NextLink = '<a href="nodemcu.php?Page=' . $NextPage . '">下一頁</a>';

?>
<html>
	<head>
		<title>Nodemcu資訊系統</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<link rel="stylesheet" href="css/main.css" />
	</head>
	<body id="top">	
	<!-- Header -->
			<header id="header" class="skel-layers-fixed">
				<h1><a href="#">Nodemcu資料</a></h1>
				
					<ul class="icons">
						<li><a href="index.php" class="icon style2 fa-home"></a></li>
						<li><a href="contactlist.php">Member</a></li>
						<li><a href="owner.php">Owner</a></li>
						<li><a href="parking.php">Parking</a></li>
						<li><a href="parkingblock.php">ParkingBlock</a></li>
					</ul>
				
			</header>	
    <script Language="javascript">
	<!--
	function confirmation(DspMsg, PassArg) {
	var name = confirm(DspMsg)
		if (name == true) {
		  location=PassArg;
		}
	}
	-->
	</script>
	<div style="text-align:center;margin:0;font-size:20px;font-weight:bold;"> Nodemcu資訊系統</div>
	<table border="0" width="90%" align="center" cellspacing="0" cellpadding="2">
	<tr>
	<td width="50%" align="left">
	<?php if ($TotalPage > 1) { ?>
	<form name="SelPage" method="POST" action="">
	<?php if (!empty($PrevLink)) echo $PrevLink . '&nbsp;'; ?>
	  第<select name="Page" onchange="submit();">
	<?php 
	for ($p=1; $p<=$TotalPage; $p++) { 
		echo '  <option value="' . $p . '"';
		if ($p == $Page) echo ' selected';
		echo ">$p</option>\n";
	}
	?>
	  </select>頁 共<?php echo $TotalPage ?>頁
	<?php if (!empty($NextLink)) echo '&nbsp;' . $NextLink; ?>
	</form>
	<?php } ?>
	  <td>
	  <td align="right" width="30%">
		<a href="nodemcuadd.php">新增</a>&nbsp;		
		<a href="logout.php">登出</a>
	  </td>
	</tr>
	</table>
	</div>
	<div style="text-align:center;">
	<table class="mistab" width="90%" align="center">
	<tr>
	  <th width="15%">處理</th>
	  <th width="15%">Seqno</th>
	  <th width="15%">ChipID</th>
	  <th width="15%">Topic</th>
	  <th width="15%">BlockNO</th>	  	  
	</tr>
	<?php
	foreach ($Contacts AS $item) {
	  $seqno = $item['seqno'];
	  $chipid = $item['chipid'];
	  $topic = $item['topic'];
	  $blockno = $item['blockno'];      
	  $valid = $item['valid'];
	  $DspMsg = "'確定刪除項目?'";
	  $PassArg = "'nodemcu.php?action=delete&seqno=$seqno'";
	?>
	<tr align="center">
	  <td>
	<?php
	  if ($valid=='N') {
	?>	 	  
	<?php } else { ?>
	  <a href="javascript:confirmation(<?php echo $DspMsg ?>, <?php echo $PassArg ?>)">
	  作廢</a>&nbsp;
	  <a href="nodemcumod.php?seqno=<?php echo $seqno; ?>">
	  修改</a>&nbsp;	 
	  </td>	    
	<?php } ?>
	  <td><?php echo $seqno ?></td>
	  <td><?php echo $chipid ?></td>  
	  <td><?php echo $topic ?></td>
	  <td><?php echo $blockno?></td>	        
	</tr>
	<?php
	}
	?>
    </table>	
	</div>
	<?php 
	$_SESSION['ProgID'] = 'nodemcu.php';
	?>
	</body>
	<script Language="javascript">
	<!--
	function confirmation(DspMsg, PassArg) {
	var name = confirm(DspMsg)
		if (name == true) {
		  location=PassArg;
		}
	}
	-->
	</script>	
			<!-- Scripts -->
			<script src="js/jquery.min.js"></script>
			<script src="js/jquery.poptrox.min.js"></script>
			<script src="js/skel.min.js"></script>
			<script src="js/main.js"></script>

	</body>
</html>