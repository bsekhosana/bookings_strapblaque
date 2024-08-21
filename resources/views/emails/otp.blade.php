@component('mail::message', ['theme' => $md_theme ?? []])
# One Time Pin

Dear {{ $user->first_name ?? $user->name ?? $user->title ?? 'user' }},

Please find your **OTP** number below:

@component('mail::panel')
<h1 class="otp">{{ $otp }}</h1>
@endcomponent

{{ $md_theme['name'] ?? config('app.name') }}
@endcomponent
