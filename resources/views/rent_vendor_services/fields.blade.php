<?php
$rent_sub_categories = App\Models\RentVendorSubCategory::pluck('name', 'id');
$vendors = App\Models\User::where('user_type','seller')->pluck('username','id');
?>



<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>'Enter rent service name']) !!}
</div>

<!-- Rent Vendor Sub Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rent_vendor_sub_category_id', 'Rent Vendor Sub Category :') !!}
    {!! Form::select('rent_vendor_sub_category_id', $rent_sub_categories, null, [
        'class' => 'form-control custom-select',
    ]) !!}
</div>


<!-- Charge Field -->
<div class="form-group col-sm-6">
    {!! Form::label('charge', 'Charge:') !!}
    {!! Form::number('charge', null, ['class' => 'form-control','placeholder'=>10000]) !!}
</div>

<!-- Charge Days Field -->
<div class="form-group col-sm-6">
    {!! Form::label('charge_day', 'Charge Number of Days:') !!}
    {!! Form::number('charge_day', null, ['class' => 'form-control','placeholder'=>1]) !!}
</div>

<!-- Charge Day Frequency-->
<div class="form-group col-sm-6">
    {!! Form::label('charge_frequency', 'Charge Frequency:') !!}
    {!! Form::select('charge_frequency', ['day' => 'Day', 'days' => 'Days'],null, ['class' => 'form-control','placeholder'=>'Select Charge frequency','required'=>'true'] ) !!}
</div>


<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Vendors:') !!}
    {!! Form::select('user_id', $vendors, null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>



<div class="form-group col-sm-6">

    <label>Choose Images</label>
    <input class="custom-file-label" type="file" name="images[]" multiple>
</div>



<!-- Image Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('images', 'Image:') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('images', ['class' => 'custom-file-input']) !!}
            {!! Form::label('images', 'Choose file', ['class' => 'custom-file-label', 'multiple']) !!}
        </div>
    </div>
</div> --}}

<div class="clearfix"></div>
