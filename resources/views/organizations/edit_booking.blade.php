<!-- resources/views/organizations/edit_booking.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Booking</h2>
        <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="service_id">Service</label>
                <select name="service_id" class="form-control">
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" {{ $booking->service_id == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="client_name">Client Name</label>
                <input type="text" name="client_name" class="form-control" value="{{ $booking->client_name }}" required>
            </div>
            <div class="form-group">
                <label for="client_email">Client Email</label>
                <input type="email" name="client_email" class="form-control" value="{{ $booking->client_email }}">
            </div>
            <div class="form-group">
                <label for="client_phone">Client Phone</label>
                <input type="text" name="client_phone" class="form-control" value="{{ $booking->client_phone }}">
            </div>
            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="datetime-local" name="start_time" class="form-control"
                    value="{{ $booking->start_time->format('Y-m-d\TH:i') }}" required>
            </div>
            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="datetime-local" name="end_time" class="form-control"
                    value="{{ $booking->end_time->format('Y-m-d\TH:i') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Booking</button>
        </form>
    </div>
@endsection
