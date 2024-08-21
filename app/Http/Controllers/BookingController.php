<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Notifications\BookingConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $organization = Auth::user()->organization;
        $bookings = Booking::where('organization_id', $organization->id)->get();

        $events = $bookings->map(function($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->service->name . ' - ' . $booking->client_name,
                'start' => $booking->start_time->toIso8601String(),
                'end' => $booking->end_time->toIso8601String(),
                'url' => route('bookings.edit', $booking->id), // Link to an edit form
            ];
        });

        return response()->json($events);
    }


    public function store(Request $request)
    {
        $organization = Auth::user()->organization;

        // Check if the organization has exceeded its booking limit
        if ($organization->subscriptions->plan->max_bookings > 0 && $organization->bookings()->count() >= $organization->subscriptions->plan->max_bookings) {
            return response()->json(['error' => 'Booking limit reached'], 400);
        }

        $booking = new Booking;
        $booking->organization_id = $organization->id;
        $booking->subscription_id = $organization->subscriptions->id;
        $booking->service_id = $request->input('service_id');
        $booking->client_name = $request->input('client_name');
        $booking->client_email = $request->input('client_email');
        $booking->client_phone = $request->input('client_phone');
        $booking->start_time = $request->input('start_time');
        $booking->end_time = $request->input('end_time');
        $booking->status = 'Scheduled';
        $booking->save();

        // Send confirmation notification
        $booking->notify(new BookingConfirmed($booking));

        return response()->json($booking);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->service_id = $request->input('service_id');
        $booking->client_name = $request->input('client_name');
        $booking->client_email = $request->input('client_email');
        $booking->client_phone = $request->input('client_phone');
        $booking->start_time = $request->input('start_time');
        $booking->end_time = $request->input('end_time');
        $booking->status = $request->input('status');
        $booking->save();

        return response()->json($booking);
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully!');
    }

}
