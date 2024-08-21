<!-- resources/views/admin/organizations/show.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>{{ $organization->name }}</h2>
        <ul class="list-group">
            <li class="list-group-item"><strong>Email:</strong> {{ $organization->email }}</li>
            <li class="list-group-item"><strong>Status:</strong> {{ $organization->status }}</li>
            <li class="list-group-item"><strong>Subscription Plan:</strong> {{ $organization->subscriptions->plan->name }}
            </li>
            <li class="list-group-item"><strong>Active Bookings:</strong> {{ $organization->bookings()->count() }}</li>
        </ul>

        <div class="mt-4">
            <a href="{{ route('admin.organizations.edit', $organization->id) }}" class="btn btn-primary">Edit Organization</a>
        </div>
    </div>
@endsection
