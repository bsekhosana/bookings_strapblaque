<!-- resources/views/organizations/calendar.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Your Booking Calendar</h2>
        <div id="calendar"></div>
    </div>

    <script src="https://unpkg.com/@fullcalendar/core@5.9.0/main.min.js"></script>
    <script src="https://unpkg.com/@fullcalendar/daygrid@5.9.0/main.min.js"></script>
    <script src="https://unpkg.com/@fullcalendar/timegrid@5.9.0/main.min.js"></script>
    <script src="https://unpkg.com/@fullcalendar/interaction@5.9.0/main.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                editable: true,
                events: '/api/bookings', // Endpoint to fetch booking data
                eventClick: function(info) {
                    // Show modal with booking details or edit option
                    // You can use Bootstrap modals or similar for this
                },
                dateClick: function(info) {
                    // Handle date click to create a new booking
                    // You can show a form in a modal to input booking details
                }
            });

            calendar.render();
        });
    </script>
@endsection
