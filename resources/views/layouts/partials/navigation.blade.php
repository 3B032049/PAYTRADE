<header class="page-header bg-gray">
    <nav>
        <ul class="nav-list nav-left">
            <li class="nav-item col-lg-9"><a href="{{ url('/') }}" style="color: black;">二手書拍賣平台</a></li>
            <li class="nav-item"><a href='announce.php' style="color: black;">最新公告</a></li>
            <li class="nav-item"><a href="mailto:3b032007@gm.student.ncut.edu.tw" style="color: black;">聯絡我們</a></li>
            @guest
                @if (Route::has('login'))
                    <li class="nav-item"><a href="{{ route('login') }}">{{ __('登入') }}</a></li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-item"><a href="{{ route('register') }}">{{ __('註冊') }}</a></li>
                @endif
            @else
                <ul class="nav-item dropdown">
                    <li>
                        <ul class="dropdown-toggle">{{ Auth::user()->name }}</ul>
                        <ul class="dropdown-content">
                            <a class="dropdown-item" href="{{ route('logout') }}" 
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('登出') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </li>
                </ul>
            @endguest
        </ul>
    </nav>
</header>