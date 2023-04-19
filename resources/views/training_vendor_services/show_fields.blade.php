<div class="row">


    <div class="col-md-6">


        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md ">

                        <img src="{{ $trainingVendorService->vendor->image ? $trainingVendorService->vendor->image : asset('img/avatar-1.png') }}"
                            class="img-thumbnail rounded-circle shadow-4-strong w-25" />
                    </div>


                    <div class="col-md-12 mt-2">
                        {!! Form::label('name', 'Vendor details:') !!}
                        <p>Name: {{ $trainingVendorService->vendor->vendorname }}</p>
                        <p>Contact: {{ $trainingVendorService->vendor->phone }}</p>
                        <p>Email: {{ $trainingVendorService->vendor->email }}</p>
                    </div>
                </div>




            </div>
        </div>
    </div>






    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">


                    <div class="mb-3">
                        <img class="img-thumbnail w-75" src="{{ URL::asset("$trainingVendorService->image") }}" />
                    </div>


                    <!-- Name Field -->
                    <div class="col-sm-12">
                        {!! Form::label('name', 'Name:') !!}
                        <p>{{ $trainingVendorService->name }}</p>
                    </div>

                    <!-- Vendor Category Id Field -->
                    <div class="col-sm-12">
                        {!! Form::label('vendor_category_id', 'Vendor Category:') !!}
                        <p>{{ $trainingVendorService->vendor_category->name }}</p>
                    </div>
                    <!-- Charge Field -->
                    <div class="col-sm-12">
                        {!! Form::label('charge', 'Charge:') !!}
                        <p>{{ $trainingVendorService->charge }}</p>
                    </div>

                    <!-- Description Field -->
                    <div class="col-sm-12">
                        {!! Form::label('description', 'Description:') !!}
                        <p>{{ $trainingVendorService->description }}</p>
                    </div>



                    <!-- Access Field -->
                    <div class="col-sm-12">
                        {!! Form::label('access', 'Access:') !!}
                        <p>{{ $trainingVendorService->access }}</p>
                    </div>

                    <!-- Is Verified Field -->
                    <div class="col-sm-12">
                        @if ($trainingVendorService->is_verified == 1)
                            <p class="badge rounded-pill bg-success">Verified</p>
                        @else
                            <p class="badge rounded-pill bg-danger"> Not Verified</p>
                        @endif

                    </div>



                    <hr />
                    <div class="row">

                        <!-- Starting Date Field -->
                        <div class="col-sm-3">
                            {!! Form::label('starting_date', 'Starting Date:') !!}
                            <p>{{ $trainingVendorService->starting_date }}</p>
                        </div>

                        <!-- Starting Time Field -->
                        <div class="col-sm-3">
                            {!! Form::label('starting_time', 'Starting Time:') !!}
                            <p>{{ $trainingVendorService->starting_time }}</p>
                        </div>
                        <!-- Ending Date Field -->
                        <div class="col-sm-3">
                            {!! Form::label('ending_date', 'Ending Date:') !!}
                            <p>{{ $trainingVendorService->ending_date }}</p>
                        </div>


                        <!-- Ending Time Field -->
                        <div class="col-sm-3">
                            {!! Form::label('ending_time', 'Ending Time:') !!}
                            <p>{{ $trainingVendorService->ending_time }}</p>
                        </div>
                    </div>

                    <hr />


                    @if (!empty($trainingVendorService->location))
                        <!-- Location Field -->
                        <div class="col-sm-12">
                            {!! Form::label('location', 'Location:') !!}
                            <p>{{ $trainingVendorService->location }}</p>
                        </div>
                    @else
                        <!-- Zoom Details Field -->
                        <div class="col-sm-12">
                            {!! Form::label('zoom_details', 'Zoom Details:') !!}
                            <p>{{ $trainingVendorService->zoom_details }}</p>
                        </div>
                    @endif


                    <!-- Location Field -->
                    <div class="col-sm-12">
                        {!! Form::label('location', 'Location:') !!}
                        <p>{{ $trainingVendorService->location }}</p>
                    </div>


                    <hr />


                    <!-- Created At Field -->
                    <div>
                        {!! Form::label('created_at', 'Created At:') !!}
                        <p>{{ $trainingVendorService->created_at }},
                            {{ $trainingVendorService->created_at->diffForHumans() }}</p>
                    </div>






                </div>
            </div>
        </div>


    </div>


</div>
