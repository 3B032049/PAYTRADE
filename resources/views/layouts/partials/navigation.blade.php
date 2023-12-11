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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{ Auth::user()->name }} </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        @if (Auth::check() && Auth::user()->isSeller())
                            @if(Auth::User()->Seller->status=='1')
                                <li>
                                    <a class="dropdown-item" href="{{ route('home') }}" style="color:black">{{ __('進入賣家後台') }}</a>
                                </li>
                            @elseif(Auth::User()->Seller->status=='2')
                                <li>
                                    <a class="dropdown-item" href="{{ route('home') }}" style="color:black">{{ __('申請失敗') }}</a>
                                </li>
                            @elseif(Auth::User()->Seller->status=='3')
                                <li>
                                    <a class="dropdown-item" href="{{ route('home') }}" style="color:black">{{ __('申請中') }}</a>
                                </li>
                            @endif
                        @else
                            <li>
                                <a class="dropdown-item" href="{{ route('home') }}" style="color:black">{{ __('個人資料') }}</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('sellers.create') }}" style="color:black">{{ __('申請成為賣家') }}</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('home') }}" style="color:black">{{ __('訂購清單') }}</a>
                            </li>
                        @endif
                        @if (Auth::check() && Auth::user()->isAdmin())
                            <li>
                                <a class="dropdown-item" href="{{ route('admins.dashboard') }}" style="color:black">{{ __('後台管理') }}</a>
                            </li>
                        @endif
                        <li>
                            <hr class="dropdown-divider"/>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" style="color:black">{{ __('登出') }}</a>
                        </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </li>
            @endguest

        </ul>
        <a class="cart-container" href="{{ route('cart_items.index') }}">
            <img src="{{ asset('images/products/car.jpg') }}" width="30px" height="30px">
        </a>
    </nav>
</header>
