@extends('layouts.admin')

@section('page_title', 'View Admin')

@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-fw fa-eye"></i></div>
                            View Admin
                        </h1>
                        <div class="page-header-subtitle">
                            Viewing an admin
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header">Admin</div>
            <div class="card-body">
                <form class="needs-validation">

                    <x-readonly.text label="ID" key="id" :value="$admin->id"/>

                    <x-readonly.text label="First Name" key="first_name" :value="$admin->first_name"/>

                    <x-readonly.text label="Last Name" key="last_name" :value="$admin->last_name"/>

                    <x-readonly.text label="Email" key="email" :value="$admin->email"/>

                    <x-readonly.text label="Mobile" key="mobile" :value="$admin->mobile"/>

                    <x-readonly.boolean label="Two-Factor Auth" key="tfa" :value="$admin->tfa"/>

                    <x-readonly.boolean label="Super Admin" key="super_admin" :value="$admin->super_admin"/>

                    <x-readonly.datetime label="Last Seen At" key="last_seen_at" :value="$admin->last_seen"/>

                    <x-readonly.datetime label="Created At" key="created_at" :value="$admin->created_at"/>

                    <x-readonly.datetime label="Updated At" key="updated_at" :value="$admin->updated_at"/>

                    <div class="row">
                        <div class="offset-xl-2 col-xl-8">
                            <a href="{{ $admin->indexRoute() }}" class="me-1 btn btn-secondary">
                                <i class="fas fa-fw fa-arrow-left me-1"></i> Back
                            </a>
                            @if($admin->id !== auth('admin')->id())
                                <a href="{{ $admin->editRoute() }}" class="me-1 btn btn-primary">
                                    <i class="fas fa-fw fa-pencil-alt me-1"></i> Edit
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection