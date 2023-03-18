@extends('layout')

@section('content')
    <h4>DigiFarmer Password Reset</h4>


    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">

                        <p>
                            Hello!
                            You are receiving this email because we received a password reset request for your account.


                            This password reset link will expire in 60 minutes.

                            If you did not request a password reset, no further action is required.


                        </p>
                        <a href="{{ route('reset.password.get', $token) }}">Reset Password</a>
                        <p>
                            If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into
                            your web browser: {{ $token }}</p>

                            <p>

                        Regards,
                        DigiFarmer
                            </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
