@extends('layouts.admin')

@section('page_title', 'View User')

@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-fw fa-eye"></i></div>
                            View User
                        </h1>
                        <div class="page-header-subtitle">
                            Viewing an user
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header">User</div>
            <div class="card-body">
                <form class="needs-validation">

                    <x-readonly.text label="ID" key="id" :value="$user->id"/>

                    <x-readonly.text label="First Name" key="first_name" :value="$user->first_name"/>

                    <x-readonly.text label="Last Name" key="last_name" :value="$user->last_name"/>

                    <x-readonly.text label="Email" key="email" :value="$user->email"/>

                    <x-readonly.datetime label="Email Verified At" key="email_verified_at" :value="$user->email_verified_at"/>

                    <x-readonly.datetime label="Created At" key="created_at" :value="$user->created_at"/>

                    <x-readonly.datetime label="Updated At" key="updated_at" :value="$user->updated_at"/>

                    <div class="row">
                        <div class="offset-xl-2 col-xl-8">
                            <a href="{{ $user->indexRoute() }}" class="me-1 btn btn-secondary">
                                <i class="fas fa-fw fa-arrow-left me-1"></i> Back
                            </a>
                            <a href="{{ $user->editRoute() }}" class="me-1 btn btn-primary">
                                <i class="fas fa-fw fa-pencil-alt me-1"></i> Edit
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection