<?php 
// Authentication 認證
require_once("include/auth.php");
// 變數及函式處理，請注意其順序
require_once("include/gpsvars.php");
require_once("include/configure.php");
require_once("include/db_func.php");
require_once("include/aux_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$sqlcmd = "SELECT * FROM user WHERE loginid='$LoginID' AND valid='Y'";
$rs = querydb($sqlcmd, $db_conn);
if (count($rs) <= 0) die ('Unknown or invalid user!');

$sqlcmd = "SELECT * FROM user WHERE loginid='$LoginID' AND valid='Y'";
$Contacts = querydb($sqlcmd, $db_conn);
foreach ($Contacts AS $item) {
  $seqno = $item['seqno'];
  $Uid = $item['loginid'];
  $Nickname = $item['nickname'];
  $Lpn = $item['lpn'];
  $CurrentLot = $item['currentlot'];
  $CurrentBlock = $item['currentblock'];
}
?>
<html>
<script type="text/javascript">
<!--
function startload() {
    var Ary = document.ULFile.userfile.value.split('\\');
    document.ULFile.fname.value=Ary[Ary.length-1];
    document.ULFile.orgfn.value=document.ULFile.userfile.value
    document.forms['ULFile'].submit();
    return true;
}
-->
</script>
	<head>
		<title>選單</title>
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
				<h1><a href="#">Menu</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="map.php" target="view_window">Map</a></li>					
						<li><a href="setting.php?seqno=<?php echo $seqno;?>">Setting</a></li>
						<li><a href="logout.php">LogOut</a></li>						
					</ul>
				</nav>
			</header>			
			<input type="hidden" name="MAX_FILE_SIZE" value="102497152">
			<input type="hidden" name="seqno" value="<?php echo $seqno; ?>">
			<input type="hidden" name="GoUpload" value="1">
			<input type="hidden" name="fname">
			<input type="hidden" name="orgfn">			
		<div align="center">
		<table class="mistab" width="90%" align="center">
		  <tr align="center">
			<b>
			  <th width="15%">用戶名</th>
			  <th width="15%">暱稱</th>
			  <th width="15%">車牌</th>
			  <th width="15%">所在停車場</th>
			  <th width="15%">停車格位置</th>
			</b>
		  </tr>
		
		<tr align="center">
		<td><?php echo $Uid ?></td>  
		<td><?php echo $Nickname ?></td>  
		<td><?php echo $Lpn ?></td>
		<td><?php echo $CurrentLot ?></td>	
		<td><?php echo $CurrentBlock ?></td>
		</tr>
		</table>
		<div class="container">					
			<hr class="major" />
				<div class="row">
					<div class="4u">
						<section class="special">
							<a href="map.php" target="view_window">
							<input type="button"  value="地圖">
							</a>
						</section>
					</div>
					<div class="4u">
						<section class="special">
							<a href="setting.php?seqno=<?php echo $seqno; ?>">
							<input type="button"  value="設定">
							</a>
						</section>
					</div>
					<div class="4u">
						<section class="special">
							<a href="logout.php">
							<input type="button"  value="登出">
							</a>
						</section>
					</div>
				</div>
		</div>
	</body>
</html>