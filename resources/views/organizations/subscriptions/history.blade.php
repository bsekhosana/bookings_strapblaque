<!-- resources/views/organizations/subscriptions/history.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Subscription History</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Plan</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscriptions as $subscription)
                    <tr>
                        <td>{{ $subscription->plan->name }}</td>
                        <td>{{ $subscription->start_date->format('F d, Y') }}</td>
                        <td>{{ $subscription->end_date->format('F d, Y') }}</td>
                        <td>{{ $subscription->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
