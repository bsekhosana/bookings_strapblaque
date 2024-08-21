<?php

namespace App\Notifications;

use App\Mail\OTPMail;
use Emotality\Panacea\PanaceaMobileSms;
use Emotality\Panacea\PanaceaMobileSmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notification;

class OTP extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public int $otp)
    {
        $this->queue = 'notifications';
        $this->delay = 0;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(User $notifiable): array
    {
        $channels = [];

        if (\DB::getSchemaBuilder()->hasTable('notifications')) {
            $channels[] = 'database';
        }

        if ($notifiable->{\App\Helpers\OTP::$email_column} ?? false) {
            $channels[] = 'mail';
        }

        if ($notifiable->{\App\Helpers\OTP::$mobile_column} ?? false) {
            $channels[] = PanaceaMobileSmsChannel::class;
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $notifiable): OTPMail
    {
        return new OTPMail($notifiable, $this->otp);
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(User $notifiable): PanaceaMobileSms
    {
        return (new PanaceaMobileSms)->message(
            sprintf('%s OTP: %d', config('app.name'), $this->otp)
        );
    }

    /**
     * Get the array representation of the notification.
     */
    public function toDatabase(User $notifiable): array
    {
        // Note: Do not include the OTP in DB notifications!
        return [
            'short' => 'A new login OTP has been sent.',
            'long'  => 'A new login OTP has been sent.',
            'html'  => 'A new login OTP has been sent.',
            'url'   => null,
        ];
    }
}
