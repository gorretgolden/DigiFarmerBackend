@component('mail::message')

# Hello {{ $maildata['username'] }}!

You are receiving this email because we received a password reset request for your account.
This password reset link will expire in 60 minutes.
If you did not request a password reset, no further action is required.

@component('mail::button', ['url' => 'http://localhost:8000/reset-password?token='.$maildata['token']])
Click here to reset your password
@endcomponent

Thanks,<br>
DigiFarmer App
@endcomponent
