<div class="row">


    <div class="col-md-6">


        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md ">

                        <img src="{{ $sellerProduct->user->image ? $sellerProduct->user->image : asset('img/avatar-1.png') }}"
                            class="img-thumbnail rounded-circle shadow-4-strong w-25" />
                    </div>


                    <div class="col-md-12 mt-2">
                        {!! Form::label('name', 'Vendor details:') !!}
                        <p>Name: {{ $sellerProduct->user->username }}</p>
                        <p>Contact: {{ $sellerProduct->user->phone }}</p>
                        <p>Email: {{ $sellerProduct->user->email }}</p>
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
                        <img class="img-thumbnail w-75" src="{{ URL::asset("$sellerProduct->image") }}" />
                    </div>


                    <!-- Name Field -->
                    <div class="d-inline">
                        {!! Form::label('name', 'Name:') !!}
                        <p>{{ $sellerProduct->name }}</p>
                    </div>


                    <!-- Seller Product Category Id Field -->
                    <div class="col-sm-12">
                        {!! Form::label('seller_product_category_id', 'Seller Product Category Id:') !!}
                        <p>{{ $sellerProduct->seller_product_category->name }}</p>
                    </div>

                    <!-- Vendor Category Id Field -->

                    {{-- <div class="col-sm-12">
                    {!! Form::label('vendor_category_id', 'Vendor Category:') !!}
                    <p>{{ $sellerProduct->vendor_category->name }}</p>
                </div> --}}

                    <!-- Price Field -->
                    <div class="col-sm-12">
                        {!! Form::label('price', 'Price:') !!}
                        <p> {{ $sellerProduct->price_unit }} {{ $sellerProduct->price }}</p>
                    </div>



                    <!-- Description Field -->

                    <div class="col-sm-12">
                        {!! Form::label('description', 'Description:') !!}
                        <p>{{ $sellerProduct->description }}</p>
                    </div>

                    <!-- Stock Amount Field -->
                    <div class="col-sm-12">
                        {!! Form::label('stock_amount', 'Stock Amount:') !!}
                        <p>{{ $sellerProduct->stock_amount }} Items</p>
                    </div>

                    <!-- Status Field -->
                    <div class="col-sm-12">
                        {!! Form::label('status', 'Status:') !!}
                        <p>{{ $sellerProduct->status }}</p>
                    </div>

                    <!-- Is Verified Field -->
                    <div class="col-sm-12">
                        @if ($sellerProduct->is_verified == 1)
                            <p class="badge rounded-pill bg-success">Verified</p>
                        @else
                            <p class="badge rounded-pill bg-danger"> Not Verified</p>
                        @endif

                    </div>

                    <!-- Location Field -->
                    <div class="col-sm-12">
                        {!! Form::label('location', 'Location:') !!}
                        <p>{{ $sellerProduct->location }}</p>
                    </div>


                    <hr />


                    <!-- Created At Field -->
                    <div>
                        {!! Form::label('created_at', 'Created At:') !!}
                        <p>{{ $sellerProduct->created_at }}, {{ $sellerProduct->created_at->diffForHumans() }}</p>
                    </div>






                </div>
            </div>
        </div>


    </div>










</div>
