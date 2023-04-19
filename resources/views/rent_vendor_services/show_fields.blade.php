<div class="row">


    <div class="col-md-6">


        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md ">

                        <img src="{{ $rentVendorService->vendor->image ? $rentVendorService->vendor->image : asset('img/avatar-1.png') }}"
                            class="img-thumbnail rounded-circle shadow-4-strong w-25" />
                    </div>


                    <div class="col-md-12 mt-2">
                        {!! Form::label('name', 'Vendor details:') !!}
                        <p>Name: {{ $rentVendorService->vendor->username }}</p>
                        <p>Contact: {{ $rentVendorService->vendor->phone }}</p>
                        <p>Email: {{ $rentVendorService->vendor->email }}</p>
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
                        <img class="img-thumbnail w-75" src="{{ URL::asset("$rentVendorService->image") }}" />
                    </div>


                    <!-- Name Field -->
                    <div class="d-inline">
                        {!! Form::label('name', 'Name:') !!}
                        <p>{{ $rentVendorService->name }}</p>
                    </div>


                    <div class="col-sm-12">
                        {!! Form::label('rent_vendor_sub_category_id', 'Rent Vendor Sub Category:') !!}
                        <p>{{ $rentVendorService->rent_vendor_sub_category->name }}</p>
                    </div>




                    <!-- Price Field -->
                    <div>
                        {!! Form::label('price', 'Price:') !!}
                        <p>{{ $rentVendorService->price_unit }} {{ $rentVendorService->price }}</p>
                    </div>

                    <!-- Price Field -->
                    <div>
                        {!! Form::label('weight', 'Weight:') !!}
                        <p>{{ $rentVendorService->weight }} {{ $rentVendorService->weight_unit }}</p>
                    </div>




                    <!-- status Field -->
                    <div>
                        {!! Form::label('status', 'Status:') !!}
                        <p class="badge rounded-pill bg-success">{{ $rentVendorService->status }}</p>
                        @if ($rentVendorService->is_verified == 1)
                            <p class="badge rounded-pill bg-success">Verified</p>
                        @else
                            <p class="badge rounded-pill bg-danger">Not verified</p>
                        @endif


                    </div>






                    <!-- Description Field -->
                    <div>
                        {!! Form::label('description', 'Description:') !!} <p>{{ $rentVendorService->description }}</p>


                    </div>

                    <div>
                        {!! Form::label('location', 'Location:') !!} <p>{{ $rentVendorService->location }}</p>


                    </div>



                    <!-- Created At Field -->
                    <div>
                        {!! Form::label('created_at', 'Created At:') !!}
                        <p>{{ $rentVendorService->created_at }}, {{ $rentVendorService->created_at->diffForHumans() }}
                        </p>
                    </div>






                </div>
            </div>
        </div>


    </div>










</div>
