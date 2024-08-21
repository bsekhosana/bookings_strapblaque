<?php

// Example Job: app/Jobs/SendBookingReminders.php

namespace App\Jobs;

use App\Models\Booking;
use App\Notifications\BookingReminder;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendBookingReminders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Get all bookings that are scheduled for the next day
        $bookings = Booking::where('start_time', '>=', Carbon::now()->addDay()->startOfDay())
            ->where('start_time', '<=', Carbon::now()->addDay()->endOfDay())
            ->get();

        foreach ($bookings as $booking) {
            Notification::route('mail', $booking->client_email)
                ->route('sms', $booking->client_phone)
                ->notify(new BookingReminder($booking));
        }
    }
}
