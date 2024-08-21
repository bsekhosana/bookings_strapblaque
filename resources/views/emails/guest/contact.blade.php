@component('mail::message', ['theme' => $md_theme ?? []])
Hi {{ ucwords($form->name) }},

Thank you for getting in touch, we will respond as soon as possible.

Kind regards,<br>
{{ config('app.name') }}

@component('mail::subcopy')
<small><i>Please do not reply to this email, this email was sent from an unattended mailbox.</i></small>
@endcomponent
@endcomponent
