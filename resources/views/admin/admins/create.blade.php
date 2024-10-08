@extends('layouts.admin')

@section('page_title', 'New Admin')

@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-fw fa-plus"></i></div>
                            New Admin
                        </h1>
                        <div class="page-header-subtitle">
                            Adding a new admin
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header">New Admin</div>
            <div class="card-body">
                <form class="needs-validation" method="POST" action="{{ \App\Models\Admin::storeRoute() }}" autocomplete="off">
                    @csrf

                    <x-inputs.text label="First Name" key="first_name" :value="old('first_name')"/>

                    <x-inputs.text label="Last Name" key="last_name" :value="old('last_name')" :required="false"/>

                    <x-inputs.text label="Email" key="email" :value="old('email')"/>

                    <x-inputs.text label="Mobile Number" key="mobile" :min="10" :max="13" :value="old('mobile')"/>

                    <x-inputs.checkbox label="Two-Factor Authentication (OTP)" key="tfa" :value="old('tfa')"/>

                    <x-inputs.password/>

                    <x-inputs.checkbox label="Super admin" key="super_admin" :value="old('super_admin')"/>

                    <div class="row">
                        <div class="offset-xl-2 col-xl-8">
                            <button class="me-1 btn btn-primary" type="submit">
                                <i class="fas fa-fw fa-save me-1"></i> Save
                            </button>
                            <a href="{{ previousUrl('admin.admins.index') }}" class="me-1 btn btn-secondary">
                                <i class="fas fa-fw fa-x me-1"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection