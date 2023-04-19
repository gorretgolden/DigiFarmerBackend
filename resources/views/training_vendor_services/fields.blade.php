<?php
$users = App\Models\User::where('user_type', 'farmer')->pluck('username', 'id');

?>
<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter training name']) !!}
</div>


<!-- Charge Field -->
<div class="form-group col-sm-6">
    {!! Form::label('charge', 'Charge:') !!}
    {!! Form::number('charge', null, ['class' => 'form-control', 'placeholder' => '10000']) !!}
</div>


<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>




{{--
<!-- Period  Field -->
<div class="form-group col-sm-6">
    {!! Form::label('period', 'Period:') !!}
    {!! Form::text('period', null, ['class' => 'form-control', 'placeholder' => '1']) !!}
</div>


<!-- Period Unit Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('period_unit_id', 'Period Unit:') !!}
    {!! Form::select('period_unit_id', $period_units, null, ['class' => 'form-control custom-select']) !!}
</div> --}}


<div class="form-group col-sm-6">
    {!! Form::label('Access') !!}
    {!! Form::select('access', ['Online' => 'Online', 'Offline' => 'Offline'],null, ['class' => 'form-control type','placeholder'=>'Select access type']) !!}
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




{{-- <!-- Vendor Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('vendor_category_id', 'Vendor Category:') !!}
    {!! Form::select('vendor_category_id', $vendor_categories, null, ['class' => 'form-control custom-select']) !!}
</div> --}}





<!-- Starting Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('starting_date', 'Starting Date:') !!}
    {!! Form::text('starting_date', null, [
        'class' => 'form-control',
        'id' => 'starting_date',
        'placeholder' => 'Select starting date',
    ]) !!}
</div>





<!-- Starting Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('starting_time', 'Starting Time:') !!}
    {!! Form::text('starting_time', null, [
        'class' => 'form-control',
        'id' => 'starting_time',
        'placeholder' => 'Select starting time',
    ]) !!}
</div>



<!-- Ending Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ending_date', 'Ending Date:') !!}
    {!! Form::text('ending_date', null, [
        'class' => 'form-control',
        'id' => 'ending_date',
        'placeholder' => 'Select ending date',
    ]) !!}
</div>





<!-- Ending Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ending_time', 'Ending Time:') !!}
    {!! Form::text('ending_time', null, [
        'class' => 'form-control',
        'id' => 'ending_time',
        'placeholder' => 'Select ending time',
    ]) !!}
</div>




<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Vendor :') !!}
    {!! Form::select('user_id', $users, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Zoom Details Field -->
<div class="form-group col-sm-12 col-lg-12" id="zoom-details-container">
    {!! Form::label('zoom_details', 'Zoom Details:') !!}
    {!! Form::textarea('zoom_details', null, [
        'class' => 'form-control find',
        'placeholder' => 'Zoom details for online access',
    ]) !!}
</div>


<!-- Address Id Field -->
<div class="form-group col-sm-6" id="address-container">
    {!! Form::label('address_id', 'Address:') !!}
    <select id="farmer-address" name="address_id" class="form-control">




    </select>
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


    <script type="text/javascript">
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


                            $("#farmer-address").append('<option value="' + value
                                .id + '">' + value
                                .district_name + '</option>');


                        });




                    }
                });
            });

            $('#ending_time').datetimepicker({
                format: 'hh:mm A',
                useCurrent: true,
                sideBySide: true
            })

            $('#ending_date').datetimepicker({
                format: 'DD-MM-YYYY ',
                useCurrent: true,
                sideBySide: true
            })

            $('#starting_time').datetimepicker({
                format: 'hh:mm A',
                useCurrent: true,
                sideBySide: true
            })

            $('#starting_date').datetimepicker({
                format: 'DD-MM-YYYY',
                useCurrent: true,
                sideBySide: true
            })

            $('#zoom-details-container').hide()
            $('#address-container').hide()
            //   $('#farmer-address').hide()
            $('.type').on('change', function() {

                if (this.value == 'Online') {
                    console.log(this.value)
                    $("#zoom-details-container").show();
                    $('#address-container').hide()

                } else {
                    $('#address-container').show()
                    $("#zoom-details-container").hide();

                }


            });



        });
    </script>
@endpush
