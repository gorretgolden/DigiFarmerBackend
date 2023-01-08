<?php
$crops= App\Models\Crop::pluck('name','id');
$users = App\Models\User::where('user_type','farmer')->pluck('username','id');
$addresses = App\Models\Address::pluck('address_name','id');

?>

<!-- Quantity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity', 'Quantity:') !!}
    {!! Form::number('quantity', null, ['class' => 'form-control']) !!}
</div>

<!-- Quantity Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity_unit', 'Quantity Unit:') !!}
    {!! Form::text('quantity_unit', null, ['class' => 'form-control','placeholder'=>"kg",'readonly']) !!}
</div>

<!-- Selling Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('selling_price', 'Selling Price:') !!}
    {!! Form::number('selling_price', null, ['class' => 'form-control','placeholder'=>"Enter crop selling price"]) !!}
</div>

<!-- Price Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price_unit', 'Price Unit:') !!}
    {!! Form::text('price_unit', null, ['class' => 'form-control','placeholder'=>"UGX",'readonly']) !!}
</div>


<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

{{-- <!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('image', ['class' => 'custom-file-input']) !!}
            {!! Form::label('image', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>
<div class="clearfix"></div> --}}



<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User:') !!}
    {!! Form::select('user_id', $users, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Address Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address_id', 'Address:') !!}
    <select id="farmer-address" name="address_id" class="form-control">

    </select>
</div>

<!-- Crop Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('crop_id', 'Crop:') !!}
    {!! Form::select('crop_id', $crops, null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Is Sold Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_sold', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_sold', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_sold', 'Is Sold', ['class' => 'form-check-label']) !!}
    </div>
</div>




@push('scripts')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script>

        $(document).ready(function() {

            $('#user_id').on('change', function() {
                var idFarmer = this.value;

                $('#farmer-address').html('<option selected="selected" value="">Loading...</option>');
                $.ajax({
                    url: "{{ route('farmers.fetch-address') }}",
                    type: "get",
                    data: {
                        owner: idFarmer
                    },
                    dataType: 'json',
                    success: function(result) {

                        $('#farmer-address').html('<option value="">-- Select farmer address --</option>');

                        $.each(result.addresses, function(key, value) {

                            $("#farmer-address").append('<option value="' + value
                                .id + '">' + value.address_name + " " + value.district_name + '</option>');

                                console.log('hello',value.district_name)

                        });

                    }
                });
            });
        })
    </script>
@endpush
