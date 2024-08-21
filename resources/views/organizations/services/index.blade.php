<!-- resources/views/organizations/services/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Manage Services</h2>
        <a href="{{ route('services.create') }}" class="btn btn-primary mb-3">Add New Service</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Duration</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->duration }} minutes</td>
                        <td>${{ $service->price }}</td>
                        <td>
                            <a href="{{ route('services.edit', $service->id) }}" class="btn btn-info btn-sm">Edit</a>
                            <form action="{{ route('services.destroy', $service->id) }}" method="POST"
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
