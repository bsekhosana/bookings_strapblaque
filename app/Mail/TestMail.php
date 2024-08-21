<?php

namespace App\Mail;

use App\Traits\MarkdownTheme;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use MarkdownTheme, SerializesModels;

    /**
     * Build the message.
     */
    public function build(): Mailable
    {
        return $this->theme('default')
            ->markdown('emails.test');
    }
}
