<!DOCTYPE html>
<html lang="en-ZA" data-bs-theme="auto">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="preconnect" href="//fonts.googleapis.com">
        @vite(['resources/js/shared/theme.js', 'resources/js/guest.js'])
        <title>OTP</title>
        <style>
            html,
            body {
                height: 100%;
            }
            body {
                display: -ms-flexbox;
                display: flex;
                -ms-flex-align: center;
                align-items: center;
                padding-top: 40px;
                padding-bottom: 40px;
            }
            .form-otp {
                width: 100%;
                max-width: 360px;
                padding: 15px;
                margin: auto;
            }
            .form-otp .checkbox {
                font-weight: 400;
            }
            .form-otp .form-control:focus {
                z-index: 2;
            }
        </style>
    </head>
    <body class="text-center">
        <form id="resend-otp" class="d-none" method="POST" action="{{ route('otp.resend') }}" hidden>
            @csrf
        </form>
        <form class="form-otp" method="POST">
            @csrf
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" style="max-height: 180px; max-width: 100%;" alt="Logo">
            </a>
            <h1 class="h3 my-4">
                2 Factor Authentication
            </h1>
            <div class="my-3 text-muted small">
                A one-time-pin has been emailed and/or SMSed to you, please check.
            </div>
            <div class="form-floating">
                <input type="text" id="otp" name="otp" class="form-control @error('otp') is-invalid @enderror shadow" placeholder="OTP Number (eg. 123456)" value="{{ old('otp') }}"
                       inputmode="numeric" autocomplete="one-time-code" pattern="[0-9]*" minlength="6" maxlength="6" autofocus required>
                <label for="otp">OTP Number (eg. 123456)</label>
                @error('otp')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <button class="btn btn-lg btn-primary btn-block w-100 mt-4" type="submit">
                Continue
            </button>
            <button class="btn btn-sm btn-link btn-block mt-4" type="button" onclick="event.preventDefault(); document.getElementById('resend-otp').submit();">
                Did not get OTP? Resend now
            </button>
            <div class="mt-5 mb-3 text-muted small">
                {{ config('app.name') }} &copy; {{ date('Y') }}. All rights reserved.
            </div>
        </form>
        <x-sweet-alert/>
    </body>
</html>
