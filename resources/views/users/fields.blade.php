<?php
$countries = App\Models\Country::pluck('name','id');
$roles =    Spatie\Permission\Models\Role::pluck('name','id');
?>

<!-- First Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('first_name', 'First Name:') !!}
    {!! Form::text('first_name', null, ['class' => 'form-control','maxlength' => 100,'placeholder'=>'Enter user first name']) !!}
</div>

<!-- Last Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('last_name', 'Last Name:') !!}
    {!! Form::text('last_name', null, ['class' => 'form-control','maxlength' => 100,'placeholder'=>'Enter user last name']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control','maxlength' => 100,'placeholder'=>'Enter user email address']) !!}
</div>

<!-- Image Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image_url', 'Image Url:') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('image_url', ['class' => 'custom-file-input']) !!}
            {!! Form::label('image_url', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>
<div class="clearfix"></div>


<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control','placeholder'=>'256751547654']) !!}
</div>

<!-- User type -->
<div class="form-group col-sm-6">
    {!! Form::label('user_type', 'User Type:') !!}
    {!! Form::text('user_type',null,['class' => 'form-control','placeholder' => 'farmer','readonly']) !!}
</div>



<!-- Enabled Field -->
<div class="form-group col-sm-6">
    {!! Form::label('enabled', 'Enabled:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', '1', null) !!}
    </label>
</div>
{{-- <!-- Country Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('country_id', 'Country Id:') !!}
    {!! Form::select('country_id', $countries, null, ['class' => 'form-control custom-select']) !!}
</div> --}}


{{-- <!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::text('password', null, ['class' => 'form-control','minlength' => 8]) !!}
</div>


<!-- Confirm-Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('confirm-password', 'Confirm-Password:') !!}
    {!! Form::text('confirm-password', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Role Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('role', 'Role:') !!}
    {!! Form::select('role', $roles, null, ['class' => 'form-control custom-select']) !!}
</div> --}}
