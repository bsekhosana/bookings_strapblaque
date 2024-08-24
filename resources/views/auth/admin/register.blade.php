<!DOCTYPE html>
<html lang="en-ZA" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f9322c" />
    <title>Admin and Organization Registration</title>
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
            max-width: 860px;
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
    </style>
</head>

<body class="text-center">
    <main class="form-signin w-100 m-auto">
        <form method="POST" action="{{ route('admin.register') }}">
            @csrf
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" style="max-height: 180px; max-width: 100%;" alt="Logo">
            </a>
            <h1 class="h3 mb-4 mt-5 fw-normal">Organization Registration</h1>
            @if (count($errors->getBag('default')))
                @foreach ($errors->getBag('default')->getMessages() as $error)
                    <div class="alert alert-danger mb-3 small p-2" role="alert">
                        {{ $error[0] }}
                    </div>
                @endforeach
            @endif

            <!-- Bootstrap Row for responsive design -->
            <div class="row">
                <!-- Organization Details Card -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h5 mb-3">Organization Details</h2>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control shadow" name="org_name" id="org_name"
                                    placeholder="Organization Name" value="{{ old('org_name') }}" required>
                                <label for="org_name">Organization Name</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="email" class="form-control shadow" name="org_email" id="org_email"
                                    placeholder="organization@example.com" value="{{ old('org_email') }}" required>
                                <label for="org_email">Organization Email</label>
                            </div>
                            <div class="form-floating">
                                <input type="text" class="form-control shadow" name="org_phone" id="org_phone"
                                    placeholder="Organization Phone" value="{{ old('org_phone') }}" required>
                                <label for="org_phone">Organization Phone</label>
                            </div>
                            <div class="form-floating">
                                <input type="text" class="form-control shadow" name="org_address" id="org_address"
                                    placeholder="Organization Address" value="{{ old('org_address') }}" required>
                                <label for="org_address">Organization Address</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Details Card -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h5 mb-3">Admin Details</h2>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control shadow" name="first_name" id="first_name"
                                    placeholder="First Name" value="{{ old('first_name') }}" required>
                                <label for="first_name">First Name</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control shadow" name="last_name" id="last_name"
                                    placeholder="Last Name" value="{{ old('last_name') }}" required>
                                <label for="last_name">Last Name</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control shadow" name="mobile" id="mobile"
                                    placeholder="Mobile" value="{{ old('mobile') }}" required>
                                <label for="mobile">Mobile</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="email" class="form-control shadow" name="admin_email"
                                    id="admin_email" placeholder="Admin Email" value="{{ old('admin_email') }}"
                                    required>
                                <label for="admin_email">Admin Email</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="password" class="form-control shadow" name="password" id="password"
                                    placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control shadow" name="password_confirmation"
                                    id="password_confirmation" placeholder="Confirm Password" required>
                                <label for="password_confirmation">Confirm Password</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
            <!-- New Registration Link -->
            <p class="text-muted small" style="margin-top: 1rem !important;">Already registered an organization, <a
                    href="{{ route('admin.login') }}" class="register-link">Login Here!</a></p>

            <p class="mt-5 mb-3 text-muted small">{{ config('app.name') }} &copy; {{ date('Y') }}. All rights
                reserved.</p>
        </form>
    </main>
</body>

</html>
