<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
      <p>{{auth('store')->user()->employer->name ?? ''}}</p>
    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('employer.dashboard') }}">
            <svg class="c-sidebar-nav-icon">
                <use xlink:href="{{ route('employer.dashboard') }}"></use>
            </svg>
            Application statistics<span class="badge badge-info"></span></a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('employer.profile.index') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{asset('coreui/icons/free.svg#cil-door')}}"></use>
                </svg>
                Account Settings
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('employer.recruitment.index') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{asset('coreui/icons/free.svg#cil-door')}}"></use>
                </svg>
                Recruitment
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('employer.prioritize.index') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{asset('coreui/icons/free.svg#cil-door')}}"></use>
                </svg>
                Prioritize	
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('employer.candidate.index') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{asset('coreui/icons/free.svg#cil-door')}}"></use>
                </svg>
                Candidate Management
            </a>
        </li>
        <li class="c-sidebar-nav-divider"></li>
        <li class="c-sidebar-nav-title"></li>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>