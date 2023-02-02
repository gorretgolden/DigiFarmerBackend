<?php
$users = App\Models\User::where('user_type', 'farmer')->pluck('username', 'id');
$animals= App\Models\AnimalCategory::pluck('name', 'id');
$vendor_categories = App\Models\VendorCategory::all()->pluck('name', 'id');
?>


<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, [
        'class' => 'form-control',
        'maxlength' => 50,
        'placeholder' => 'Enter service name',
    ]) !!}
</div>




<!-- Crop Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('animal_id', 'Animal Category:') !!}
    {!! Form::select('animals[]', $animals, null, ['class' => 'form-control custom-select', 'multiple' => 'multiple']) !!}
</div>




<!-- Expertise Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('expertise', 'Expertise:') !!}
    {!! Form::textarea('expertise', null, [
        'class' => 'form-control',
        'maxlength' => 255,
        'placeholder' => 'Enter agronomist expertise',
    ]) !!}
</div>


<!-- Charge Field -->
<div class="form-group col-sm-6">
    {!! Form::label('charge', 'Charge:') !!}
    {!! Form::number('charge', null, [
        'class' => 'form-control',
        'placeholder' => 'Enter service charge',
        'min' => 1000,
    ]) !!}
</div>


<!-- Charge Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('charge_unit', 'Charge Unit:') !!}
    {!! Form::text('charge_unit', null, ['class' => 'form-control', 'placeholder' => 'Per hour', 'readonly']) !!}
</div>


<!--Availability-->
<div class="form-group col-sm-6">
    {!! Form::label('availability', 'Availability:') !!}
    {!! Form::select(
        'availability',
        ['Call' => 'Call', 'Online' => 'Online', 'Chat' => 'Chat', 'In-Person' => 'In-Person'],
        null,
        ['class' => 'form-control'],
    ) !!}
</div>


<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'maxlength' => 255]) !!}
</div>


<!-- Zoom Details Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('zoom_details', 'Zoom Details:') !!}
    {!! Form::textarea('zoom_details', null, ['class' => 'form-control zoom']) !!}
</div>




<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Farmers:') !!}
    {!! Form::select('user_id', $users, null, ['class' => 'form-control custom-select']) !!}
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
<div class="clearfix"></div>


@push('scripts')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script>
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


        $(document).ready(function() {
            $('.availability').change(function() {
                var tmp = this.value;
                $('#location').hide();
                $('#zoom_details').hide();


                if (tmp == "In-person") {
                    $('#farmer-address').show();
                } else if (tmp == "Online") {
                    $('#zoom_details').show();


                }


            })








        });
    </script>
@endpush
