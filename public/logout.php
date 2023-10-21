<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>使用者登出</title>
</head>    
<body>
<?php
session_start();
$_SESSION["login_session"] = false;
$_SESSION["manager_login_session"] = false;
echo "<script>alert('登出成功')</script>";
session_destroy();
header('Refresh:0,index1.php');
?>
</body>
</html>