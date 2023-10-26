<header class="page-header bg-gray">
    <nav>
        <ul class="nav-list nav-left">
            <li class="nav-item col-lg-9"><a href="{{ url('/') }}" style="color: black;">二手書拍賣平台</a></li>
            <li class="nav-item"><a href='announce.php' style="color: black;">最新公告</a></li>
            <li class="nav-item"><a href="mailto:3b032007@gm.student.ncut.edu.tw" style="color: black;">意見回饋</a></li>
                <?php
                    session_start();
                    if (isset($_SESSION["login_session"])) 
                    {
                        $accoumt=$_SESSION["account"];
                        if ($_SESSION["login_session"] != true) 
                        {
                            echo "<li class='nav-item'><a href='{{ route('login') }}'>登入</a></li>";
                        } 
                        else
                        {
                            if ($_SESSION["manager_login_session"] != true )
                            {
                                echo "<li class='nav-item'><a href='{{ route('user') }}'>會員</a></li>";
                                echo "<li class='nav-item'><a href='{{ route('user_info') }}'>個人資料</a></li>";
                                echo "<li class='nav-item'>$account<a href='{{ route('logout') }}'>登出</a></li>";
                            }
                            else
                            {
                                echo "<li class='nav-item'><a href='{{ route('manager') }}'>管理者</a></li>";
                                echo "<li class='nav-item'><a href='{{ route('logout') }}'>登出</a></li>";
                                
                            }
                        }   
                    } 
                    else 
                    {
                        echo "<li class='nav-item nav-right'><a href='{{ route('login') }}'>登入</a></li>";
                    }
                ?>
            </li>
            </div>
            
        </ul>
    </nav>
</header>