@component('mail::message', ['theme' => $md_theme ?? []])
# Test Mail

Mail header image/logo should not be wider than 500px. But also not high, maybe 100px.

Mail header image/logo should usually link to the homepage.

**Theme vars:**
@component('mail::panel')
<pre>{{ json_encode($md_theme, 128) }}</pre>
@endcomponent

---

# Header 1
## Header 2
### Header 3
#### Header 4
##### Header 5
###### Header 6

[This link color should match the primary color]({{ url('/') }}).<br>
**[This link color should match the primary color]({{ url('/') }}).**

@component('mail::button', ['url' => url('/'), 'color' => 'primary'])
Primary
@endcomponent
@component('mail::button', ['url' => url('/'), 'color' => 'success'])
Success
@endcomponent
@component('mail::button', ['url' => url('/'), 'color' => 'error'])
Error
@endcomponent

@component('mail::panel')
<-- This left border should also match the primary color.
@endcomponent

@component('mail::table')
| Laravel       | Table         | Example  |
|:------------- |:-------------:| --------:|
| Col 1 is      | Left-Aligned  | $10      |
| Col 2 is      | Centered      | $20      |
| Col 3 is      | Right-Aligned | $30      |
@endcomponent

# OTP class

@component('mail::panel')
<h1 class="otp">123456</h1>
@endcomponent

Thanks,<br>
{{ $md_theme['name'] ?? config('app.name') }}

@component('mail::subcopy')
This is the subcopy content.
@endcomponent
@endcomponent
