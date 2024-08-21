@extends('layouts.admin')

@section('page_title', 'View Setting')

@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-fw fa-eye"></i></div>
                            View Setting
                        </h1>
                        <div class="page-header-subtitle">
                            Viewing a setting
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header">Setting</div>
            <div class="card-body">
                <form class="needs-validation">
                    <div class="row mb-3 align-items-center">
                        <div class="col-xl-2 text-xl-end">
                            <label for="key" class="col-form-label">Key</label>
                        </div>
                        <div class="col-xl-8">
                            <input id="key" type="text" class="form-control font-mono" value="{{ $setting->key }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <div class="col-xl-2 text-xl-end">
                            <label for="type" class="col-form-label">Type</label>
                        </div>
                        <div class="col-xl-8">
                            <input id="type" name="type" type="text" class="form-control" value="{{ \Settings::$types[$setting->type] }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <div class="col-xl-2 text-xl-end">
                            <label for="editable" class="col-form-label">Editable</label>
                        </div>
                        <div class="col-xl-8">
                            <input id="editable" name="editable" type="text" class="form-control" value="{{ $setting->editable ? 'Yes' : 'No' }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <div class="col-xl-2 text-xl-end">
                            <label for="comment" class="col-form-label">Comment</label>
                        </div>
                        <div class="col-xl-8">
                            <textarea id="comment" name="comment" rows="3" class="form-control lh-base" readonly>{{ $setting->comment }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <div class="col-xl-2 text-xl-end">
                            <label for="value" class="col-form-label">Value</label>
                        </div>
                        <div class="col-xl-8">
                            <textarea id="value" name="value" rows="10" class="form-control lh-base font-mono" readonly>{{ \Settings::stringify($setting->value) }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="offset-xl-2 col-xl-8">
                            <a href="{{ $setting->indexRoute() }}" class="me-1 btn btn-secondary">
                                <i class="fas fa-fw fa-arrow-left me-1"></i> Back
                            </a>
                            <a href="{{ $setting->editRoute() }}" class="me-1 btn btn-primary">
                                <i class="fas fa-fw fa-pencil-alt me-1"></i> Edit
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection