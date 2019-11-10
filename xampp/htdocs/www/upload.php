<?php
if (isset($_POST['Abort'])) {
    header("Location: contactlist.php");
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
<?php
if (isset($GoUpload) && $GoUpload=='1') {
    $fname = $_FILES["userfile"]['name'];
    $ftype = $_FILES["userfile"]['type'];
    if ($_POST["fname"] <> $_POST["orgfn"]) $fname = $_POST["fname"];
    $fsize = $_FILES['userfile']['size'];
    if (!empty($fname) && addslashes($fname)==$fname && $fsize>0) {
        $uploadfile = "$AttachDir/" . str_pad($seqno,8,'0',STR_PAD_LEFT) . '.jpg';
        // 如果上傳的不是.jpg檔，怎麼辦！(自行思考對策)
        move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
        chmod ($uploadfile,0644); 
    } else {
        $ErrMsg = '<font color="Red">'
            . '檔案不存在、大小為0或超過上限(100MBytes)</font>';
    }
}
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<title>Settin Image</title>
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<link rel="stylesheet" href="css/main.css" />
	</head>
	
	<body id="top">		

		<!-- Main -->
			<section id="main" class="wrapper style1">
				<header class="major">					
					<p>人員編號<?php echo $seqno ?>附件檔案上傳</p>
				</header>
				<div class="container">
					<?php
					$filename = $AttachDir . '/' . str_pad($seqno, 8, '0', STR_PAD_LEFT) . '.jpg';
					if (file_exists($filename)) {
						$Tag = date('His');
					?>
					<div align="center">
						<section class="special">
						<img src="getimage.php?ID=<?php echo $seqno; ?>&Tag=<?php echo $Tag ?>" border="0" width="320">
						</section>
					</div>
					<?php }?>		
					<form enctype="multipart/form-data" method="post" action="" name="ULFile">					
					<input type="hidden" name="MAX_FILE_SIZE" value="102497152">
					<input type="hidden" name="seqno" value="<?php echo $seqno; ?>">
					<input type="hidden" name="GoUpload" value="1">
					<input type="hidden" name="fname">
					<input type="hidden" name="orgfn">
					<br />
					<div align="center">
					上傳檔名：<input name="userfile" type="file"> 					
					<input type="button" name="upload" value="上傳照片" onclick="startload()">
					<input type="submit" name="Abort" value="結束上傳">
					<?php if (!empty($ErrMsg)) echo '<br />' . '<font color="RED">'.$ErrMsg.'</font>'; ?>
					</div>
					</form>
				</div>						
			</section>
		<!-- Scripts -->
			<script src="js/jquery.min.js"></script>
			<script src="js/jquery.poptrox.min.js"></script>
			<script src="js/skel.min.js"></script>
			<script src="js/main.js"></script>
			
	</body>
</html>