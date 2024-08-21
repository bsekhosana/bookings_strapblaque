<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start" id="sidenavAccordion">
    <!-- Sidenav Toggle Button-->
    <button class="btn btn-icon order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle">
        <i class="fas fa-fw fa-bars"></i>
    </button>
    <!-- Navbar Brand-->
    <!-- * * Tip * * You can use text or an image for your navbar brand.-->
    <!-- * * * * * * When using an image, we recommend the SVG format.-->
    <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
    <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="/">{{ config('app.name') }}</a>
    <!-- Navbar Items-->
    <ul class="navbar-nav align-items-center ms-auto">
        <bs-theme-admin theme="{{ $bs_theme ?? 'auto' }}"></bs-theme-admin>

        <li class="nav-item d-none d-md-block me-3">
            {{ auth('admin')->user()->name }}
        </li>
        <!-- User Dropdown-->
        <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
            <a class="btn btn-icon dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="{{ auth('admin')->user()->avatar }}"/></a>
            <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center">
                    <img class="dropdown-user-img" src="{{ auth('admin')->user()->avatar }}"/>
                    <div class="dropdown-user-details">
                        <div class="dropdown-user-details-name">{{ auth('admin')->user()->name }}</div>
                        <div class="dropdown-user-details-email">{{ auth('admin')->user()->email }}</div>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('admin.profile.account') }}">
                    <div class="dropdown-item-icon"><i class="fas fa-fw fa-user"></i></div>
                    Account
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="dropdown-item-icon"><i class="fas fa-fw fa-arrow-right-from-bracket"></i></div>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>