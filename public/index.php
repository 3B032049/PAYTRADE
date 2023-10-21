<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta viewport" content="width=device-width, initial-scale=1.0">
<title>首頁</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>    
<body>
<header class="page-header">
    <nav>
        <ul class="nav-list">
            <li class="nav-item"><a href='history.php' style="color: black;">書籍賣場</a></li>
            <li class="nav-item">

                <?php
                    session_start();

                    if (isset($_SESSION["login_session"])) 
                    {
                        if ($_SESSION["login_session"] != true) 
                        {
                            echo "<li class='nav-item'><a href='login.php' style='color:black'>登入</a></li>";
                        } 
                        else
                        {
                            if ($_SESSION["manager_login_session"] != true )
                            {
                                echo "<li class='nav-item'><a href='user.php' style='color: black'>會員</a></li>";
                                echo "<li class='nav-item'><a href='logout.php' style='color: black'>登出</a></li>";
                            }
                            else
                            {
                                echo "<li class='nav-item'><a href='manager.php' style='color: black'>管理者</a></li>";
                                echo "<li class='nav-item'><a href='logout.php' style='color: black'>登出</a></li>";
                                
                            }
                        }   
                    } 
                    else 
                    {
                        echo "<li class='nav-item'><a href='login.php' style='color: black'>登入</a></li>";
                    }
                ?>
               
            </li>
            <li class="nav-item"><a href="mailto:3b032007@gm.student.ncut.edu.tw" style="color: black;">聯絡我們</a></li>
            
            <li class="nav-item"><a href='announce.php' style="color: black;">最新公告</a></li>

        </ul>
    </nav>
</header>



   <section id="location">
    <div class="wrapper">
        <dic class ="location-info">
            <h3 class "sub-title">國立勤益科技大學</h3>
            <p>
                <h4>地址:411030台中市太平區中山路二段57號<h4>
                <h4>電話:0423924505<h4>
                <h4>營業時間:<h4>
                星期一08:00–22:00<br>
                星期二08:00–22:00<br>
                星期三08:00–22:00<br>
                星期四08:00–22:00<br>
                星期五08:00–22:00<br>
                星期六08:00–22:00<br>
                星期日08:00–22:00<br>
            </p>
        </div>
        <div class="location-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3640.7284829644823!2d120.73028387442099!3d24.146171673469148!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3469235d7fb2c4a7%3A0x1cc856130460088d!2z5ZyL56uL5Yuk55uK56eR5oqA5aSn5a24!5e0!3m2!1szh-TW!2stw!4v1697896941663!5m2!1szh-TW!2stw" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    </section>
</body>
<html>

