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
}
?>
<html>
	<head>
		<title>Setting</title>
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
				<h1><a href="menu.php">Menu</a></h1>
				<nav id="nav">
					<ul>						
						<li><a href="settingProfile.php?seqno=<?php echo $seqno; ?>">settingProfile</a></li>
						<li><a href="settingImage.php?seqno=<?php echo $seqno; ?>">SettingImage</a></li>
						<li><a href="menu.php">Return</a></li>						
					</ul>
				</nav>
			</header>
		<!-- Main -->
			<section id="main" class="wrapper style1">				
				<div class="container">	
					<div class="row">
						<div class="4u">
							<section class="special">
								<a href="settingProfile.php?seqno=<?php echo $seqno; ?>">
								<input type="button"  value="settingProfile">
								</a>
							</section>
						</div>
						<div class="4u">
							<section class="special">
								<a href="settingImage.php?seqno=<?php echo $seqno; ?>">
								<input type="button"  value="更改頭像">
								</a>
							</section>
						</div>
						<div class="4u">
							<section class="special">
							<a href="menu.php">
							<input type="button"  value="返回">
							</a>
							</section>
						</div>
					</div>
				</div>
			</section>		

	</body>
</html>