<!DOCTYPE html>
<html lang="en-ZA" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f9322c" />
    <title>Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    @vite(['resources/js/shared/theme.js', 'resources/js/guest.js'])
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="48x48" href="/favicon-48x48.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .form-signin {
            max-width: 400px;
            padding: 15px;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .register-link {
            margin-top: 10px;
            display: block;
            text-decoration: none;
            font-size: 14px;
            color: #007bff;
        }

        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body class="text-center">
    <main class="form-signin w-100 m-auto">
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" style="max-height: 180px; max-width: 100%;" alt="Logo">
            </a>
            <h1 class="h3 mb-4 mt-5 fw-normal">Admin Login</h1>
            @if (count($errors->getBag('default')))
                @foreach ($errors->getBag('default')->getMessages() as $error)
                    <div class="alert alert-danger mb-3 small p-2" role="alert">
                        {{ $error[0] }}
                    </div>
                @endforeach
            @endif
            <div class="form-floating">
                <input type="email" class="form-control shadow" name="email" id="email"
                    placeholder="john.doe@example.com" value="{{ old('email') }}" required>
                <label for="email">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control shadow" name="password" id="password" placeholder="Password"
                    required>
                <label for="password">Password</label>
            </div>
            <div class="form-check my-3 d-inline-flex">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    &nbsp; Remember Me
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>

            <!-- New Registration Link -->
            <p class="text-muted small" style="margin-top: 1rem !important;">Register a new organization, <a
                    href="{{ route('admin.register') }}" class="register-link"
                    style="color: rgba(var(--bs-link-color-rgb), var(--bs-link-opacity, 1))">Click Here!</a></p>

            {{-- <div class="mt-2 d-inline-flex">
                    <a class="btn btn-link text-decoration-none" href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a>
                </div> --}}
            <p class="mt-5 mb-3 text-muted small">{{ config('app.name') }} &copy; {{ date('Y') }}. All rights
                reserved.</p>
        </form>
    </main>
</body>

</html>
