@extends('layouts.admin')

@section('page_title', 'Xxxxs')

@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-fw fa-list"></i></div>
                            Xxxxs
                        </h1>
                        <div class="page-header-subtitle">
                            Listing all xxxxs
                        </div>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">
                        <a class="btn btn-light" href="{{ \App\Models\Xxxx::createRoute() }}"><i class="fas fa-fw fa-plus me-1"></i> Add Xxxx</a>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <form method="get">
                    <div class="row g-2">
                        <div class="col-md-4 col-xl-5">
                            <div class="input-group input-group-joined">
                                <span class="input-group-text">
                                    <i class="fas fa-fw fa-magnifying-glass"></i>
                                </span>
                                <input type="text" class="form-control ps-0" id="search" name="search" placeholder="Search" value="{{ old('search') }}">
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-5">
                            <select id="has_whatever" name="has_whatever" class="form-control">
                                <option value="">Has whatever?</option>
                                @foreach(['no' => 'No', 'yes' => 'Yes'] as $value => $title)
                                    @if($value == old('has_whatever'))
                                        <option value="{{ $value }}" selected>{{ $title }}</option>
                                    @else
                                        <option value="{{ $value }}">{{ $title }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-xl-2 text-center">
                            <button type="submit" class="btn btn-primary-soft me-1 w-48" title="Search">
                                <i class="fas fa-fw fa-search"></i>
                            </button>
                            <a href="{{ url()->current() }}" class="btn btn-primary-soft w-48" title="Clear">
                                <i class="fas fa-fw fa-delete-left"></i>
                            </a>
                        </div>
                    </div>
                </form>
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
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Created At</th>
                                <th scope="col" width="140">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($xxxxs as $xxxx)
                                <tr>
                                    <td class="cell font-mono">{{ $xxxx->id }}</td>
                                    <td class="cell">{{ $xxxx->name }}</td>
                                    <td class="cell">@humanDateTime($xxxx->created_at)</td>
                                    <td class="cell">
                                        <x-crud-actions :model="$xxxx"/>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="20" class="text-center">No results found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <x-pagination :models="$xxxxs" :appends="$appends ?? null"/>
                </div>
            </div>
        </div>
    </div>
@endsection