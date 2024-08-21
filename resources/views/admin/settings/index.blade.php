@extends('layouts.admin')

@section('page_title', 'Settings')

@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-fw fa-list"></i></div>
                            Settings
                        </h1>
                        <div class="page-header-subtitle">
                            Listing all settings
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-body p-3">
                <div class="table-responsive">
                     <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th scope="col">Key</th>
                                <th scope="col">Type</th>
                                <th scope="col">Editable</th>
                                <th scope="col">Comment</th>
                                <th scope="col" width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($settings as $setting)
                                <tr>
                                    <td class="cell font-mono">{{ $setting->key }}</td>
                                    <td class="cell">{{ \Settings::$types[$setting->type] }}</td>
                                    <td class="cell">{{ $setting->editable ? 'Yes' : 'No' }}</td>
                                    <td class="cell small text-muted">{{ $setting->comment }}</td>
                                    <td class="cell">
                                        <x-crud-actions :model="$setting"/>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="20" class="text-center">No results found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <x-pagination :models="$settings"/>
                </div>
            </div>
        </div>
    </div>
@endsection