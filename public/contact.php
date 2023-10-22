<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>忘記密碼</title>
</head>    
<body>   
<table align=center border=1 >
<td>
    <form id="form1" name="form1" method="post" action="contact.php">
    <fieldset>

    <label>您的帳號：</label>
    <input id="name" name="name" type="text" placeholder=請輸入您的帳號 required/>
    <br />
    <label>您的Email：</label>
    <input id="email" name="email" type="email" placeholder=請輸入您的郵件 required/>
    <br />

    <input id="submit" name="submit" type="submit" value="確定送出" />
    </fieldset>
    </form>
    <form  method=post action=login.php>
    <input type=submit name=button value=回登入畫面>
    </form>
</td>
</table>
    <?php
    $link = @mysqli_connect('localhost:33060', 'root', 'root', 'booktrades');
    mysqli_query($link, 'SET CHARACTER SET utf8');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once('C:/wagon/uwamp/www/PHPMailer-master/src/PHPMailer.php');
    require_once('C:/wagon/uwamp/www/PHPMailer-master/src/Exception.php');
    require_once('C:/wagon/uwamp/www/PHPMailer-master/src/SMTP.php');
   session_start();
   if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
   {
    
    $sendemail = $_POST['email'];
    $sendemail = mysqli_real_escape_string($link,$sendemail);
    $account = $_POST['name'];
    $account = mysqli_real_escape_string($link, $account);

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Port = 465;
    $mail->CharSet = "utf-8";
    $mail->Username = "paytrade2000@gmail.com";
    $mail->Password = "fvhijqpbhudhquer";
    $mail->From = "$sendemail";
    $mail->Subject = "密碼重設信";
    $linkText = "點擊這裡";
    $url = "http://localhost:8000/reset.php";
    $mail->Body = "請"."<a href='$url'>$linkText</a>"."來重設密碼";
    $mail->IsHTML(true);
    $mail->AddAddress("$sendemail");

    

    $sql = "SELECT * FROM `users` WHERE account=? AND email=?";
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt) 
    {
        // 綁定參數
        mysqli_stmt_bind_param($stmt, "ss", $account, $sendemail);

        // 執行查詢
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {

            if (!$mail->Send()) 
            {
                echo "Error: " . $mail->ErrorInfo;
            } 
            else 
            {
                echo "<script>alert('郵件已送出，請到信箱重設密碼。');</script>";
                $_SESSION["reset"] = true;
                $_SESSION["account"] = "$account";
            }
        } 
        else 
        {
            echo "<script>alert('帳號不存在或是郵件錯誤')</script>";
        }

        // 關閉準備語句
        mysqli_stmt_close($stmt);
    }
}

?>
</body>
</html>