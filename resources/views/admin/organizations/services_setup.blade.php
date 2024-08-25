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

        .step-tracker .passed {
            color: #10c03c;
            border-color: #10c03c;
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
            <div class="step passed">Step 1: Activate Organization</div>
            <div class="step active">Step 2: Services Setup</div>
            <div class="step">Step 3: Organization Settings</div>
        </div>

        <form method="POST" id='service-form'>
            @csrf
            <br>
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" style="max-height: 180px; max-width: 100%;" alt="Logo">
            </a>
            <br>
            <h1 class="h3 mb-4 mt-5 fw-normal">Add {{ $organization->name }} services</h1>
            @if (count($errors->getBag('default')))
                @foreach ($errors->getBag('default')->getMessages() as $error)
                    <div class="alert alert-danger mb-3 small p-2" role="alert">
                        {{ $error[0] }}
                    </div>
                @endforeach
            @endif

            <!-- Bootstrap Row for responsive design -->
            <div class="text-center">
                <!-- Organization Details Card -->
                <div class="ccol-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h5 mb-3">Service Details</h2>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control shadow" name="name" id="name"
                                    placeholder="Service Name" value="{{ old('name') }}" required>
                                <label for="name">Service Name</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="number" class="form-control shadow" name="duration" id="duration"
                                    placeholder="Service Duration" value="{{ old('duration') }}" required>
                                <label for="duration">Service Duration</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control shadow" name="description" id="description"
                                    placeholder="Service Description" value="{{ old('description') }}" required>
                                <label for="description">Service Description</label>
                            </div>
                        </div>
                        <input type="text" id="organization_id" value="{{ $organization->id }}" hidden>
                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">Create Service</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
        <!-- Placeholder for displaying the added services -->
        <div id="services-list" class="mt-4">
            <!-- Services will be appended here via AJAX -->
        </div>

        <div class="col-12" style="margin-top:3%">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Organization Services
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    {{-- <th scope="col" width="180">UID</th> --}}
                                    <th scope="col">Name</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Action</th>
                                    {{-- <th scope="col" width="170">Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($organization->services as $model)
                                    <tr>
                                        {{-- <td class="cell">{{ $model->uid }}</td> --}}
                                        <td class="cell">{{ $model->name }}</td>
                                        <td class="cell">{{ $model->duration }}</td>
                                        <td class="cell">{{ $model->description }}</td>
                                        <td class="cell">{{ $model->created_at }}</td>
                                        <td class="cell">
                                            <button class="btn btn-danger btn-sm delete-service"
                                                data-id="{{ $model->id }}"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No requests have been made.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Event listener for the form submission to add a new service
            $('#service-form').on('submit', function(e) {
                e.preventDefault();

                // Collect form data
                let formData = {
                    name: $('#name').val(),
                    duration: $('#duration').val(),
                    description: $('#description').val(),
                    organization_id: $('#organization_id').val(),
                };

                // AJAX request to add the service
                $.ajax({
                    url: '{{ route('admin.services.store') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // Add new service to the table
                            $('#organization-services').append(`
                        <tr data-id="${response.service.id}">
                            <td class="cell">${response.service.name}</td>
                            <td class="cell">${response.service.duration}</td>
                            <td class="cell">${response.service.description}</td>
                            <td class="cell">${new Date(response.service.created_at).toLocaleString()}</td>
                            <td class="cell">
                                <button class="btn btn-danger btn-sm delete-service" data-id="${response.service.id}"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    `);

                            // Clear input fields
                            $('#name').val('');
                            $('#duration').val('');
                            $('#description').val('');
                        } else {
                            alert('Failed to add service. Please try again.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });

            // Event listener for deleting a service
            $(document).on('click', '.delete-service', function() {
                let serviceId = $(this).data('id');
                let row = $(this).closest('tr');

                // AJAX request to delete the service
                $.ajax({
                    url: `/admin/services/${serviceId}`,
                    method: 'DELETE',
                    success: function(response) {
                        if (response.success) {
                            row.remove();
                        } else {
                            alert('Failed to delete service. Please try again.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>
