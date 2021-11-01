<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <svg class="c-sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="{{asset('img/coreui.svg#full')}}"></use>
        </svg>
        <svg class="c-sidebar-brand-minimized" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="{{asset('img/coreui.svg#signet')}}"></use>
        </svg>
    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('admin.dashboard') }}">
            <svg class="c-sidebar-nav-icon">
                <use xlink:href="{{ route('admin.dashboard') }}"></use>
            </svg>
            Dashboard<span class="badge badge-info">NEW</span></a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('admin.employers.index') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{asset('coreui/icons/free.svg#cil-door')}}"></use>
                </svg>
                Employer
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('admin.users.index') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{asset('coreui/icons/free.svg#cil-door')}}"></use>
                </svg>
                Users
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('admin.recruitment.index') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{asset('coreui/icons/free.svg#cil-door')}}"></use>
                </svg>
                Recruitment Post
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('admin.recruitmentcat.index') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{asset('coreui/icons/free.svg#cil-door')}}"></use>
                </svg>
                Recruitment Category
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('admin.blogs.index') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{asset('coreui/icons/free.svg#cil-door')}}"></use>
                </svg>
                Blogs
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('admin.categories.index') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{asset('coreui/icons/free.svg#cil-door')}}"></use>
                </svg>
                Blog Category
            </a>
        </li>
        <li class="c-sidebar-nav-divider"></li>
        <li class="c-sidebar-nav-title">Extras</li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('admin.profile.index') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{asset('coreui/icons/free.svg#cil-door')}}"></use>
                </svg>
                Profile
            </a>
        </li>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>