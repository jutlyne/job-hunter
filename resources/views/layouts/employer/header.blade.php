<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
        <svg class="c-icon c-icon-lg">
            <use xlink:href="{{asset('coreui/icons/free.svg#cil-menu')}}"></use>
        </svg>
    </button>
    <a class="c-header-brand d-lg-none" href="#">
    </a>
    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
        <svg class="c-icon c-icon-lg">
            <use xlink:href="{{asset('coreui/icons/free.svg#cil-menu')}}"></use>
        </svg>
    </button>
    <ul class="c-header-nav ml-auto mr-4">
        <li class="c-header-nav-item dropdown">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="c-avatar" >
                    <img class="c-avatar-img rounded-circle" style="width: 40px; height:40px" src="{{auth('store')->user()->employer->avatar_url ?? ''}}" alt="user@email.com">
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-0">
                <div class="dropdown-header bg-light py-2"><strong>Tài khoản</strong></div>
                <form id="logout-form" action="{{ route('employer.logout') }}" method="POST">
                    @csrf
                    <input id="device_id" type="hidden" name="device_id" value="">
                    <button class="dropdown-item" type="submit">
                        <svg class="c-icon mr-2">
                            <use xlink:href="{{asset('coreui/icons/free.svg#cil-account-logout')}}"></use>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
    <div class="c-subheader px-3">
        <!-- Breadcrumb-->
        <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item"><a href="{{ route('employer.dashboard') }}">Application statistics</a></li>
            <!-- Breadcrumb Menu-->
        </ol>
    </div>
</header>