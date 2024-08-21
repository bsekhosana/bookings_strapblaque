<?php

namespace App\Mail;

use App\Traits\MarkdownTheme;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Auth\User;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OTPMail extends Mailable
{
    use MarkdownTheme, Queueable, SerializesModels;

    /**
     * Admin that is getting the OTP.
     */
    public User $user;

    /**
     * The OTP.
     */
    public string $otp;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, int $otp)
    {
        $this->queue = 'notifications';
        $this->delay = 0;

        $this->user = $user;
        $this->otp = strval($otp);
    }

    /**
     * Build the message.
     */
    public function build(): Mailable
    {
        $this->to($this->user);
        $this->subject(sprintf('%s OTP', config('app.name')));
        $this->theme('default');

        return $this->markdown('emails.otp');
    }
}
