<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style.css">
<title>使用者註冊</title>
</head>    
<body>
<?php
session_start();
$link=@mysqli_connect('localhost:33060','root','root','booktrades');
mysqli_query($link,'SET CHARACTER SET utf8');
$currentDate = date("Y-m-d");
echo "
<br>
<table align=center border=1 >
<td>
<form method='post' name='register' action='register.php' enctype=multipart/form-data accept-charset=UTF-8>
使用者帳號:<input type='text' name='account' placeholder='請輸入您的帳號' required><br>
使用者密碼:<input type='password' id=password name='password' value='" . (isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '') . "' placeholder='請輸入密碼' required>";
echo "<input type='checkbox' id='showpassword'>顯示密碼<br>";
echo"
使用者名字:<input type='name' id =name name='name' value='" . (isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '') . "' placeholder='請輸入名字' required>
<br>
使用者性別: 
<input type='radio' name='sex' value='男'>男性
<input type='radio' name='sex' value='女'>女性
<br>
使用者電話:<input type='tel' name='phone' value='" . (isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '') . "' placeholder='請輸入您的電話' required><br>
使用者地址 : <input type='address' name='address' value='" . (isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '') . "' placeholder='請輸入您的郵件' required><br>
會員電子郵件 : <input type='email' name='email' value='" . (isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '') . "' placeholder='請輸入您的郵件' required><br>
使用者生日 :<input type='date' value='$currentDate' min='2022-01-01' max='9999-12-31' step='1' name='birthday'><br>
<input type='submit' name='button' value='註冊'>

</form>

";
echo "密碼長度必須至少為8個字符包含至少一個大寫字母,<br>一個小寫字母至少一個數字，至少一個特殊字符。";
echo "
<form  method=post action=login.php>
<input type=submit name=button value=回登入畫面>
</form>
</td>
";
        if(isset($_POST['account']) && isset($_POST['password']))
        {
            $account = $_POST['account'];
            $account = mysqli_real_escape_string($link,$account);
            $password = $_POST['password'];
            $password = mysqli_real_escape_string($link,$password);
            $name = $_POST['name'];
            $name = mysqli_real_escape_string($link,$name);
            $sex = $_POST['sex'];
            $sex = mysqli_real_escape_string($link,$sex);
            $phone = $_POST['phone'];
            $phone = mysqli_real_escape_string($link,$phone);
            $email = $_POST['email'];
            $email = mysqli_real_escape_string($link,$email);
            $address = $_POST['address'];
            $address = mysqli_real_escape_string($link,$address);
            $birthday = $_POST['birthday'];
            $birthday = mysqli_real_escape_string($link,$birthday);
            $status='0';
            $authority = '5';
        
           
            //$date = date("Y-m-d");
            //註冊
            if(isset($_POST['button']))
            {
                if($_POST['button']=='註冊')
                {
                    if(!empty($account) && !empty($password))
                    {
                        $sql1 = "SELECT * FROM `users` WHERE `account`=?";
                        $stmt1 = mysqli_prepare($link, $sql1);
        
                        if ($stmt1)
                        {
                            // 綁定參數
                            mysqli_stmt_bind_param($stmt1, "s", $account);
        
                            // 執行查詢
                            mysqli_stmt_execute($stmt1);
                            mysqli_stmt_store_result($stmt1);
        
                            // 確認是否已經有相同的帳號存在
                            if (mysqli_stmt_num_rows($stmt1) > 0)
                            {
                                echo "<script>alert('名稱已被使用')</script>";
                            }
                            else
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
                                    // 電話號碼符合格式，執行相應的處理
                                    $sql_insert = "INSERT INTO `users` (account, password,name,sex,birthday,phone,address, email,status,authority) VALUES (?, ?, ?, ?, ?, ?,?,?,?,?)";
                                    $stmt2 = mysqli_prepare($link, $sql_insert);
        
                                    if ($stmt2)
                                    {
                                        // 綁定參數
                                        mysqli_stmt_bind_param($stmt2, "ssssssssss", $account, $password,$name,$sex,$birthday,$phone,$email, $birthday, $status,$authority);
        
                                        // 執行新增使用者
                                        mysqli_stmt_execute($stmt2);
        
                                        if (mysqli_affected_rows($link) > 0)
                                        {
                                            echo "<script>alert('新增成功')</script>";
                                            header('Refresh:1,login.php');
                                        }
                                    }
                                    else
                                    {
                                        echo "<script>alert('註冊失敗，請稍後再試')</script>";
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo "<script>alert('註冊失敗，請稍後再試')</script>";
                        }
                    }
                    else 
                    {
                        header('Refresh:1,register.php');
                        echo "<script>alert('註冊失敗，帳號或密碼不得為空')</script>"; 
                    }         
                }
            }
        }
        
?>
<script type="text/javascript">
    var passwordField = document.getElementById('password');
    var showPasswordCheckbox = document.getElementById('showpassword');
    
    showPasswordCheckbox.addEventListener('change', function() 
    {
        if (showPasswordCheckbox.checked) 
        {
            passwordField.type = 'text';
        } 
        else 
        {
            passwordField.type = 'password';
        }
    });
</script>
</body>
</html>