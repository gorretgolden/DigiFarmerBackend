<div class="row">


    <div class="col-md-6">


        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md ">

                        <img src="{{ $agronomistVendorService->user->image ? $agronomistVendorService->user->image : asset('img/avatar-1.png') }}"
                            class="img-thumbnail rounded-circle shadow-4-strong w-25" />
                    </div>


                    <div class="col-md-12 mt-2">
                        {!! Form::label('name', 'Vendor details:') !!}
                        <p>Name: {{ $agronomistVendorService->user->username }}</p>
                        <p>Contact: {{ $agronomistVendorService->user->phone }}</p>
                        <p>Email: {{ $agronomistVendorService->user->email }}</p>
                    </div>
                </div>




            </div>
        </div>
    </div>






    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">


                    <div>
                        <img class="img-thumbnail w-75" src="{{ URL::asset("$agronomistVendorService->image") }}" />
                    </div>


                    <!-- Name Field -->
                    <div class="d-inline">
                        {!! Form::label('name', 'Name:') !!}
                        <p>{{ $agronomistVendorService->name }}</p>
                    </div>


                    <div class="col-sm-12">
                        {!! Form::label('expertise', 'Expertise:') !!}
                        <p>{{ $agronomistVendorService->expertise }}</p>
                    </div>

                    <!-- Charge Field -->
                    <div class="col-sm-12">
                        {!! Form::label('charge', 'Charge:') !!}
                        <p> {{ $agronomistVendorService->charge_unit }}{{ $agronomistVendorService->charge }}</p>
                    </div>




                    <!-- Availability Field -->
                    <div class="col-sm-12">
                        {!! Form::label('availability', 'Availability:') !!}
                        <p>{{ $agronomistVendorService->availability }}</p>
                    </div>

                    <!-- Description Field -->
                    <div class="col-sm-12">
                        {!! Form::label('description', 'Description:') !!}
                        <p>{{ $agronomistVendorService->description }}</p>
                    </div>


                    <!-- Vendor Category Id Field -->
                    <div class="col-sm-12">
                        {!! Form::label('vendor_category_id', 'Vendor Category:') !!}
                        <p>{{ $agronomistVendorService->vendor_category->name }}</p>
                    </div>



                    <!-- status Field -->
                    <div>
                        {!! Form::label('status', 'Status:') !!}
                        <p class="badge rounded-pill bg-success">{{ $agronomistVendorService->status }}</p>
                        @if ($agronomistVendorService->is_verified == 1)
                            <p class="badge rounded-pill bg-success">Verified</p>
                        @else
                            <p class="badge rounded-pill bg-danger">Not verified</p>
                        @endif


                    </div>



                    <!-- Description Field -->
                    <div class="col-sm-12">
                        {!! Form::label('description', 'Description:') !!}
                         <p>{{ $agronomistVendorService->description }}</p>


                    </div>



                    @if (!empty($agronomistVendorService->location))
                        <!-- Location Field -->
                        <div class="col-sm-12">
                            {!! Form::label('location', 'Location:') !!}
                            <p>{{ $agronomistVendorService->location }}</p>
                        </div>
                    @else
                        <!-- Zoom Details Field -->
                        <div class="col-sm-12">
                            {!! Form::label('zoom_details', 'Zoom Details:') !!}
                            <p>{{ $agronomistVendorService->zoom_details }}</p>
                        </div>
                    @endif




                    <!-- Created At Field -->
                    <div>
                        {!! Form::label('created_at', 'Created At:') !!}
                        <p>{{ $agronomistVendorService->created_at }},
                            {{ $agronomistVendorService->created_at->diffForHumans() }}
                        </p>
                    </div>






                </div>
            </div>
        </div>


    </div>


</div>
