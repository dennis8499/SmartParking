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
    // Invalid this item
	$sqlcmd = "SELECT * FROM parkingblock WHERE seqno='$seqno' AND valid='Y'";
	$rs = querydb($sqlcmd, $db_conn);
	if (count($rs) > 0) {
		$sqlcmd = "delete from parkingblock WHERE seqno='$seqno'";
		$result = querydb($sqlcmd, $db_conn);
	}	
}
if (isset($action) && $action=='recover' && isset($seqno)) {
    // Recover this item
    $sqlcmd = "SELECT * FROM parkingblock WHERE seqno='$seqno' AND valid='Y' AND nodemcustate='N'";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) > 0) {
        $sqlcmd = "UPDATE parkingblock SET nodemcustate='Y' WHERE seqno='$seqno'";
        $result = updatedb($sqlcmd, $db_conn);
    }
}

if (isset($action) && $action=='change' && isset($seqno)) {
    // Invalid this item
	$sqlcmd = "SELECT * FROM parkingblock WHERE seqno='$seqno' AND valid='Y' AND nodemcustate='Y'";
	$rs = querydb($sqlcmd, $db_conn);
	if (count($rs) > 0) {
		$sqlcmd = "UPDATE parkingblock SET nodemcustate='N' WHERE seqno='$seqno'";
		$result = querydb($sqlcmd, $db_conn);
	}
}
if (!isset($ItemPerPage)) $ItemPerPage = 2;
$PageTitle = '停車格資訊系統';
$sqlcmd = "SELECT count(*) AS reccount FROM parkingblock";
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

$sqlcmd = "SELECT * FROM parkingblock LIMIT $StartRec,$ItemPerPage";
$Contacts = querydb($sqlcmd, $db_conn);
$PrevPage = $NextPage = '';
if ($TotalPage > 1) {
    if ($Page>1) $PrevPage = $Page - 1;
    if ($Page<$TotalPage) $NextPage = $Page + 1;   
}
$PrevLink = $NextLink = '';
if (!empty($PrevPage)) 
    $PrevLink = '<a href="parkingblock.php?Page=' . $PrevPage . '">上一頁</a>';
if (!empty($NextPage)) 
    $NextLink = '<a href="parkingblock.php?Page=' . $NextPage . '">下一頁</a>';

?>
<html>
	<head>
		<title>停車格資訊系統</title>
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
	<!-- Header -->
			<header id="header" class="skel-layers-fixed">
				<h1><a href="#">停車格資料</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="contactlist.php">Home</a></li>
						<li><a href="nodemcu.php">Nodemcu</a></li>
						<li><a href="owner.php">Owner</a></li>
						<li><a href="contactlist.php">Member</a></li>
						<li><a href="parking.php">Parking</a></li>
					</ul>
				</nav>
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
	<div style="text-align:center;margin:0;font-size:20px;font-weight:bold;">
	 停車格表</div>
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
		<a href="parkingblockadd.php">新增</a>&nbsp;		
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
	  <th width="15%">BlockID</th>
	  <th width="15%">CurrentUser</th>
	  <th width="30%">Time</th>
	  <th width="15%">NodeMcuState</th>      	 	  
	</tr>
	<?php
	foreach ($Contacts AS $item) {
	  $seqno = $item['seqno'];
	  $BlockID = $item['blockid'];
	  $CurrentUser = $item['currentuser'];
	  $Time = $item['time'];
      $NodeMcuState = $item['nodemcustate']; 	  
	  $Valid = $item['valid'];
	  $DspMsg = "'確定刪除項目?'";
	  $DspMsg2 = "'確定停止使用?'";
	  $PassArg = "'parkingblock.php?action=delete&seqno=$seqno'";
	  $PassArg2 = "'parkingblock.php?action=change&seqno=$seqno'";
	?>
	<tr align="center">
	  <td>
	<?php
	  if ($NodeMcuState=='N') {
	?>
      <a href="parkingblock.php?action=recover&seqno=<?php echo $seqno; ?>">
	  回復</a></td>
	  <!--<td><STRIKE><?php echo $BlockID ?></STRIKE></td>	-->
	<?php } else { ?>
	  <a href="javascript:confirmation(<?php echo $DspMsg ?>, <?php echo $PassArg ?>)">
	  作廢</a>&nbsp;
	  <a href="parkingblockmod.php?seqno=<?php echo $seqno; ?>">
	  修改</a>&nbsp;
      <a href="javascript:confirmation(<?php echo $DspMsg2 ?>, <?php echo $PassArg2 ?>)">
	  停用</a>	  
	  </td>	    
	<?php } ?>
	  <td><?php echo $seqno ?></td>  
	  <td><?php echo $BlockID ?></td>
	  <td><?php echo $CurrentUser ?></td>
	  <td><?php echo $Time?></td>
	  <td><?php echo $NodeMcuState ?></td>      	  
	</tr>
	<?php
	}
	?>
    </table>	
	</div>
	<?php 
	$_SESSION['ProgID'] = 'parkingblock.php';
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

	</body>
</html>