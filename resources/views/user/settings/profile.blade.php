@extends('layouts.user')

@section('page_title', 'Profile')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('user.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Settings</li>
                    </ol>
                </nav>
            </div>
            @include('partials.user.sidebar')
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        Update Profile
                    </div>
                    <div class="card-body">
                        <form id="verify-resend" action="{{ route('verification.resend') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <form method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3 required">
                                <label for="first_name" class="col-md-4 col-form-label text-md-end">First Name</label>
                                <div class="col-md-7">
                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="John" autocomplete="first_name" required>
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 required">
                                <label for="last_name" class="col-md-4 col-form-label text-md-end">Last Name</label>
                                <div class="col-md-7">
                                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="Doe" autocomplete="last_name" required>
                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 required">
                                <label for="email" class="col-md-4 col-form-label text-md-end">E-Mail Address</label>
                                <div class="col-md-7">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" placeholder="john.doe@example.com" autocomplete="email" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @elseif(empty($user->email_verified_at))
                                        <div class="small text-primary mt-1 px-1">
                                            A verification link has been sent to your email address!
                                            <a href="{{ route('verification.resend') }}" onclick="event.preventDefault(); document.getElementById('verify-resend').submit();">Send again</a>
                                        </div>
                                    @else
                                        <div class="smaller text-muted mt-1 px-1">
                                            A new verification email will be sent!
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="offset-md-4 col-md-7">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="example-switch" name="example-switch" value="1" {{ 'something' ? 'checked' : null }}>
                                        <label class="form-check-label" for="example-switch">Example switch</label>
                                    </div>
                                    @error('example-switch')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-fw fa-user-pen me-1"></i> Update Profile
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Change password
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.settings.profile.password') }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3 required">
                                <label for="old_password" class="col-md-4 col-form-label text-md-end">Old Password</label>
                                <div class="col-md-7">
                                    <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" placeholder="Old password" autocomplete="password" required>
                                    @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 required">
                                <label for="password" class="col-md-4 col-form-label text-md-end">New Password</label>
                                <div class="col-md-7">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="New password" autocomplete="new-password" required>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 required">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirm Password</label>
                                <div class="col-md-7">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password" autocomplete="new-password" required>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-fw fa-lock me-1"></i> Update Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
