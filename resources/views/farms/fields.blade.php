
<?php
$users = App\Models\User::pluck('first_name','id');
?>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>



<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', 'Address:') !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<!-- Field Area -->
<div class="form-group col-sm-6">
    {!! Form::label('field_area', 'Field Area:') !!}
    {!! Form::number('field_area', null, ['class' => 'form-control']) !!}
</div>

<!--Field Size Unit-->
<div class="form-group col-sm-6">
    {!! Form::label('size_unit', 'Size Unit:') !!}
    {!! Form::select('size_unit',['Acres' => 'Acres','Hectares'=>'Hectares'] ,null, ['class' => 'form-control']) !!}
</div>


<!-- Latitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('latitude', 'Latitude:') !!}
    {!! Form::text('latitude', null, ['class' => 'form-control']) !!}
</div>



<!-- Longitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('longitude', 'Longitude:') !!}
    {!! Form::number('longitude', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User:') !!}
    {!! Form::select('user_id', $users, null, ['class' => 'form-control custom-select']) !!}
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
