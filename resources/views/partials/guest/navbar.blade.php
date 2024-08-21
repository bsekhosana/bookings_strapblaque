<nav class="navbar navbar-expand-md bg-body-tertiary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img class="me-2" src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" height="30"> {{ config('app.name') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ \Ekko::isActiveRoute('guest.homepage') }}" href="{{ route('guest.homepage') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ \Ekko::isActiveRoute('guest.about') }}" href="{{ route('guest.about') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ \Ekko::isActiveRoute('guest.contact') }}" href="{{ route('guest.contact') }}">Contact Us</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                @auth('user')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ auth('user')->user()->avatar }}" width="30" height="30" class="rounded-3 me-2" alt="Avatar">
                            {{ auth('user')->user()->name ?? 'User' }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                Dashboard
                            </a>
                            <a class="dropdown-item" href="{{ route('user.settings.redirect') }}">
                                Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout').submit();">
                                Logout
                            </a>
                            <form id="logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @elseauth('admin')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ auth('admin')->user()->avatar }}" width="30" height="30" class="rounded-3 me-2" alt="Avatar">
                            {{ auth('admin')->user()->name ?? 'Admin' }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                Dashboard
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout').submit();">
                                Logout
                            </a>
                            <form id="logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ \Ekko::isActiveRoute('login') }}" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ \Ekko::isActiveRoute('register') }}" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
