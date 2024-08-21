<!-- resources/views/admin/reports/subscriptions.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Subscription Overview</h2>
        <ul class="list-group">
            <li class="list-group-item"><strong>Total Active Subscriptions:</strong> {{ $totalActiveSubscriptions }}</li>
            <li class="list-group-item"><strong>Subscriptions Nearing Limit:</strong> {{ $subscriptionsNearingLimit }}</li>
            <li class="list-group-item"><strong>Renewals Due Soon:</strong> {{ $renewalsDueSoon }}</li>
        </ul>
    </div>
@endsection
