<nav class="nav nav-borders">
    <a class="nav-link {{ Ekko::isActiveroute('admin.profile.account') }} ms-0" href="{{ route('admin.profile.account') }}">Account</a>
    <a class="nav-link {{ Ekko::isActiveroute('admin.profile.security') }}" href="{{ route('admin.profile.security') }}">Security</a>
</nav>