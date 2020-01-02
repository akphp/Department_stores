@component('mail::message')
# Hello {{$admin->name}}

Thank you for create an account. Please verify your email using this button:

@component('mail::button', ['url' => url('api/admin/verify', $admin->verification_token)])
Verify Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
