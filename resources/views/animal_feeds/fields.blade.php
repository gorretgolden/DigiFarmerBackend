<?php
$categories = App\Models\AnimalFeedCategory::pluck('name', 'id');
$animal_categories = App\Models\AnimalCategory::pluck('name', 'id');
$vendors = App\Models\User::where('user_type', 'farmer')->pluck('username', 'id');
?>


<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>


<!-- Price\
     Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::number('price', null, ['class' => 'form-control','min'=>500]) !!}
</div>




<!-- Animal Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('animal_category_id', 'Animal  Category :') !!}
    {!! Form::select('animal_category_id', $animal_categories, null, ['class' => 'form-control custom-select animal_category_id']) !!}
</div>




<!-- Animal Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('animal_feed_category_id', 'Animal Feed  Category :') !!}
    <select id="animal-feed" name="animal_feed_category_id" class="form-control" >




    </select>


</div>






<!--weight Field -->
<div class="form-group col-sm-6">
    {!! Form::label('weight', 'Weight:') !!}
    {!! Form::number('weight', null, ['class' => 'form-control','min'=>1]) !!}
</div>
<!--    Weight Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('weight_unit', 'Weight Unit:') !!}
    {!! Form::select('weight_unit', ['kg'=>'kg',' ml'=>' ml','g'=>'g','l'=>'l'],null, ['class' => 'form-control']) !!}
</div>




<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Vendors:') !!}
    {!! Form::select('user_id', $vendors, null, ['class' => 'form-control custom-select']) !!}
</div>




<!-- Address Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address_id', 'Address:') !!}
    <select id="farmer-address" name="address_id" class="form-control">


    </select>
</div>






<!-- Stock Field -->
<div class="form-group col-sm-6">
    {!! Form::label('stock_amount', 'Stock amount:') !!}
    {!! Form::number('stock_amount', null, ['class' => 'form-control','min'=>1]) !!}
</div>
<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('image', ['class' => 'custom-file-input']) !!}
            {!! Form::label('image', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>


<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>




<!-- Is verified Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_verified', 'Verify:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_verified', 0) !!}
        {!! Form::checkbox('is_verified', '1', null) !!}
    </label>
</div>


@push('scripts')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script>
        $(document).ready(function() {


            $('#user_id').on('change', function() {
                var idFarmer = this.value;
                console.log(idFarmer)


                $('#farmer-address').html('<option selected="selected" value="">Loading...</option>');
                $.ajax({
                    url: "{{ route('sellers.fetch-address') }}",
                    type: "get",
                    data: {
                        user_id: idFarmer
                    },
                    dataType: 'json',
                    success: function(result) {


                        $('#farmer-address').html(
                            '<option value="">-- Select farmer address --</option>');


                        $.each(result.addresses, function(key, value) {
                            console.log(result)


                            $("#farmer-address").append('<option value="' + value
                                .id + '">' + value.address_name + " " + value
                                .district_name + '</option>');


                            console.log('hello', value.district_name)


                        });


                    }
                });
            });




            $('.animal_category_id').on('change', function() {
                var category_id = this.value;
                console.log(category_id)




                $('#animal-feed').html('<option selected="selected" value="">Loading...</option>');
                $.ajax({
                    url: "{{ route('animal-categories.feeds') }}",
                    type: "get",
                    data: {
                        animal_category_id: category_id
                    },
                    dataType: 'json',
                    success: function(result) {


                        $('#animal-feed').html('<option value="">-- Select animal feed--</option>');


                        $.each(result.animal_feed_categories, function(key, value) {
                            console.log(result)


                            $("#animal-feed").append('<option value="' + value
                                .id + '">' + value.name  + '</option>');


                            console.log('hello', value.name)


                        });


                    }
                });
            });








        })
    </script>






@endpush


