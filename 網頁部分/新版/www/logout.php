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
?>
<html>
<script type="text/javascript">
<!--
  location="index.php"
-->
</script>
<body bgcolor="#ffffdd">
<div style="text-align:center;"> 
<h2>已登出</h2>
</div>
<?php
session_start();
session_unset();
session_destroy();
?>
</body>
</html>