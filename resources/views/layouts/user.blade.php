<!DOCTYPE html>
<html lang="en-ZA" data-bs-theme="{{ $bs_theme }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="api-token" content="{{ auth('user')->user()->api_token ?? null }}">
        <meta name="theme-color" content="#f9322c"/>
        @stack('meta')
        <title>@yield('page_title', config('app.name'))</title>
        <link rel="preconnect" href="https://s.gravatar.com">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        @vite(['resources/js/user.js'])
        <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="48x48" href="/favicon-48x48.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        @stack('head')
    </head>
    <body>
        <div id="app">
            @include('partials.user.navbar')

            <main role="main" class="py-4">
                @yield('content')
            </main>

            @include('partials.user.footer')
        </div>
        <x-sweet-alert/>
        <x-delete-model/>
        @stack('scripts')
    </body>
</html>