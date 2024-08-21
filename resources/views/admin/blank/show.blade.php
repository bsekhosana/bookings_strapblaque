@extends('layouts.admin')

@section('page_title', 'View Xxxx')

@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-fw fa-eye"></i></div>
                            View Xxxx
                        </h1>
                        <div class="page-header-subtitle">
                            Viewing a xxxx
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header">Xxxx</div>
            <div class="card-body">
                <form class="needs-validation">

                    <x-readonly.text label="Name" key="name" :value="$xxxx->name"/>

                    <x-readonly.datetime label="Created At" key="created_at" :value="$xxxx->created_at"/>

                    <x-readonly.datetime label="Updated At" key="updated_at" :value="$xxxx->updated_at"/>

                    <div class="row">
                        <div class="offset-xl-2 col-xl-8">
                            <a href="{{ $xxxx->indexRoute() }}" class="me-1 btn btn-secondary">
                                <i class="fas fa-fw fa-arrow-left me-1"></i> Back
                            </a>
                            <a href="{{ $xxxx->editRoute() }}" class="me-1 btn btn-primary">
                                <i class="fas fa-fw fa-pencil-alt me-1"></i> Edit
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection