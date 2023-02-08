<?php
$rent_categories = App\Models\RentVendorCategory::pluck('name', 'id');
$vendors = App\Models\User::where('user_type','farmer')->pluck('username','id');
$vendor_categories = App\Models\VendorCategory::pluck('name','id');
?>



<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>'Enter rent service name']) !!}
</div>


<!-- Charge Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity', 'Quantity:') !!}
    {!! Form::number('quantity', null, ['class' => 'form-control','placeholder'=>'Enter number of items for rent','min'=>1,'max'=>20]) !!}
</div>



<!-- Rent Vendor  Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rent_vendor_category_id', 'Rent Vendor  Category :') !!}
    {!! Form::select('rent_vendor_category_id', $rent_categories, null, [
        'class' => 'form-control custom-select',
    ]) !!}
</div>


<!-- Rent Vendor sub  Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rent_vendor_sub_category_id', 'Rent Vendor sub Category:') !!}
    <select id="sub_category" name="rent_vendor_sub_category_id" class="form-control">

    </select>
</div>

{{-- <!-- Charge Days Field -->
<div class="form-group col-sm-6">
    {!! Form::label('charge_day', 'Charge Number of Days:') !!}
    {!! Form::number('charge_day', null, ['class' => 'form-control','placeholder'=>1]) !!}
</div> --}}



<!-- Charge Field -->
<div class="form-group col-sm-6">
    {!! Form::label('charge', 'Charge:') !!}
    {!! Form::number('charge', null, ['class' => 'form-control','placeholder'=>'Enter service charge','min'=>500]) !!}
</div>

<!-- Charge Day Frequency-->
<div class="form-group col-sm-6">
    {!! Form::label('charge_frequency', 'Charge Frequency:') !!}
    {!! Form::select('charge_frequency', ['per day'=>'per day','per hour'=>'per hour','per piece'=>'per piece'],null, ['class' => 'form-control']) !!}
</div>






<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Vendors') !!}
    {!! Form::select('user_id', $vendors, null, ['class' => 'form-control custom-select']) !!}
</div>
<!-- Address Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address_id', 'Address:') !!}
    <select id="farmer-address" name="address_id" class="form-control">

    </select>
</div>





{{-- <!-- Vendor Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('vendor_category_id', 'Vendor Category:') !!}
    {!! Form::select('vendor_category_id', $vendor_categories, null, ['class' => 'form-control custom-select']) !!}
</div> --}}


<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control','min'=>20,'max'=>1000]) !!}
</div>



<div class="form-group col-sm-6">

    <label>Choose an image</label>
    <input class="custom-file-label" type="file" name="image" multiple>
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

            $('#rent_vendor_category_id').on('change', function() {
                var id_rent = this.value;

                $('#sub_category').html('<option selected="selected" value="">Loading...</option>');
                $.ajax({
                    url: "{{ route('rent.sub-categories')}}",
                    type: "get",
                    data: {
                        rent_vendor_category_id: id_rent
                    },
                    dataType: 'json',
                    success: function(result) {

                        $('#sub_category').html('<option value="">-- Select sub category --</option>');

                        $.each(result.Sub_categories, function(key, value) {
                            console.log(result)

                            $("#sub_category").append('<option value="' + value
                                .id + '">' + value.name  + '</option>');

                                console.log('hello',value.name)

                        });

                    }
                });
            });
        })
    </script>

      <script>
        console.log('hfgkkk');
        $(document).ready(function() {

            $('#owner').on('change', function() {
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

                    $('#farmer-address').html('<option value="">-- Select vendor address --</option>');

                    $.each(result.addresses, function(key, value) {
                        console.log(result)

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



<div class="clearfix"></div>
