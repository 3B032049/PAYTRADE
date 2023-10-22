<?php
echo "<form method=get style=text-align:center>";
echo "<a href='index.php'>回首頁</a><br><hr>";
session_start();
$link = @mysqli_connect('localhost:33060', 'root', 'root', 'booktrades');
mysqli_query($link, 'SET CHARACTER SET utf8');

//刪除帳號
if (isset($_GET['delete']))
{
    $id = $_SESSION['user_id'];
    $sql_delete = "DELETE FROM `users` WHERE user_id='$id'";
    mysqli_query($link, $sql_delete);
    if(mysqli_affected_rows($link) > 0)
    {
        echo "<script>alert('刪除成功！')</script>";
        header("Refresh:0; url=logout.php");
    }
}


if (isset($_GET['updateuser']))
{
    $_SESSION['updateuser'] = $_GET['updateuser'];
}
//編輯資料
if (isset($_SESSION['updateuser']))
{
    $id = $_SESSION['user_id'];

    if (isset($_GET['save']))
    {
        $acc = $_GET['acc'];
        $name = $_GET['name'];
        $sex = $_GET['sex'];
        $address = $_GET['address'];
        $bir = $_GET['bir'];
        $phone = $_GET['phone'];

        $sql_update = "UPDATE `users` SET `account`= '$acc',`name`= '$name',`sex`= '$sex',
        `address`= '$address',`birthday`= '$bir' ,`phone`= '$phone' WHERE user_id='$id'";
        mysqli_query($link,$sql_update);
        if(mysqli_affected_rows($link) > 0)
        {
            echo "<script>alert('修改成功！')</script>";
            unset($_SESSION['updateuser']);
            header("Refresh:0; url=reset_user.php");
        }
    }

    $sql_search = "SELECT * FROM users WHERE user_id='$id'";
    echo "<form method='get' style=text-align:center action='reset_user.php'>";
    if ($result = mysqli_query($link,$sql_search))
    {
        if (mysqli_num_rows($result) > 0)
        {
            echo "<table border='0' align='center'>";
            while ($row = mysqli_fetch_assoc($result))
            {
                if ($row <> null)
                {
                    echo "
                    <tr><td>編號：<input type=name style=width:180;border-style:none  readonly name='id' value='$row[user_id]'><br><br>
                    帳號：<input type=name style=width:180 name='acc' value='".$row["account"]."'><br><br>
                    姓名：<input type=name style=width:180 name=name value =".$row["name"]."><br><br>
                    使用者性別: 
                    <input type='radio' name='sex' value='男'>男性
                    <input type='radio' name='sex' value='女'>女性<br><br>
                    地址：<input type=name style=width:180 name=address value =".$row["address"]."><br><br>
                    生日：<input type=date style=width:180 name='bir' value='".$row["birthday"]."'><br><br>
                    電話：<input type=name style=width:180 name='phone' value='".$row["phone"]."'><br><br>
                    ";
                    echo "
                    <button style=width:230 name='save' type='submit'>儲存</button>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br><br>
                    <button style=width:230 type='submit' name='update_false'>取消</button></td>
                    <td style=vertical-align:text-top;>
                    修改密碼<br><br>
                    <input type='password' style=width:230 name='old' placeholder = 請輸入舊密碼><br><br>
                    <input type='password' style=width:230 name='new' placeholder = 請輸入新密碼><br><br>
                    <input type='password' style=width:230 name='renew' placeholder = 再次輸入新密碼><br><br>
                    <button style=width:230 name='update_pwd' value='".$row["user_id"]."' type='submit'>修改</button><br><br>                        
                    </td></tr>";
                }
                echo "</table>";
            }
            echo "</form>";
        }
    }
}
else
{
    $id = $_SESSION['user_id'];

    $sql_search = "SELECT * FROM users WHERE user_id='$id'";
    echo "<form method='get' style=text-align:center action='reset_user.php'>";
    if ($result = mysqli_query($link, $sql_search))
    {
        if (mysqli_num_rows($result) > 0)
        {
            echo "<table border='0' align='center'>";
            while ($row = mysqli_fetch_assoc($result))
            {
                if ($row <> null)
                {
                    echo "
                    <tr><td>編號：<input type=name style=width:180;border-style:none  readonly name='id' value='$row[user_id]'><br><br>
                    帳號：<input type=name style=width:180 readonly name='acc' value='".$row["account"]."'><br><br>
                    密碼：<input type=password style=width:180 readonly name='pwd' value='".$row["password"]."'><br><br>
                    姓名：<input type=name style=width:180 readonly name=name value =".$row["name"]."><br><br>
                    性別：<input type=name style=width:180 readonly name=sex value =".$row["sex"]."><br><br>
                    地址：<input type=name style=width:180 readonly name=address value =".$row["address"]."><br><br>
                    生日：<input type=date style=width:180 readonly name='bir' value='".$row["birthday"]."'><br><br>
                    電話：<input type=name style=width:180 readonly name='phone' value='".$row["phone"]."'><br><br>
                    ";
                    echo "
                    <button style=width:230 name='updateuser' value='".$row["user_id"]."' type='submit'>編輯</button>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br><br>
                    <a href=javascript:if(confirm('確定要刪除嗎?'))window.location='reset_user.php?delete=".$row['user_id']."' style=color:red;>刪除帳號</a></td>
                    <td style=vertical-align:text-top;>
                    修改密碼<br><br>
                    <input type='password' style=width:230 name='old' placeholder = 請輸入舊密碼><br><br>
                    <input type='password' style=width:230 name='new' placeholder = 請輸入新密碼><br><br>
                    <input type='password' style=width:230 name='renew' placeholder = 再次輸入新密碼><br><br>
                    <button style=width:230 name='update_pwd' value='".$row["user_id"]."' type='submit'>修改</button><br><br>                        
                    </td></tr>";
                }
            }
            echo "</table>";
        }
    }
    echo "</form>";
}
//取消編輯
if (isset($_GET['update_false']))
{
    unset($_SESSION['updateuser']);
    header("Refresh:0; url=reset_user.php");
}

//修改密碼
if(isset($_GET['update_pwd']))
{
    $id = $_GET['update_pwd'];
    $old = $_GET['old'];
    $new = $_GET['new'];
    $renew = $_GET['renew'];

    $sql_search = "SELECT * FROM users WHERE user_id='$id'";
    if ($result = mysqli_query($link, $sql_search))
    {
        if (mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                if ($row <> null)
                {
                    if($old != $row['password'])
                    {
                        echo "<script>alert('舊密碼不正確！')</script>";
                        header("Refresh:0; url=reset_user.php");
                    }
                    else if($new != $renew)
                    {
                        echo "<script>alert('密碼不相同！')</script>";
                        header("Refresh:0; url=reset_user.php");
                    }
                    else
                    {
                        $sql_update = "UPDATE `users` SET `password`= '$new' WHERE user_id='$id'";
                        mysqli_query($link,$sql_update);
                        if(mysqli_affected_rows($link) > 0)
                        {
                            echo "<script>alert('修改成功')</script>";
                            header("Refresh:0; url=reset_user.php");
                        }
                    }
                }
            }
        }
    }
}
?>

