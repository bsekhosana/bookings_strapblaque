<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <div class="sidenav-menu-heading">Home</div>
                <a class="nav-link {{ \Ekko::isActiveRoute('admin.dashboard') }}" href="{{ route('admin.dashboard') }}">
                    <div class="nav-link-icon"><i class="fas fa-fw fa-home"></i></div>
                    Dashboard
                </a>

                <div class="sidenav-menu-heading">Content</div>
                <a class="nav-link {{ \Ekko::isActiveRoute('admin.contact_forms.*') }}" href="{{ route('admin.contact_forms.index') }}">
                    <div class="nav-link-icon"><i class="fas fa-fw fa-at"></i></div>
                    Contact Forms
                </a>

                @if(auth('admin')->user()->isSuperAdmin())
                    <div class="sidenav-menu-heading">Options</div>
                    <a class="nav-link {{ \Ekko::isActiveRoute('admin.settings.*') }}" href="{{ route('admin.settings.index') }}">
                        <div class="nav-link-icon"><i class="fas fa-fw fa-gear"></i></div>
                        Settings
                    </a>

                    <div class="sidenav-menu-heading">Members</div>
                    <a class="nav-link {{ \Ekko::isActiveRoute('admin.admins.*') }}" href="{{ route('admin.admins.index') }}">
                        <div class="nav-link-icon"><i class="fas fa-fw fa-user-gear"></i></div>
                        Admins
                    </a>
                    <a class="nav-link {{ \Ekko::isActiveRoute('admin.users.*') }}" href="{{ route('admin.users.index') }}">
                        <div class="nav-link-icon"><i class="fas fa-fw fa-users"></i></div>
                        Users
                    </a>

                    <div class="sidenav-menu-heading">System</div>
                    <a class="nav-link" href="/{{ config('horizon.path') }}" target="_blank">
                        <div class="nav-link-icon"><i class="fas fa-fw fa-arrows-split-up-and-left"></i></div>
                        Queues
                    </a>
                    <a class="nav-link" href="/{{ config('pulse.path') }}" target="_blank">
                        <div class="nav-link-icon"><i class="fas fa-fw fa-heart-pulse"></i></div>
                        Health
                    </a>
                @endif
{{--                <a class="nav-link {{ \Ekko::isActiveRoute('admin.logs.system') }}" href="{{ route('admin.logs.system') }}">--}}
{{--                    <div class="nav-link-icon"><i class="fas fa-fw fa-building-shield"></i></div>--}}
{{--                    System--}}
{{--                </a>--}}

{{--                <div class="sidenav-menu-heading">Example</div>--}}
{{--                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">--}}
{{--                    <div class="nav-link-icon"><i class="fas fa-fw fa-box"></i></div>--}}
{{--                    Dropdown--}}
{{--                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>--}}
{{--                </a>--}}
{{--                <div class="collapse" id="collapseLayouts" data-bs-parent="#accordionSidenav">--}}
{{--                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">--}}

{{--                        <a class="nav-link" href="#">Example 1</a>--}}
{{--                        <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLayoutSidenavVariations" aria-expanded="false" aria-controls="collapseLayoutSidenavVariations">--}}
{{--                            Example 2--}}
{{--                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>--}}
{{--                        </a>--}}
{{--                        <div class="collapse" id="collapseLayoutSidenavVariations" data-bs-parent="#accordionSidenavLayout">--}}
{{--                            <nav class="sidenav-menu-nested nav">--}}
{{--                                <a class="nav-link" href="#">Example 1</a>--}}
{{--                                <a class="nav-link" href="#">Example 2</a>--}}
{{--                            </nav>--}}
{{--                        </div>--}}
{{--                    </nav>--}}
{{--                </div>--}}
            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Logged in as:</div>
                <div class="sidenav-footer-title">{{ auth('admin')->user()->name }}</div>
            </div>
        </div>
    </nav>
</div>