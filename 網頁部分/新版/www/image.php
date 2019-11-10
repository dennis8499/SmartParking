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
foreach ($rs AS $item) {
  $seqno = $item['seqno'];
  $Nickname = $item['nickname'];
}
?>
<html>
	<head>
		<title>Image</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />		
		<meta name="description" content="" />
		<meta name="keywords" content="" />		
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>		
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xsmall.css" />
		</noscript>
	</head>
	<body id="top">
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
	<input type="hidden" name="MAX_FILE_SIZE" value="102497152">
	<input type="hidden" name="seqno" value="<?php echo $seqno; ?>">
	<input type="hidden" name="GoUpload" value="1">
	<input type="hidden" name="fname">
	<input type="hidden" name="orgfn">
    <div align="center">
	<table border="1" width="40%" cellspacing="0" cellpadding="3" align="center">
	<tr>暱稱:<?php echo $Nickname;?></tr>
	<tr>
	<?php
	$filename = $AttachDir . '/' . str_pad($seqno, 8, '0', STR_PAD_LEFT) . '.jpg';
	if (file_exists($filename)) {
		$Tag = date('His');
	}?>
	<div style="text-align:center;margin-top:5px;">頭像
	<div style="margin:3px auto">
	<img src="getimage.php?ID=<?php echo $seqno; ?>&Tag=<?php echo $Tag; ?>" border="0" width="320">
	</div></div></tr></table>	
	<div align="center">	
	<tr>
	<?php
	$filename = $AttachDir . '/' . str_pad($seqno, 8, '0', STR_PAD_LEFT) . '.jpg';
	if (file_exists($filename)) {
		$Tag = date('His');
	}
	?>
	<div style="margin:3px auto">
	<img src="getimage.php?ID=<?php echo $seqno; ?>&Tag=<?php echo $Tag; ?>" border="0" width="320">
	</div></tr></table></div></div>
	</body>
</html>