<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Notifications\BookingConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Bookings",
 *     description="Operations related to bookings"
 * )
 */
class BookingController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/bookings",
     *     tags={"Bookings"},
     *     summary="List all bookings",
     *     description="Returns all bookings for the authenticated organization.",
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function index(Request $request)
    {
        $organization = Auth::user()->organization;
        $bookings = Booking::where('organization_id', $organization->id)->get();

        $events = $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->service->name.' - '.$booking->client_name,
                'start' => $booking->start_time->toIso8601String(),
                'end' => $booking->end_time->toIso8601String(),
                'url' => route('bookings.edit', $booking->id), // Link to an edit form
            ];
        });

        return response()->json($events);
    }

    /**
     * @OA\Post(
     *     path="/api/bookings",
     *     tags={"Bookings"},
     *     summary="Create a new booking",
     *     description="Creates a new booking for the authenticated organization.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="service_id", type="integer", example=1),
     *             @OA\Property(property="client_name", type="string", example="John Doe"),
     *             @OA\Property(property="client_email", type="string", example="johndoe@example.com"),
     *             @OA\Property(property="client_phone", type="string", example="555-1234"),
     *             @OA\Property(property="start_time", type="string", format="date-time", example="2024-08-01T09:00:00Z"),
     *             @OA\Property(property="end_time", type="string", format="date-time", example="2024-08-01T10:00:00Z")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Booking created"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
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

        return response()->json($booking, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/bookings/{id}",
     *     tags={"Bookings"},
     *     summary="Update a booking",
     *     description="Updates the details of a specific booking.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="service_id", type="integer", example=1),
     *             @OA\Property(property="client_name", type="string", example="John Doe"),
     *             @OA\Property(property="client_email", type="string", example="johndoe@example.com"),
     *             @OA\Property(property="client_phone", type="string", example="555-1234"),
     *             @OA\Property(property="start_time", type="string", format="date-time", example="2024-08-01T09:00:00Z"),
     *             @OA\Property(property="end_time", type="string", format="date-time", example="2024-08-01T10:00:00Z"),
     *             @OA\Property(property="status", type="string", example="Confirmed")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Booking updated successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Booking not found"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/bookings/{id}",
     *     tags={"Bookings"},
     *     summary="Delete a booking",
     *     description="Deletes a specific booking.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Booking deleted successfully"),
     *     @OA\Response(response=404, description="Booking not found"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully!');
    }
}
