@extends('layouts.admin')

@section('page_title', 'Contact Forms')

@section('content')
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-fw fa-list"></i></div>
                            Contact Forms
                        </h1>
                        <div class="page-header-subtitle">
                            Listing all contact forms
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <form method="get">
                    <div class="row g-2">
                        <div class="col-md-8 col-xl-10">
                            <div class="input-group input-group-joined">
                                <span class="input-group-text">
                                    <i class="fas fa-fw fa-magnifying-glass"></i>
                                </span>
                                <input type="text" class="form-control ps-0" id="search" name="search" placeholder="Search" value="{{ old('search') }}">
                            </div>
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
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Created At</th>
                                <th scope="col" width="110">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contact_forms as $contact_form)
                                <tr>
                                    <td class="cell">{{ $contact_form->name }}</td>
                                    <td class="cell">{{ $contact_form->email }}</td>
                                    <td class="cell">@humanDateTime($contact_form->created_at)</td>
                                    <td class="cell">
                                        <x-crud-actions :model="$contact_form"/>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="20" class="text-center">No results found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <x-pagination :models="$contact_forms" :appends="$appends"/>
                </div>
            </div>
        </div>
    </div>
@endsection