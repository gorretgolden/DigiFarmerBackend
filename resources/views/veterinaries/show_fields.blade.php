<div class="row">


    <div class="col-md-6">


        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md ">

                        <img src="{{ $veterinary->user->image ? $veterinary->user->image : asset('img/avatar-1.png') }}"
                            class="img-thumbnail rounded-circle shadow-4-strong w-25" />
                    </div>


                    <div class="col-md-12 mt-2">
                        {!! Form::label('name', 'Vendor details:') !!}
                        <p>Name: {{ $veterinary->user->username }}</p>
                        <p>Contact: {{ $veterinary->user->phone }}</p>
                        <p>Email: {{ $veterinary->user->email }}</p>
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
                        <img class="img-thumbnail w-75" src="{{ URL::asset("$veterinary->image") }}" />
                    </div>


                    <!-- Name Field -->
                    <div class="d-inline">
                        {!! Form::label('name', 'Name:') !!}
                        <p>{{ $veterinary->name }}</p>
                    </div>


                    <div class="col-sm-12">
                        {!! Form::label('expertise', 'Expertise:') !!}
                        <p>{{ $veterinary->expertise }}</p>
                    </div>

                    <!-- Charge Field -->
                    <div class="col-sm-12">
                        {!! Form::label('charge', 'Charge:') !!}
                        <p> {{ $veterinary->charge_unit }}{{ $veterinary->charge }}</p>
                    </div>




                    <!-- Availability Field -->
                    <div class="col-sm-12">
                        {!! Form::label('availability', 'Availability:') !!}
                        <p>{{ $veterinary->availability }}</p>
                    </div>

                    <!-- Description Field -->
                    <div class="col-sm-12">
                        {!! Form::label('description', 'Description:') !!}
                        <p>{{ $veterinary->description }}</p>
                    </div>


                    <!-- Vendor Category Id Field -->
                    <div class="col-sm-12">
                        {!! Form::label('vendor_category_id', 'Vendor Category:') !!}
                        <p>{{ $veterinary->vendor_category->name }}</p>
                    </div>



                    <!-- status Field -->
                    <div>
                        {!! Form::label('status', 'Status:') !!}
                        <p class="badge rounded-pill bg-success">{{ $veterinary->status }}</p>
                        @if ($veterinary->is_verified == 1)
                            <p class="badge rounded-pill bg-success">Verified</p>
                        @else
                            <p class="badge rounded-pill bg-danger">Not verified</p>
                        @endif


                    </div>



                    <!-- Description Field -->
                    <div class="col-sm-12">
                        {!! Form::label('description', 'Description:') !!}
                        <p>{{ $veterinary->description }}</p>


                    </div>



                    @if (!empty($veterinary->location))
                        <!-- Location Field -->
                        <div class="col-sm-12">
                            {!! Form::label('location', 'Location:') !!}
                            <p>{{ $veterinary->location }}</p>
                        </div>
                    @else
                        <!-- Zoom Details Field -->
                        <div class="col-sm-12">
                            {!! Form::label('zoom_details', 'Zoom Details:') !!}
                            <p>{{ $veterinary->zoom_details }}</p>
                        </div>
                    @endif




                    <!-- Created At Field -->
                    <div>
                        {!! Form::label('created_at', 'Created At:') !!}
                        <p>{{ $veterinary->created_at }},
                            {{ $veterinary->created_at->diffForHumans() }}
                        </p>
                    </div>






                </div>
            </div>
        </div>


    </div>


</div>
