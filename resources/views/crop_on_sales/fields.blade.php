<?php
$farmers = App\Models\User::where('user_type','farmer')->pluck('username','id');
$crops = App\Models\Crop::pluck('name','id');
?>



<!-- Quantity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity', 'Quantity:') !!}
    {!! Form::number('quantity', null, ['class' => 'form-control','placeholder'=>"Enter quantity"]) !!}
</div>

<!-- Selling Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('selling_price', 'Selling Price:') !!}
    {!! Form::number('selling_price', null, ['class' => 'form-control','placeholder'=>"Enter crop selling price"]) !!}
</div>

<!-- Quantity Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity_unit', 'Quantity Unit:') !!}
    {!! Form::text('quantity_unit', null, ['class' => 'form-control','placeholder'=>"kg",'readonly']) !!}
</div>

<!-- Price Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price_unit', 'Price Unit:') !!}
    {!! Form::text('price_unit', null, ['class' => 'form-control','placeholder'=>"UGX",'readonly']) !!}
</div>

<!-- Is Sold Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_sold', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_sold', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_sold', 'Is Sold', ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Crop Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('crop_id', 'Crop:') !!}
    {!! Form::select('crop_id', $crops, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Farmers:') !!}
    {!! Form::select('user_id', $farmers, null, ['class' => 'form-control custom-select']) !!}
</div>
