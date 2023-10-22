<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>使用者登入</title>

</head>    
<body>
<?php
session_start();
    echo "
    <br>
    <table align=center border=1 >
    <form  method=post action=login.php>
    <td>
        使用者帳號:<input type=text name=account placeholder=請輸入您的帳號 required><br>
        使用者密碼:<input type=password name=password placeholder=請輸入您的密碼 required>
        <br>
        <input type=submit name=button value=使用者登入>
    </form> 
    <form  method=post action=register.php>
        還沒有帳號點擊這邊註冊<input type=submit name=button value=註冊>
    </form> 
    <form  method=post action=contact.php>
    <input type=submit name=button value=忘記密碼>
    </form>
    </td>
    ";
 //登入
 if(isset($_POST['button']))
{
    if($_POST['button']=='使用者登入')
    {
        if(isset($_POST['account']) && isset($_POST['password']))
        {
            $link = @mysqli_connect('localhost:33060', 'root', 'root', 'booktrades');
            mysqli_query($link, 'SET CHARACTER SET utf8');
            $account = $_POST['account'];
            $password = $_POST['password'];
            $account = mysqli_real_escape_string($link, $account);
            $password = mysqli_real_escape_string($link, $password);
            $_SESSION["account"] = $account;
            $sql = "SELECT * FROM `users` WHERE account=? AND password=?";
            $stmt = mysqli_prepare($link, $sql);

            if ($stmt)
            {
                // 綁定參數
                mysqli_stmt_bind_param($stmt, "ss", $account, $password);

                // 執行查詢
                mysqli_stmt_execute($stmt);

                // 獲取結果集
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0)
                {
                    while ($row = mysqli_fetch_assoc($result))
                    {
                        /*
                        $suspension_time = strtotime($row['suspension_time']);
                        $suspension_date = date("Y-m-d", $suspension_time);
                        $current_date = date("Y-m-d", time());

                        if ($suspension_date > $current_date)
                        {
                             //帳號停權處理
                            echo "<script>alert('此帳號目前已停權'); setTimeout(function() { window.location.href = 'login.php'; }, 1000);</script>";
                            exit;

                        }
                        else
                        {*/
                           if($row['authority']=='1' || $row['authority']=='2')
                           {
                            $_SESSION["login_session"] = true;
                            $_SESSION["account"]=$account;
                            $_SESSION["authority"] = '1';
                            $_SESSION["manager_login_session"] = true;
                           }
                           else
                           {
                            $_SESSION["login_session"] = true;
                            $_SESSION["manager_login_session"] = false;
                           }
                           echo "<script>alert('登入成功'); setTimeout(function() { window.location.href = 'index.php'; }, 1000);</script>";
                        
                    }
                }
                else
                {
                    echo "<script>alert('帳號或密碼錯誤')</script>";
                    //header('Refresh:1,login.php');
                }
            }
        }
    }
}

?>
</body>
</html>