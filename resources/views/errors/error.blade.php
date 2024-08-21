@extends('layouts.error')

@section('page_title')@yield('code') - @yield('title')@endsection

@section('content')
    <div class="container py-md-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center py-4">
                <div class="mb-4">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo.png') }}" style="max-height: 128px;" height="128" alt="">
                    </a>
                </div>
                <div class="display-1">
                    OOPS!
                </div>
                <div class="h3">@yield('code') - @yield('title')</div>
                <div class="my-4 h5 text-muted">@yield('message')</div>
                <div>
                    <a class="btn btn-primary my-1" href="{{ url()->previous() }}" role="button">
                        <i class="fas fa-arrow-left me-1"></i> Go Back
                    </a>
                    <a class="btn btn-primary m-1" href="/" role="button">
                        <i class="fas fa-home me-1"></i> Go Home
                    </a>
                    <a class="btn btn-primary my-1" href="{{ \Request::fullUrl() }}" role="button">
                        <i class="fas fa-sync me-1"></i> Reload
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
