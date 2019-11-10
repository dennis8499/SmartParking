<?php
require_once("include/configure.php");
require_once("include/db_func.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

if (!isset($ItemPerPage)) $ItemPerPage = 2;
$PageTitle = '停車場資訊系統';
$sqlcmd = "SELECT count(*) AS reccount FROM parking WHERE type='parking'";
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

$sqlcmd = "SELECT * FROM parking WHERE type='parking' LIMIT $StartRec,$ItemPerPage ";
$Contacts = querydb($sqlcmd, $db_conn);
$PrevPage = $NextPage = '';
if ($TotalPage > 1) {
    if ($Page>1) $PrevPage = $Page - 1;
    if ($Page<$TotalPage) $NextPage = $Page + 1;   
}
$PrevLink = $NextLink = '';
if (!empty($PrevPage)) 
    $PrevLink = '<a href="parking.php?Page=' . $PrevPage . '">上一頁</a>';
if (!empty($NextPage)) 
    $NextLink = '<a href="parking.php?Page=' . $NextPage . '">下一頁</a>';

?>
<html>
	<head>
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<title>停車場狀態</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
			<link rel="stylesheet" href="css/main.css" />
	</head>
	<body>
	  <div id="wrapper">
		<!-- Header -->
			<header id="header">
				<h1>停車場狀態</h1>
					<ul class="icons">
						<li><a href="map.php" class="icon style2 fa-map" target="view_window"></a></li>	
						<li><a href="index.php" class="icon style2 " >返回</a></li>						
					</ul>
			</header>
			
        <section id = "main">
		<div style="text-align:center;margin:0;font-size:20px;font-weight:bold;">停車格表</div>

	</div>
	<div style="text-align:center;">
	<table class="mistab" width="90%" align="center">
	<tr>
	  <th width="15%">處理</th>	 
	  <th width="15%">Name</th>
	  <th width="30%">Address</th>
	  <th width="15%">Html</th>
      <th width="15%">空間數</th>  	  
      <th width="15%">查看狀態</th>	  
	</tr>
	<?php
	foreach ($Contacts AS $item) {
      $seqno = $item['seqno'];		
	  $name = $item['name'];
	  $address = $item['address'];
	  $html = $item['html'];	 	  
	  $State = $item['parkid'];
	  $noofblocks = $item['noofblocks'];
	?>
	<tr align="center">
	  <td>	
	  <a href="map.php"  target="view_window">
	  查看地圖</a>&nbsp;	   	  
	  </td>   	  	   
	  <td><?php echo $name ?></td>
	  <td><?php echo $address ?></td>
	  <td><a href=<?php echo $html?>><?php echo $html?></td>
	  <td><?php echo $noofblocks ?></td>
      <td><a href=<?php echo $State.".php"?>  target="view_window">狀態</td>	  
	</tr>
	<?php
	}
	?>
    </table>	
	</div>
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
          </section> 		
				<!-- Scripts -->
			<script src="js/jquery.min.js"></script>
			<script src="js/jquery.poptrox.min.js"></script>
			<script src="js/skel.min.js"></script>
			<script src="js/main.js"></script>

	</body>
</html>