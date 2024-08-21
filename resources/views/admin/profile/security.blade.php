@extends('layouts.admin')

@section('page_title', 'Settings - Security')

@section('content')
    <div class="container-xl px-4 mt-4">
        <!-- Account page navigation-->
        @include('partials.admin.settings-navbar')
        <hr class="mt-0 mb-4">
        <div class="row">
            <div class="col-lg-8">
                <!-- Change password card-->
                <div class="card mb-4">
                    <div class="card-header">Change Password</div>
                    <div class="card-body">
                        <form class="needs-validation" method="POST">
                            @csrf
                            @method('PUT')
                            <!-- Form Group (current password)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="old_password">Current Password</label>
                                <input class="form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password" type="password" placeholder="Enter current password" autocomplete="current-password">
                                @error('old_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <!-- Form Group (new password)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="password">New Password</label>
                                <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" placeholder="Enter new password" autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <!-- Form Group (confirm password)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="password_confirmation">Confirm Password</label>
                                <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm new password" autocomplete="new-password">
                            </div>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-fw fa-save me-1"></i> Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                @if(\Config::get('app.tfa'))
                    <!-- Two-factor authentication card-->
                    <div class="card mb-4">
                        <div class="card-header">Two-Factor Authentication</div>
                        <div class="card-body">
                            <p>
                                Add another level of security to your account by enabling two-factor authentication.
                                We will send you an SMS and email to verify your login.
                            </p>
                            <form class="needs-validation" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-check">
                                    <input class="form-check-input" id="tfa_on" type="radio" name="tfa" value="1" {{ $user->tfa ? 'checked' : null }}>
                                    <label class="form-check-label" for="tfa_on">On</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" id="tfa_off" type="radio" name="tfa" value="0" {{ $user->tfa ? null : 'checked' }}>
                                    <label class="form-check-label" for="tfa_off">Off</label>
                                </div>
                                <div class="mt-3">
                                    <label class="small mb-1" for="twoFactorSMS">SMS Number</label>
                                    <input class="form-control" id="twoFactorSMS" type="tel" value="{{ $user->mobile }}" style="cursor: default;" readonly>
                                </div>
                                <div class="mt-3">
                                    <label class="small mb-1" for="twoFactorEmail">Email Address</label>
                                    <input class="form-control" id="twoFactorEmail" type="email" value="{{ $user->email }}" style="cursor: default;" readonly>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-fw fa-save me-1"></i> Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
{{--                <div class="card mb-4">--}}
{{--                    <div class="card-header">Delete Account</div>--}}
{{--                    <div class="card-body">--}}
{{--                        <p>Deleting your account is a permanent action and cannot be undone. If you are sure you want to delete your account, select the button below.</p>--}}
{{--                        <button class="btn btn-danger-soft text-danger" type="button">I understand, delete my account</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
@endsection