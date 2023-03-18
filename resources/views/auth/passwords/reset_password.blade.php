<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | Password Reset</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css"
        integrity="sha512-mxrUXSjrxl8vm5GwafxcqTrEwO1/oBNU25l20GODsysHReZo4uhVISzAKzaABH6/tTfAxZrY2FprmeAP5UZY8A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css"
        integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg=="
        crossorigin="anonymous" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="hold-transition login-page ">
    <div class="login-box">
        <div class="flex-center position-ref full-height">
            {{-- <div class="login-logo">
        <a href="#"><b>DigiFarmer</b></a>
    </div> --}}

            <div class="card p-2">
                <div class="card-body login-card-body">

                    <form class="form-container" action="{{ route('update-password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5>Reset Your Password</h5>

                        <div class="input-group mb-3">
                            <input name="email" placeholder="Enter email" value="{{ request()->get('email') }}"
                                class="form-control @error('email') is-invalid @enderror">
                        </div>
                        {{--
                <input type="hidden" name="email" value="{{ $email }} "/> --}}

                        <div class="input-group mb-3">
                            <input name="password" placeholder="Enter new password"
                                class="form-control @error('password') is-invalid @enderror">
                        </div>
                        <div class="input-group mb-3">
                            <input name="password_confirmation" placeholder="Confirm new password" class="form-control">
                        </div>





                        <input hidden name="token" placeholder="token" value="{{ request()->get('token') }}">

                        <button type="submit" class="btn btn-success btn-block">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
