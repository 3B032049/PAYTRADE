<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>重設密碼</title>
</head>    
<body>
<font color="red">
<?php 
   {
    session_start();  // 啟用交談期
// 檢查Session變數是否存在, 表示是否已成功登入
    if (!isset($_SESSION["reset"]) || $_SESSION["reset"] != true)
    {
        echo "<script>alert('連結已使用，請到忘記密碼獲取新連結'); setTimeout(function() { window.location.href = 'contact.php'; }, 1000);</script>";
    }
    else
    {
        $link=@mysqli_connect('localhost:33060','root','root','booktrades');
        mysqli_query($link,'SET CHARACTER SET utf8');
        echo "
        <form  method=post action=reset.php>
        請輸入密碼:<input type=password name=password><br>
        請輸入確認密碼:<input type=password name=password1> <br>
        <input type=submit name=button value=確認>
        </form>
        ";
        if(isset($_POST["password"]) && isset($_POST["password1"]))
        {
            $account = $_SESSION['account'];
            $account = mysqli_real_escape_string($link, $account);
            $password = $_POST['password'];
            $password = mysqli_real_escape_string($link, $password);
            $password1 = $_POST['password1'];
            $password1 = mysqli_real_escape_string($link, $password1);
        
            if ($password == $password1)
            {
                // 驗證密碼強度                     
                // Validate password strength
                $uppercase = preg_match('@[A-Z]@', $password);
                $lowercase = preg_match('@[a-z]@', $password);
                $number = preg_match('@[0-9]@', $password);
                $specialChars = preg_match('@[^\w]@', $password);
        
                if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) 
                {
                    echo "<script>alert('密碼長度至少為 8 個字符，且至少包含 1 個大寫字母、小寫字母，1 個數字和 1 個特殊字符')</script>";
                }
                else
                {
                    // 使用參數化查詢更新密碼
                    $sql_update = "UPDATE `users` SET `password`=? WHERE `account`=?";
                    $stmt = mysqli_prepare($link, $sql_update);
        
                    if ($stmt)
                    {
                        // 綁定參數
                        mysqli_stmt_bind_param($stmt, "ss", $password, $account);
        
                        // 執行查詢
                        mysqli_stmt_execute($stmt);
        
                        // 確認影響的行數
                        if (mysqli_stmt_affected_rows($stmt) > 0)
                        {
                            echo "<script>alert('修改成功')</script>";
                            header('Refresh:1,login.php');
                            session_destroy();
                        }
                        else
                        {
                            echo "<script>alert('請輸入跟舊密碼不同的密碼')</script>";
                        }
        
                        // 關閉準備語句
                        mysqli_stmt_close($stmt);
                    }
                }
            }
            else
            {
                echo "<script>alert('修改失敗，密碼不一致，請重新輸入密碼')</script>";
            }
        }        
    }
}

?>
</body>
</html>