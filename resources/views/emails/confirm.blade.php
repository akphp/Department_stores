@component('mail::message')
# Hello {{$admin->name}}

You changed your email, so we need to verify this new address. Please use the button below:

@component('mail::button', ['url' => url('api/admin/verify', $admin->verification_token)])
Verify Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
