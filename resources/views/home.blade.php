@extends('layouts.app')

@section('content')
    <div class="mx-3">
        <div class="row">
            {{-- <div class="col-md-12 shadow-sm bg-light mt-3">
                <h3>Welcome to DigiFarmer Dashboard</h3>
            </div> --}}
        </div>
        <div class="row mt-5">

            <div class="col-md-3">
                <div class="card bg-maroon">
                    <div class="card-header">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 float-left">
                                    <img style="width: 80%"
                                        src="https://img.freepik.com/free-icon/farmer_318-210094.jpg?size=338&ext=jpg&ga=GA1.2.1085104606.1668665649&semt=ais" />

                                </div>
                                <div class="float-right mt-3">

                                    <h2>{{$total_farmers}}</h2>
                                    <p>Farmers</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-3">
                <div class="card bg-primary">
                    <div class="card-header">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 float-left">
                                    <img style="width: 80%"
                                        src="https://img.freepik.com/free-icon/gardener_318-403002.jpg?size=338&ext=jpg&ga=GA1.2.1085104606.1668665649&semt=ais" />

                                </div>
                                <div class="float-right  mt-3">

                                    <h2>{{$total_sellers}}</h2>
                                    <p>Vendors</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="col-md-3">
                <div class="card bg-orange text-white">
                    <div class="card-header">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 float-left">
                                    <img style="width: 80%"
                                        src="https://cdn-icons-png.flaticon.com/128/9167/9167461.png" />

                                </div>
                                <div class="float-right  mt-3 text-white">

                                    <h2>{{$total_farms}}</h2>
                                    <p>Buyers</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>


             <div class="col-md-3">
                <div class="card bg-success">
                    <div class="card-header">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 float-left">
                                    <img style="width: 80%"
                                        src="https://img.freepik.com/free-icon/corn_318-758247.jpg?size=338&ext=jpg&ga=GA1.2.1085104606.1668665649&semt=ais" />

                                </div>
                                <div class="float-right  mt-3">

                                    <h2>{{$total_crops}}</h2>
                                    <p>Crops</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>




        </div>
        <div class="row mt-5">

            <div class="col-md-3">
                <div class="card bg-gray">
                    <div class="card-header">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 float-left">
                                    <img style="width: 80%"
                                        src="https://cdn-icons-png.flaticon.com/128/5970/5970296.png" />

                                </div>
                                <div class="float-right  mt-3">

                                    <h2>{{$total_crops_on_sale}}</h2>
                                    <p>Crops On Sale</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-3">
                <div class="card bg-olive">
                    <div class="card-header">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 float-left">
                                    <img style="width: 80%"
                                        src="https://cdn-icons-png.flaticon.com/128/4388/4388935.png" />

                                </div>
                                <div class="float-right  mt-3">

                                    <h2>{{$total_animals}}</h2>
                                    <p>Animals</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-3">
                <div class="card bg-navy">
                    <div class="card-header">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 float-left">
                                    <img style="width: 80%"
                                        src="https://img.freepik.com/free-icon/farm_318-194682.jpg?size=338&ext=jpg&ga=GA1.2.1085104606.1668665649&semt=ais" />

                                </div>
                                <div class="float-right  mt-3">

                                    <h2>{{$total_farms}}</h2>
                                    <p>Farms</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-3">
                <div class="card bg-gray">
                    <div class="card-header">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 float-left">
                                    <img style="width: 80%"
                                        src="https://cdn-icons-png.flaticon.com/128/6815/6815043.png" />

                                </div>
                                <div class="float-right  mt-3">

                                    <h2>{{$total_crop_orders}}</h2>
                                    <p>Crop Orders</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>




            {{-- <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-header">
                        <div class="card-body">


                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="card bg-gray">
                    <div class="card-header">
                        <div class="card-body">

                        </div>
                    </div>
                </div>

            </div> --}}



        </div>
    </div>
@endsection
