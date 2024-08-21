@extends('layouts.admin')

@section('page_title', 'Admins')

@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-fw fa-list"></i></div>
                            Admins
                        </h1>
                        <div class="page-header-subtitle">
                            Listing all admins
                        </div>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">
                        <a class="btn btn-light" href="{{ \App\Models\Admin::createRoute() }}"><i class="fas fa-fw fa-plus me-1"></i> Add Admin</a>
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
                            <select id="super_admin" name="super_admin" class="form-control">
                                <option value="">Super Admin</option>
                                @foreach(['yes' => 'Yes', 'no' => 'No'] as $value => $title)
                                    @if($value === old('super_admin'))
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
                                <th scope="col" class="d-none d-md-table-cell text-center" width="80"><abbr title="Super Admin">Super</abbr></th>
                                <th scope="col">Name</th>
                                <th scope="col" class="d-none d-sm-table-cell">Contact</th>
                                <th scope="col" class="d-none d-xl-table-cell text-center" width="80"><abbr title="Two-Factor Authentication">2FA</abbr></th>
                                <th scope="col" class="d-none d-xl-table-cell">Last Seen</th>
                                <th scope="col" width="140">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($admins as $admin)
                                <tr>
                                    <td class="cell d-none d-md-table-cell text-center">{!! iconForBool($admin->super_admin) !!}</td>
                                    <td class="cell">{{ $admin->name }}</td>
                                    <td class="cell d-none d-sm-table-cell small">
                                        <i class="fas fa-fw fa-envelope me-1"></i> {{ $admin->email ?? 'N/A' }}<br>
                                        <i class="fas fa-fw fa-phone me-1"></i> {{ $admin->mobile ?? 'N/A' }}
                                    </td>
                                    <td class="cell d-none d-xl-table-cell text-center">{!! iconForBool($admin->tfa) !!}</td>
                                    <td class="cell d-none d-xl-table-cell">{{ $admin->last_seen }}</td>
                                    <td class="cell">
                                        <x-crud-actions :model="$admin"/>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="20" class="text-center">No results found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <x-pagination :models="$admins" :appends="$appends"/>
                </div>
            </div>
        </div>
    </div>
@endsection