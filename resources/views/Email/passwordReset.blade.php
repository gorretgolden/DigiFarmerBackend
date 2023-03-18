@component('mail::message')


DigiFarmer Reset Password

@component('mail::button', ['url' => 'http://localhost:8000/reset-password?token='.$token])
Click here to reset your passord
@endcomponent

Thanks,<br>
DigiFarmer App
@endcomponent
