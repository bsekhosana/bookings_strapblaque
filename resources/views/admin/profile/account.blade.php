@extends('layouts.admin')

@section('page_title', 'Settings - Account')

@section('content')
    <div class="container-xl px-4 mt-4">
        <!-- Account page navigation-->
        @include('partials.admin.settings-navbar')
        <hr class="mt-0 mb-4">
        <div class="row">
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <form class="needs-validation" method="POST">
                            @csrf
                            @method('PUT')
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="first_name">First name</label>
                                    <input class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" type="text" placeholder="Enter your first name" value="{{ old('first_name', $user->first_name) }}" autocomplete="given-name">
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="last_name">Last name</label>
                                    <input class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" type="text" placeholder="Enter your last name" value="{{ old('last_name', $user->last_name) }}" autocomplete="family-name">
                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (email address)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="email">Email address</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" placeholder="Enter your email address" value="{{ old('email', $user->email) }}" autocomplete="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <!-- Form Group (phone number)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="mobile">Phone number</label>
                                    <input class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" type="tel" minlength="10" maxlength="13" placeholder="Enter your phone number" value="{{ old('mobile', $user->mobile) }}" autocomplete="tel">
                                    @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Save changes button-->
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-fw fa-save me-1"></i> Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                        <!-- Profile picture image-->
                        <img class="img-account-profile rounded-circle mb-2" src="{{ auth('admin')->user()->avatar }}" alt="Avatar">
                        <!-- Profile picture help block-->
                        {{--                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>--}}
                        <div class="small font-italic text-muted my-3">Avatars are pulled from <a href="https://en.gravatar.com" target="_blank">Gravatar.com</a></div>
                        <!-- Profile picture upload button-->
                        {{--                        <button class="btn btn-primary" type="button">Upload new image</button>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection