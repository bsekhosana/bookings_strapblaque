<!-- resources/views/admin/organizations/index.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>All Organizations</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Subscription Plan</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($organizations as $organization)
                    <tr>
                        <td>{{ $organization->name }}</td>
                        <td>{{ $organization->email }}</td>
                        <td>{{ $organization->status }}</td>
                        <td>{{ $organization->subscriptions->plan->name }}</td>
                        <td>
                            <a href="{{ route('admin.organizations.show', $organization->id) }}"
                                class="btn btn-info btn-sm">View</a>
                            <form action="{{ route('admin.organizations.destroy', $organization->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
