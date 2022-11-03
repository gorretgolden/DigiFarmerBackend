<!-- Farm Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('farm_id', 'Farm Id:') !!}
    {!! Form::select('farm_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Harvest Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('harvest_amount', 'Harvest Amount:') !!}
    {!! Form::number('harvest_amount', null, ['class' => 'form-control']) !!}
</div>