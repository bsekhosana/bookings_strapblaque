<?php

// Notification: app/Notifications/BookingConfirmed.php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail', 'sms'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Booking Confirmation')
            ->greeting('Hello '.$this->booking->client_name.',')
            ->line('Your booking has been confirmed.')
            ->line('Service: '.$this->booking->service->name)
            ->line('Date & Time: '.$this->booking->start_time->format('F d, Y h:i A'))
            ->line('Thank you for choosing our service!');
    }

    public function toSms($notifiable)
    {
        return 'Your booking for '.$this->booking->service->name.' is confirmed for '.$this->booking->start_time->format('F d, Y h:i A');
    }
}
