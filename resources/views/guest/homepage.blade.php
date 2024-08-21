@extends('layouts.guest')

@section('page_title', 'Home')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                 <div class="card">
                    <div class="card-header">
                        Homepage
                    </div>
                    <div class="card-body p-xl-5">
                        @if(\App::isLocal())
                            <div class="text-center mb-5">
                                <img src="https://raw.githubusercontent.com/emotality/files/master/GitHub/laravel-skeleton.png" style="width:400px; max-width:100%;">
                            </div>
                            <h5>⚠️ Notes:</h5>
                            <ul>
                                <li>Keep the <a class="font-mono" href="phpstorm://open?file={{ app_path('Http/Kernel.php') }}&line=23&column=8">AddCspHeader</a> middleware updated during development, or remove it, up to you!</li>
                                <li>If you are running <code class="font-mono" style="color:#f9322c;">npm run dev</code>, you need to comment out <a class="font-mono" href="phpstorm://open?file={{ app_path('Http/Kernel.php') }}&line=23&column=8">AddCspHeader</a> middleware</li>
                            </ul>
                            <h5>🔢 Steps for quick project setup:</h5>
                            <ol>
                                <li>Replace the theme color <code class="font-mono" style="background-color: #f9322c; color: #fff; padding: 2px;">#f9322c</code> to yours</li>
                                <li>Replace the logo at <a class="font-mono" href="phpstorm://open?file={{ public_path('images/logo.png') }}">public/images/logo.png</a></li>
                                <li>Generate a new favicon with <code class="font-mono" style="color: #f9322c;">php artisan favicon</code></li>
                                <li>Create email style at <a class="font-mono" href="phpstorm://open?file={{ resource_path('views/vendor/mail/html/themes/laravel.css') }}&line=1&column=1">resources/views/vendor/mail/html/themes</a> <span class="text-muted small">(See "Example Email" below)</span></li>
                                <li>Add/update email theme at <a class="font-mono" href="phpstorm://open?file={{ base_path('config/mail.php') }}&line=135&column=8">config/mail.php</a></li>
                            </ol>
                            <div class="text-center mt-4">
                                <a target="_blank" href="{{ route('guest.test.mail') }}" class="btn btn-primary m-1">
                                    <i class="fas fa-fw fa-paper-plane me-1"></i> Email Theme
                                </a>
                                <a target="_blank" href="{{ route('guest.test.otp') }}" class="btn btn-primary m-1">
                                    <i class="fas fa-fw fa-lock me-1"></i> OTP Form
                                </a>
                                <a target="_blank" href="{{ route('admin.login') }}" class="btn btn-primary m-1">
                                    <i class="fas fa-fw fa-user-shield me-1"></i> Admin Login
                                </a>
                                <a target="_blank" href="{{ url(config('nova.path')) }}" class="btn btn-primary m-1">
                                    <i class="fab fa-fw fa-laravel me-1"></i> Nova Login
                                </a>
                            </div>
                            <div class="text-center mt-2">
                                <a target="_blank" href="https://laravel.com/docs/" class="btn btn-secondary m-1">
                                    <i class="fab fa-fw fa-laravel me-1"></i> Laravel Docs
                                </a>
                                <a target="_blank" href="https://getbootstrap.com/docs/5.2" class="btn btn-secondary m-1">
                                    <i class="fab fa-fw fa-bootstrap me-1"></i> Bootstrap 5 Docs
                                </a>
                                <a target="_blank" href="https://fontawesome.com/search?m=free&s=solid" class="btn btn-secondary m-1">
                                    <i class="fab fa-fw fa-font-awesome me-1"></i> FontAwesome Icons
                                </a>
                            </div>
                        @else
                            Hello world!
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
