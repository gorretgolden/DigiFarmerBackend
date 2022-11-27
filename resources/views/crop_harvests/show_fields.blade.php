<!-- Quantity Field -->
<div class="col-sm-12">
    {!! Form::label('quantity', 'Quantity:') !!}
    <p>{{ $cropHarvest->quantity }}</p>
</div>

<!-- Quantity Unit Field -->
<div class="col-sm-12">
    {!! Form::label('quantity_unit', 'Quantity Unit:') !!}
    <p>{{ $cropHarvest->quantity_unit }}</p>
</div>

<!-- Plot Id Field -->
<div class="col-sm-12">
    {!! Form::label('plot_id', 'Plot Id:') !!}
    <p>{{ $cropHarvest->plot_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $cropHarvest->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $cropHarvest->updated_at }}</p>
</div>

