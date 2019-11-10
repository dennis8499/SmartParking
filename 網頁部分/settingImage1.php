<?php
if (isset($_POST['Abort'])) {
    header("Location: setting.php");
    exit();
}    
// Authentication 認證
require_once("include/auth.php");
// 變數及函式處理，請注意其順序
require_once("include/gpsvars.php");
require_once("include/configure.php");
require_once("include/db_func.php");
require_once("include/aux_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
?>
<script type="text/javascript">
</script>
<html>
<head>    
    <title>Settin Image</title>
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
    <header id="header" class="skel-layers-fixed">
				<h1><a href="menu.php">Menu</a></h1>
				<nav id="nav">
					<ul>												
						<li><a href="setting.php">Return</a></li>	
					</ul>
				</nav>
			</header>
<form action="doAction.php" method="post" enctype="multipart/form-data">
    <!-- 限制上傳檔案的最大值 -->
    <input type="hidden" name="MAX_FILE_SIZE" value="2097152">

	<div align="center">
    <!-- accept 限制上傳檔案類型 -->
    <input type="file" name="myFile" accept="image/jpeg,image/jpg,image/gif,image/png">

    <input type="submit" value="上傳檔案">
	<input type="submit" name="Abort" value="結束上傳">
	</div>
</form>

</body>
</html>