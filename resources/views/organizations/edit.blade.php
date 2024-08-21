<!-- resources/views/admin/organizations/edit.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Edit Organization</h2>
        <form action="{{ route('admin.organizations.update', $organization->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Organization Name</label>
                <input type="text" name="name" class="form-control" value="{{ $organization->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">Organization Email</label>
                <input type="email" name="email" class="form-control" value="{{ $organization->email }}" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control">
                    <option value="Active" {{ $organization->status == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ $organization->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Organization</button>
        </form>
    </div>
@endsection
