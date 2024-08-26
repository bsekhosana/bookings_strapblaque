<!DOCTYPE html>
<html lang="en-ZA" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f9322c" />
    <title>Organization Staff</title>
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

        /* Style for ul and li to resemble table format */
        .services-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .services-list li {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding: 10px;
        }

        .service-item {
            flex: 1;
            padding: 5px;
        }

        .service-actions {
            flex: 0;
        }

        .no-services {
            text-align: center;
            padding: 20px;
            font-style: italic;
            color: #999;
        }
    </style>
</head>

<body class="text-center">
    <main class="form-signin m-auto" style="width:80%">
        <br>
        <!-- Step Tracker -->
        <div class="step-tracker">
            <div class="step passed">Step 1: Activate Organization</div>
            <div class="step passed">Step 2: Services Setup</div>
            <div class="step active">Step 3: Add Staff</div>
            <div class="step">Step 4: Organization Settings</div>
        </div>

        <form method="POST" id='service-form'>
            @csrf
            <br>
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" style="max-height: 180px; max-width: 100%;" alt="Logo">
            </a>
            <br>
            <h1 class="h3 mb-4 mt-5 fw-normal">Add {{ $organization->name }} staff members</h1>
            @if (count($errors->getBag('default')))
                @foreach ($errors->getBag('default')->getMessages() as $error)
                    <div class="alert alert-danger mb-3 small p-2" role="alert">
                        {{ $error[0] }}
                    </div>
                @endforeach
            @endif


            <!-- Bootstrap Row for responsive design -->
            <div class="row">
                <!-- Organization Details Card -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h5 mb-3">Staff Details</h2>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control shadow" name="position" id="position"
                                    placeholder="Position" value="{{ old('position') }}" required>
                                <label for="position">Position</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control shadow" name="first_name" id="first_name"
                                    placeholder="First Name" value="{{ old('duration') }}" required>
                                <label for="first_name">First Name</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control shadow" name="last_name" id="last_name"
                                    placeholder="Last Name" value="{{ old('last_name') }}" required>
                                <label for="last_name">Last Name</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="email" class="form-control shadow" name="email" id="email"
                                    placeholder="Email" value="{{ old('email') }}" required>
                                <label for="email">Email</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control shadow" name="mobile" id="mobile"
                                    placeholder="Mobile" value="{{ old('mobile') }}" required>
                                <label for="mobile">Mobile</label>
                            </div>
                            <div class="row mb-3">
                                <div class="offset-md-4 col-md-7">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="is_bookable" name="is_bookable" value="0"
                                            {{ old('is_bookable', 0) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="example-switch">Is Bookable</label>
                                    </div>
                                    @error('example-switch')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <input type="text" id="organization_id" value="{{ $organization->id }}" hidden>
                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">Add Staff member</button>
                        </div>
                    </div>
                </div>

                <!-- Admin Details Card -->
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                Staff Members
                            </div>
                            <div class="card-body">
                                <!-- Placeholder for displaying the added services -->
                                <ul id="services-ul-list" class="services-list">
                                    @forelse($organization->staff as $model)
                                        <li data-id="{{ $model->id }}">
                                            <span class="service-item">{{ $model->organization_title }}</span>
                                            <span class="service-item">{{ $model->first_name }}
                                                {{ $model->last_name }}</span>

                                            <span
                                                class="service-item">{{ $model->is_bookable ? 'Can Book' : 'Can\'t Book' }}</span>
                                            <span class="service-actions">
                                                <button type="button" class="btn btn-danger btn-sm delete-service"
                                                    data-id="{{ $model->id }}"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </span>
                                        </li>
                                    @empty
                                        <li class="no-services">No staff members have been added yet.</li>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="card-footer">
                                <button class="btn"
                                    style=" background-color: green; {{ count($organization->staff) == 0 ? 'display:none;' : '' }}"
                                    id="next"
                                    onclick="window.location.href='{{ route('admin.organization.settings') }}'"
                                    type="button">Confirm Staff Member(s)</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>

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
                    title: $('#position').val(),
                    first_name: $('#first_name').val(),
                    last_name: $('#last_name').val(),
                    email: $('#email').val(),
                    mobile: $('#mobile').val(),
                    is_bookable: $('#is_bookable').prop('checked') ? 1 : 0,
                    organization_id: $('#organization_id').val(),
                };

                console.log('formData', formData);

                // AJAX request to add the service
                // AJAX request to add the service
                $.ajax({
                    url: '{{ route('admin.staff.store') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // Remove the 'No services' message if present
                            $('.no-services').remove();
                            // Add new service to the list
                            var canBook = response.staff.id == 0 ? 'Can Book' : 'Cant Book';
                            $('#services-ul-list').append(`
                                <li data-id="${response.staff.id}">
                                    <span class="service-item">${response.staff.organization_title}</span>
                                    <span class="service-item">${response.staff.first_name} ${response.staff.last_name}</span>
                                    <span class="service-item">${response.staff.is_bookable ? 'Can Book' : 'Can\'t Book'}</span>
                                    <span class="service-actions">
                                        <button class="btn btn-danger btn-sm delete-service" data-id="${canBook}"><i class="fas fa-trash-alt"></i></button>
                                    </span>
                                </li>
                            `);

                            document.getElementById('next').style.display = null;

                            // Clear input fields
                            $('#position').val('');
                            $('#first_name').val('');
                            $('#last_name').val('');
                            $('#email').val('');
                            $('#mobile').val('');
                            $('#is_bookable').val('');

                        } else {
                            alert('Failed to add staff member. Please try again.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });

            // Event listener for deleting a service
            $(document).on('click', '.delete-service', function() {
                let staffId = $(this).data('id');
                let listItem = $(this).closest('li');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                console.log('/admin/organization_staff/' + staffId);
                $.ajax({
                    url: `/admin/organization_staff/${staffId}`,
                    method: 'DELETE',
                    success: function(response) {
                        console.log('response', response);
                        if (response.success) {
                            listItem.remove();
                            // Check if list is empty and show 'No services' message if necessary
                            if ($('#services-ul-list li').length === 0) {
                                $('#services-ul-list').append(
                                    '<li class="no-services">No staff members have been added yet.</li>'
                                );
                                document.getElementById('next').style.display = 'none';
                            }
                        } else {
                            alert('Failed to delete staff member. Please try again.');
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
