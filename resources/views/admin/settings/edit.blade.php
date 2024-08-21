@extends('layouts.admin')

@section('page_title', 'Edit Setting')

@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-fw fa-pencil-alt"></i></div>
                            Edit Setting
                        </h1>
                        <div class="page-header-subtitle">
                            Updating a setting
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header">Edit Setting</div>
            <div class="card-body">
                <form class="needs-validation" method="POST" action="{{ $setting->updateRoute() }}" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3 align-items-center">
                        <div class="col-xl-2 text-xl-end">
                            <label for="key" class="col-form-label">Key</label>
                        </div>
                        <div class="col-xl-8">
                            <input id="key" type="text" class="form-control font-mono" value="{{ $setting->key }}" readonly>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-xl-2 text-xl-end">
                            <label for="type" class="col-form-label">Type</label>
                        </div>
                        <div class="col-xl-8">
                            @if($setting->editable)
                                <select id="type" name="type" class="form-control form-select @error('type') is-invalid @enderror" required>
                                    @foreach(\Settings::$types as $type => $value)
                                        @if(old('type', $setting->type) == $type)
                                            <option value="{{ $type }}" selected>{{ $value }}</option>
                                        @else
                                            <option value="{{ $type }}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            @else
                                <input id="type" type="text" class="form-control" value="{{ \Settings::$types[$setting->type] }}" readonly>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="offset-xl-2 col-xl-8">
                            <span class="mt-1 small text-muted"><i>WARNING: Changing this to an incorrect type can create a parse error and crash the system!</i></span>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-xl-2 text-xl-end">
                            <label for="editable" class="col-form-label">Editable</label>
                        </div>
                        <div class="col-xl-8">
                            @if($setting->editable)
                                <select id="editable" name="editable" class="form-control form-select @error('editable') is-invalid @enderror" required>
                                    @foreach([1 => 'Yes', 0 => 'No'] as $bool => $value)
                                        @if(old('editable', $setting->editable) == $bool)
                                            <option value="{{ $bool }}" selected>{{ $value }}</option>
                                        @else
                                            <option value="{{ $bool }}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('editable')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            @else
                                <input id="editable" type="text" class="form-control" value="No" readonly>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="offset-xl-2 col-xl-8">
                            <span class="mt-1 small text-muted"><i>WARNING: If this is set to NO, you will NOT be able to change this or the value in the future!</i></span>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <div class="col-xl-2 text-xl-end">
                            <label for="comment" class="col-form-label">Comment</label>
                        </div>
                        <div class="col-xl-8">
                            <textarea id="comment" name="comment" rows="3" maxlength="255" class="form-control lh-base @error('comment') is-invalid @enderror">{{ old('comment', $setting->comment) }}</textarea>
                            @error('comment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <div class="col-xl-2 text-xl-end">
                            <label for="value" class="col-form-label">Value</label>
                        </div>
                        @if($setting->editable)
                            <div class="col-xl-8">
                                <textarea id="value" name="value" rows="10" class="form-control lh-base font-mono @error('value') is-invalid @enderror">{{ old('value', \Settings::stringify($setting->value)) }}</textarea>
                                @error('value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @else
                            <div class="col-xl-8">
                                <textarea id="value" rows="10" class="form-control lh-base font-mono" readonly>{{ \Settings::stringify($setting->value) }}</textarea>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="offset-xl-2 col-xl-8">
                            <button class="me-1 btn btn-primary" type="submit">
                                <i class="fas fa-fw fa-save me-1"></i> Update
                            </button>
                            <a href="{{ previousUrl('admin.settings.index') }}" class="me-1 btn btn-secondary">
                                <i class="fas fa-fw fa-x me-1"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection