@extends('layouts.admin')

@section('page_title', 'Edit Xxxx')

@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-fw fa-pencil-alt"></i></div>
                            Edit Xxxx
                        </h1>
                        <div class="page-header-subtitle">
                            Updating a xxxx
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header">Edit Xxxx</div>
            <div class="card-body">
                <form class="needs-validation" method="POST" action="{{ $xxxx->updateRoute() }}" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <x-inputs.text label="Name" key="name" :value="old('name', $admin->name)"/>

                    <div class="row">
                        <div class="offset-xl-2 col-xl-8">
                            <button class="me-1 btn btn-primary" type="submit">
                                <i class="fas fa-fw fa-save me-1"></i> Update
                            </button>
                            <a href="{{ previousUrl('admin.xxxxs.index') }}" class="me-1 btn btn-secondary">
                                <i class="fas fa-fw fa-x me-1"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection