<?php
$users = App\Models\User::where('user_type','farmer')->pluck('username','id');
$vendor_categories = App\Models\VendorCategory::all()->pluck('name','id');
?>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 50,'placeholder'=>'Enter service name']) !!}
</div>

<!-- Expertise Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('expertise', 'Expertise:') !!}
    {!! Form::textarea('expertise', null, ['class' => 'form-control','maxlength' => 255,'placeholder'=>'Enter agronomist expertise']) !!}
</div>

<!-- Charge Field -->
<div class="form-group col-sm-6">
    {!! Form::label('charge', 'Charge:') !!}
    {!! Form::number('charge', null, ['class' => 'form-control','placeholder'=>'Enter service charge','min'=>1000]) !!}
</div>

<!-- Charge Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('charge_unit', 'Charge Unit:') !!}
    {!! Form::text('charge_unit', null, ['class' => 'form-control','placeholder'=>'Per hour','readonly']) !!}
</div>

<!--Availability-->
<div class="form-group col-sm-6">
    {!! Form::label('availability', 'Availability:') !!}
    {!! Form::select('availability',['Call' => 'Call','Online'=>'Online','Chat'=>'Chat','In-Person'=>'In-Person'] ,null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control','maxlength' => 255]) !!}
</div>

<!-- Zoom Details Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('zoom_details', 'Zoom Details:') !!}
    {!! Form::textarea('zoom_details', null, ['class' => 'form-control','placeholder'=>'Zoom details for oline availability']) !!}
</div>

<!-- Location Details Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('location_details', 'Location Details:') !!}
    {!! Form::textarea('location_details', null, ['class' => 'form-control','placeholder'=>'Location details for in-person meeting']) !!}
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


<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Farmers:') !!}
    {!! Form::select('user_id', $users, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Vendor Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('vendor_category_id', 'Vendor Category:') !!}
    {!! Form::select('vendor_category_id', $vendor_categories, null, ['class' => 'form-control custom-select']) !!}
</div>
