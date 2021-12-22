<div class="responsive-header">
    <div class="responsive-menubar">
        <div class="res-logo"><a href="index.html" title=""><img src="{{ asset('img/resource/logo.png') }}"
                    alt="" /></a></div>
        <div class="menu-resaction">
            <div class="res-openmenu">
                <img src="{{ asset('img/icon.png') }}" alt="" /> Menu
            </div>
            <div class="res-closemenu">
                <img src="{{ asset('img/icon2.png') }}" alt="" /> Close
            </div>
        </div>
    </div>
    <div class="responsive-opensec">
        <div class="btn-extars">
            @auth('user')
                <nav>
                    <ul>
                        <li class="menu-item-has-children">
                            @php
                                $name = Route::current()->getName();
                            @endphp
                            @if ($name == 'user.profile')
                                <a href="{{ route('user.profile') }}" title="">Profile</a>
                            @else
                                <a href="{{ route('user.profile') }}" title="">Profile</a>
                                <ul>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a href="">
                                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST">
                                                @csrf
                                                <button class="dropdown-item" type="submit">Logout</button>
                                            </form>
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        </li>
                </nav>
            @endauth
            @guest('user')
                <ul class="account-btns">
                    <li class="signup-popup"><a href="{{ route('user.show_register') }}" title=""><i class="la la-key"></i> Sign Up</a></li>
                    <li class="signin-popup"><a href="{{ route('user.choose_login') }}" title=""><i
                                class="la la-external-link-square"></i> Login</a></li>
                </ul>
            @endguest
        </div><!-- Btn Extras -->
        <form class="res-search">
            <input type="text" placeholder="Job title, keywords or company name" />
            <button type="submit"><i class="la la-search"></i></button>
        </form>
        <div class="responsivemenu">
            <ul>
                <li class="menu-item">
                    <a href="{{ route('user.home') }}" title="">Home</a>
                </li>
                <li class="menu-item">
                    <a href="#" title="">Employers</a>
                </li>
                <li class="menu-item">
                    <a href="#" title="">Recruitment</a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('user.blog') }}" title="">Blogs</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<header class="stick-top forsticky gradient">
    <div class="menu-sec">
        <div class="container">
            <div class="logo">
                <a href="{{ route('user.home') }}" title=""><img class="hidesticky"
                        src="{{ asset('img/resource/logo.png') }}" alt="" /><img class="showsticky"
                        src="{{ asset('img/resource/logo10.png') }}" alt="" /></a>
            </div><!-- Logo -->
            <div class="btn-extars">
                @auth('user')
                    <nav>
                        <ul>
                            <li class="menu-item-has-children">
                                @php
                                    $name = Route::current()->getName();
                                @endphp
                                @if ($name != 'user.profile')
                                    <a href="{{ route('user.profile') }}" title="">Profile</a>
                                    <ul>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a href="">
                                                <form id="logout-form" action="{{ route('user.logout') }}" method="POST">
                                                    @csrf
                                                    <button class="dropdown-item" type="submit">Logout</button>
                                                </form>
                                            </a>
                                        </li>
                                    </ul>
                                @endif
                            </li>
                    </nav>
                @endauth
                @guest('user')
                    <ul class="account-btns">
                        <li class="signup-popup"><a href="{{ route('user.show_register') }}" title=""><i class="la la-key"></i> Sign Up</a></li>
                        <li class="signin-popup"><a href="{{ route('user.choose_login') }}" title=""><i
                                    class="la la-external-link-square"></i> Login</a></li>
                    </ul>
                @endguest
            </div><!-- Btn Extras -->
            <nav>
                <ul>
                    <li class="menu-item">
                        <a href="{{ route('user.home') }}" title="">Home</a>
                    </li>
                    <li class="menu-item">
                        <a href="#" title="">Employers</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('user.recruitment') }}" title="">Recruitment</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('user.blog') }}" title="">Blogs</a>
                    </li>
                </ul>
            </nav><!-- Menus -->
        </div>
    </div>
</header>
