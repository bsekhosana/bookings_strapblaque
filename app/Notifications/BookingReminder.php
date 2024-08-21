<?php

// Example Notification: app/Notifications/BookingReminder.php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingReminder extends Notification implements ShouldQueue
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
            ->subject('Booking Reminder')
            ->greeting('Hello '.$this->booking->client_name.',')
            ->line('This is a reminder for your upcoming booking.')
            ->line('Service: '.$this->booking->service->name)
            ->line('Date & Time: '.$this->booking->start_time->format('F d, Y h:i A'))
            ->line('Thank you for using our service!');
    }

    public function toSms($notifiable)
    {
        // Assuming you have an SMS service integrated
        return 'Reminder: Your booking for '.$this->booking->service->name.' is on '.$this->booking->start_time->format('F d, Y h:i A');
    }
}
