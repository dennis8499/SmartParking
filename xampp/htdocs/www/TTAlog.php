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


if (!isset($ItemPerPage)) $ItemPerPage = 2;
$PageTitle = 'TTALOG系統';
$sqlcmd = "SELECT count(*) AS reccount FROM ttalog";
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

$sqlcmd = "SELECT * FROM ttalog LIMIT $StartRec,$ItemPerPage";
$Contacts = querydb($sqlcmd, $db_conn);
$PrevPage = $NextPage = '';
if ($TotalPage > 1) {
    if ($Page>1) $PrevPage = $Page - 1;
    if ($Page<$TotalPage) $NextPage = $Page + 1;   
}
$PrevLink = $NextLink = '';
if (!empty($PrevPage)) 
    $PrevLink = '<a href="TTAlog.php?Page=' . $PrevPage . '">上一頁</a>';
if (!empty($NextPage)) 
    $NextLink = '<a href="TTAlog.php?Page=' . $NextPage . '">下一頁</a>';

?>
<html>
	<head>
		<title>TTALOG</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<link rel="stylesheet" href="css/main.css" />
	</head>
	<body id="top">	
	<!-- Header -->			
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
	 Log表</div>
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
	</tr>
	</table>	
	</div>
	
	<div style="text-align:center;">
	<table class="mistab" width="90%" align="center">
	<tr>
	  <th width="25%">ParkingID</th>
	  <th width="25%">Date</th>
	  <th width="25%">Time</th>
	  <th width="25%">Type</th>	   
	</tr>
	<?php
	foreach ($Contacts AS $item) {
	  $ParkingID = $item['parkingid'];
	  $Date = $item['date'];
	  $Time = $item['time'];
	  $Type = $item['type'];    
	?>
	<tr align="center">	 
	  <td><?php echo $ParkingID ?></td>
      <td><?php echo $Date ?></td>
	  <td><?php echo $Time ?></td>
	  <td><?php echo $Type?></td>      	  
	</tr>
	<?php
	}
	?>
    </table>	
	</div>
	<?php 
	$_SESSION['ProgID'] = 'TTAlog.php';
	?>
	</body>	
		<!-- Scripts -->
			<script src="js/jquery.min.js"></script>
			<script src="js/jquery.poptrox.min.js"></script>
			<script src="js/skel.min.js"></script>
			<script src="js/main.js"></script>

	</body>
</html>