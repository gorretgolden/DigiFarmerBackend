@extends('layouts.app')

@section('content')
    <div class="mx-3">
        <div class="row">

        </div>
        <div class="row mt-5">
            <div class="col-md-2">
            </div>

            <div class="col-md-8">
                <div class="card bg-light">
                    <div class="card-header">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-3"></div>

                                <div class="col-md-5 d-flex align-items-center justify-content-center">
                                    <img style="width: 20%" class="mx-auto mb-3"
                                        src="https://img.freepik.com/free-icon/farmer_318-210094.jpg?size=338&ext=jpg&ga=GA1.2.1085104606.1668665649&semt=ais" />

                                        <br/>

                                </div>
                                <br/>
                                <div class="col-md-3">

                                </div>

                            </div>
                            <div class="row">

                                <div class="col-md-3"></div>


                                <div class="col-md-12 d-flex align-items-center justify-content-center">

                                    <h5>Username:  <span class="text-green">{{$admin_details->username}} </span>Email:  <span class="text-green">{{$admin_details->email}}</span>
                                        Contact: <span class="text-green">{{$admin_details->phone}}</span></h5>

                                </div>
                                <div class="col-md-3">

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="col-md-2">
            </div>






        </div>



    </div>
    </div>
@endsection
