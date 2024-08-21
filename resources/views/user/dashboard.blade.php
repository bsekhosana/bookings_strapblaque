@extends('layouts.user')

@section('page_title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            Dashboard
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        User Dashboard
                    </div>
                    <div class="card-body">
                        You are logged in as a user!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
