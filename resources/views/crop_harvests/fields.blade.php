<?php
$plots= App\Models\Plot::pluck('name','id');
?>


<!-- Quantity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity', 'Quantity:') !!}
    {!! Form::number('quantity', null, ['class' => 'form-control']) !!}
</div>

<!-- Quantity Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity_unit', 'Quantity Unit:') !!}
    {!! Form::text('quantity_unit', null, ['class' => 'form-control']) !!}
</div>

<!-- Plot Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('plot_id', 'Plot Id:') !!}
    {!! Form::select('plot_id', $plots, null, ['class' => 'form-control custom-select']) !!}
</div>
