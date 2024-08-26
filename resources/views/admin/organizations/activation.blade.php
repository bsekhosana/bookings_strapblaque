<!DOCTYPE html>
<html lang="en-ZA" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f9322c" />
    <title>Organization Activation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    @vite(['resources/js/shared/theme.js', 'resources/js/guest.js'])
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="48x48" href="/favicon-48x48.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <style>
        .step-tracker {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
            max-width: 80%;
            margin: auto;
        }

        .step-tracker .step {
            flex: 1;
            text-align: center;
            font-weight: bold;
            padding: 10px;
            border-bottom: 4px solid #ddd;
        }

        .step-tracker .active {
            color: #f9322c;
            border-color: #f9322c;
        }

        .pricing-section {
            max-width: 80%;
            margin: 20px auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .pricing-card {
            flex: 0 0 30%;
            margin: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
            transition: transform 0.3s ease;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
        }

        .pricing-card .card-body {
            padding: 20px;
        }

        .pricing-card h5 {
            margin-bottom: 15px;
            font-size: 1.5rem;
            color: #333;
        }

        .pricing-card .card-text {
            margin-bottom: 10px;
            font-size: 1rem;
            color: #666;
        }

        .pricing-card .card-price {
            font-size: 2rem;
            color: #f9322c;
            margin: 20px 0;
        }

        .pricing-card .btn {
            background-color: #f9322c;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
        }

        @media (max-width: 768px) {
            .pricing-card {
                flex: 0 0 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>

<body class="text-center">
    <main class="form-signin m-auto" style="width:80%">
        <br>
        <!-- Step Tracker -->
        <div class="step-tracker">
            <div class="step active">Step 1: Activate Organization</div>
            <div class="step">Step 2: Services Setup</div>
            <div class="step">Step 3: Add Staff</div>
            <div class="step">Step 4: Organization Settings</div>
        </div>
        <br>
        <a href="javascript:void(0)">
            <img src="{{ asset('images/logo.png') }}" style="max-height: 180px; max-width: 100%;" alt="Logo">
        </a>
        <h1 class="h3" style="margin-bottom: 10px; margin-top: 20px;">Select a Subscription Plan</h1>
        @if (count($errors->getBag('default')))
            @foreach ($errors->getBag('default')->getMessages() as $error)
                <div class="alert alert-danger mb-3 small p-2" role="alert">
                    {{ $error[0] }}
                </div>
            @endforeach
        @endif

        <!-- Subscription Plans Section -->
        {{-- <br> --}}
        <div class="pricing-section">
            @foreach ($plans as $plan)
                {{-- <form method="POST" action="{{ route('admin.organization.activate') }}"> --}}
                @csrf
                <div class="pricing-card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $plan->name }}</h5>
                        <p class="card-text">Max Bookings:
                            {{ $plan->max_bookings == 0 ? 'Unlimited' : $plan->max_bookings }}</p>
                        <p class="card-text">SMS Notifications: {{ $plan->has_sms_notifications ? 'Yes' : 'No' }}
                        </p>
                        <p class="card-text">Email Notifications:
                            {{ $plan->has_email_notifications ? 'Yes' : 'No' }}
                        </p>
                        <p class="card-text">Duration: {{ $plan->duration_in_days }} days</p>
                        <h3 class="card-price">${{ number_format($plan->price, 2) }}/pm</h3>
                        <form id="logout-form" action="{{ route('admin.organization.activate') }}" method="POST">
                            @csrf
                            <input type="text" hidden value="{{ $plan->id }}" name="plan_id">
                            <button class="btn btn-primary" type="submit">Choose Plan</button>
                        </form>

                    </div>
                </div>
                {{-- </form> --}}
            @endforeach
        </div>
        <br>
        <a style="width:20%" class="btn btn-primary" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <div class="dropdown-item-icon">Logout <i class="fas fa-fw fa-arrow-right-from-bracket"></i></div>
        </a>
        <p class="mt-5 mb-3 text-muted small">{{ config('app.name') }} &copy; {{ date('Y') }}. All rights
            reserved.</p>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </main>
</body>

</html>
