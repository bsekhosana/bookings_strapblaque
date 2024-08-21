<!-- resources/views/organizations/subscription_details.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Your Subscription Details</h2>
        <ul class="list-group">
            <li class="list-group-item">Plan: {{ $subscription->plan->name }}</li>
            <li class="list-group-item">Price: ${{ $subscription->plan->price }} / month</li>
            <li class="list-group-item">Max Bookings: {{ $subscription->plan->max_bookings }} / month</li>
            <li class="list-group-item">Remaining Bookings:
                {{ $subscription->plan->max_bookings - $subscription->organization->bookings()->count() }}</li>
            <li class="list-group-item">Subscription Start Date: {{ $subscription->start_date->format('F d, Y') }}</li>
            <li class="list-group-item">Subscription End Date: {{ $subscription->end_date->format('F d, Y') }}</li>
        </ul>
        <div class="mt-4">
            <a href="{{ route('subscription.plans') }}" class="btn btn-primary">Change Plan</a>
        </div>
    </div>
@endsection
