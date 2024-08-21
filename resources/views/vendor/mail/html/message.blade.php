@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['theme' => ($theme ?? null)])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
{{ $theme['name'] ?? config('app.name') }} © {{ date('Y') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
