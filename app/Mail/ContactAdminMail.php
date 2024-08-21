<?php

namespace App\Mail;

use App\Models\ContactForm;
use App\Traits\MarkdownTheme;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactAdminMail extends Mailable implements ShouldQueue
{
    use MarkdownTheme, Queueable, SerializesModels;

    public ContactForm $form;

    /**
     * Create a new message instance.
     */
    public function __construct(ContactForm $form)
    {
        $this->queue = 'notifications';
        $this->delay = 0;

        $this->form = $form;
    }

    /**
     * Build the message.
     */
    public function build(): Mailable
    {
        $this->to(\Config::get('mail.contact.address'));
        $this->replyTo($this->form->email, $this->form->name);
        $this->subject($this->form->subject ?? 'Website Contact Form');
        $this->theme('default');

        return $this->markdown('emails.admin.contact');
    }
}
