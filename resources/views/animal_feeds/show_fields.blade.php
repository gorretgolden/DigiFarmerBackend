<div class="row">


    <div class="col-md-4">


        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ $animalFeed->vendor->image_url ? $animalFeed->vendor->image_url : asset('img/avatar-1.png') }}"
                            class="img-thumbnail" />
                    </div>


                    <div class="col-md-6 mt-2">
                        {!! Form::label('name', 'Vendor details:') !!}
                        <p>Name: {{ $animalFeed->vendor->username }}</p>
                        <p>Contact: {{ $animalFeed->vendor->phone }}</p>
                        <p>Email: {{ $animalFeed->vendor->email }}</p>
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
                    <img src="{{ $animalFeed->image}}"
                    class="img-thumbnail" />
                </div>


                <!-- Name Field -->
                <div class="d-inline">
                    {!! Form::label('name', 'Name:') !!}
                    <p>{{ $animalFeed->name }}</p>
                </div>


                <!-- Animal Feed Sub Category Id Field -->
                <div>
                    {!! Form::label('animal_feed_category_id', 'Animal Feed  Category:') !!}
                    <p>{{ $animalFeed->animal_feed_category->name }}</p>
                </div>




                <!-- Price Field -->
                <div>
                    {!! Form::label('price', 'Price:') !!}
                    <p>{{ $animalFeed->price_unit }} {{ $animalFeed->price }}</p>
                </div>




                <!-- status Field -->
                <div>
                    {!! Form::label('status', 'Status:') !!}
                    <p class="badge rounded-pill bg-success">{{ $animalFeed->status }}</p>
                    @if ($animalFeed->is_verified == 1)
                    <p class="badge rounded-pill bg-success">Verified</p>
                    @else
                    <p class="badge rounded-pill bg-danger">Not verified</p>
                    @endif


                </div>






                <!-- Description Field -->
                <div>
                    {!! Form::label('description', 'Description:') !!}  <p>{{ $animalFeed->description }}</p>


                </div>


                <!-- Created At Field -->
                <div>
                    {!! Form::label('created_at', 'Created At:') !!}
                    <p>{{ $animalFeed->created_at }}, {{ $animalFeed->created_at->diffForHumans() }}</p>
                </div>






            </div>
        </div>
    </div>


   </div>










</div>
