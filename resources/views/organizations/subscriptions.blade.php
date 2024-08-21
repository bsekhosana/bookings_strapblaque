<!-- resources/views/organizations/subscriptions.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Select a Subscription Plan</h2>
        <div class="row">
            @foreach ($plans as $plan)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">{{ $plan->name }}</div>
                        <div class="card-body">
                            <h4>${{ $plan->price }} / month</h4>
                            <p>{{ $plan->max_bookings }} bookings/month</p>
                            <form action="{{ route('subscription.payment') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                <button type="submit" class="btn btn-primary">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
