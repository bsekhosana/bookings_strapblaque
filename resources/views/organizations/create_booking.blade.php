<!-- resources/views/organizations/create_booking.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create New Booking</h2>
        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="service_id">Service</label>
                <select name="service_id" class="form-control">
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="client_name">Client Name</label>
                <input type="text" name="client_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="client_email">Client Email</label>
                <input type="email" name="client_email" class="form-control">
            </div>
            <div class="form-group">
                <label for="client_phone">Client Phone</label>
                <input type="text" name="client_phone" class="form-control">
            </div>
            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="datetime-local" name="start_time" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="datetime-local" name="end_time" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Booking</button>
        </form>
    </div>
@endsection
