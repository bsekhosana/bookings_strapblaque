@extends('layouts.guest')

@section('page_title', 'Contact Us')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Contact Us
                    </div>
                    <div class="card-body">
                        <form class="row needs-validation" method="POST">
                            @csrf
                            <x-honeypot />
                            <div class="col-md-6 mb-3">
                                <label for="name">Full Name</label>
                                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" minlength="4" placeholder="Full Name" value="{{ old('name') }}" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email">Email Address</label>
                                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" minlength="6" placeholder="Email Address" value="{{ old('email') }}" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="message">Message</label>
                                <textarea id="message" name="message" class="form-control @error('message') is-invalid @enderror" minlength="10" maxlength="5120" rows="6" placeholder="Message" required>{{ old('message') }}</textarea>
                                @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <li class="fas fa-fw fa-paper-plane me-1"></li> Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
