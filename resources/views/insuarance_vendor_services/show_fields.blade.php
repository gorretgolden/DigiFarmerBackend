<div class="row">


    <div class="col-md-6">


        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md ">

                        <img src="{{ $insuaranceVendorService->user->image ? $insuaranceVendorService->user->image : asset('img/avatar-1.png') }}"
                            class="img-thumbnail rounded-circle shadow-4-strong w-25" />
                    </div>


                    <div class="col-md-12 mt-2">
                        {!! Form::label('name', 'Vendor details:') !!}
                        <p>Name: {{ $insuaranceVendorService->user->username }}</p>
                        <p>Contact: {{ $insuaranceVendorService->user->phone }}</p>
                        <p>Email: {{ $insuaranceVendorService->user->email }}</p>
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
                        <img class="img-thumbnail w-75" src="{{ URL::asset("$insuaranceVendorService->image") }}" />
                    </div>


                    <!-- Name Field -->
                    <div class="d-inline">
                        {!! Form::label('name', 'Name:') !!}
                        <p>{{ $insuaranceVendorService->name }}</p>
                    </div>

                    <!-- Terms Field -->
                    <div class="col-sm-12">
                        {!! Form::label('terms', 'Terms:') !!}
                        <p>{{ $insuaranceVendorService->terms }}</p>
                    </div>

                    <!-- Description Field -->
                    <div class="col-sm-12">
                        {!! Form::label('description', 'Description:') !!}
                        <p>{{ $insuaranceVendorService->description }}</p>
                    </div>



                    <!-- Vendor Category Id Field -->
                    <div class="col-sm-12">
                        {!! Form::label('vendor_category_id', 'Vendor Category:') !!}
                        <p>{{ $insuaranceVendorService->vendor_category->name }}</p>
                    </div>




                    <!-- status Field -->
                    <div>
                        {!! Form::label('status', 'Status:') !!}
                        <p class="badge rounded-pill bg-success">{{ $insuaranceVendorService->status }}</p>
                        @if ($insuaranceVendorService->is_verified == 1)
                            <p class="badge rounded-pill bg-success">Verified</p>
                        @else
                            <p class="badge rounded-pill bg-danger">Not verified</p>
                        @endif


                    </div>





                    <!-- Description Field -->
                    <div>
                        {!! Form::label('description', 'Description:') !!} <p>{{ $insuaranceVendorService->description }}</p>


                    </div>

                    <div>
                        {!! Form::label('location', 'Location:') !!} <p>{{ $insuaranceVendorService->location }}</p>


                    </div>



                    <!-- Created At Field -->
                    <div>
                        {!! Form::label('created_at', 'Created At:') !!}
                        <p>{{ $insuaranceVendorService->created_at }},
                            {{ $insuaranceVendorService->created_at->diffForHumans() }}
                        </p>
                    </div>






                </div>
            </div>
        </div>


    </div>


</div>
