
<?php
$crops = App\Models\Crop::pluck('name','id');
$farms = App\Models\Farm::pluck('name','id');
?>
<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Crop Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('crop_id', 'Crop:') !!}
    {!! Form::select('crop_id', $crops, null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Farm Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('farm_id', 'Farm:') !!}
    {!! Form::select('farm_id', $farms, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Size Field -->
<div class="form-group col-sm-6">
    {!! Form::label('size', 'Size:') !!}
    {!! Form::number('size', null, ['class' => 'form-control']) !!}
</div>



<!-- Size Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('size_unit', 'Size Unit:') !!}
    {!! Form::select('size_unit',['Acres'=>'Acres','Hectares'=>'Hectares'],null, ['class' => 'form-control','placeholder'=>'Select  Plot Size Unit']) !!}
</div>
