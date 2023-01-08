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
    {!! Form::number('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Animal Feed  Category  Field -->
<div class="form-group col-sm-6">
    {!! Form::label('animal_feed_category_id', 'Animal Feed  Category :') !!}
    {!! Form::select('animal_feed_category_id', $categories, null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Animal Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('animal_category_id', 'Animal  Category :') !!}
    {!! Form::select('animal_category_id', $animal_categories, null, ['class' => 'form-control custom-select']) !!}
</div>




<!--quantity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity', 'Quantity:') !!}
    {!! Form::number('quantity', null, ['class' => 'form-control']) !!}
</div>
<!-- aunatity Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity_unit', 'Quantity Unit:') !!}
    {!! Form::text('quantity_unit', null, ['class' => 'form-control', 'placeholder' => 'kg', 'readonly']) !!}
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



@push('scripts')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script>
        $(document).ready(function() {

            $('#user_id').on('change', function() {
                var idFarmer = this.value;

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
        })
    </script>
@endpush
