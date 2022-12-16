<!-- Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('value', 'Value:') !!}
    {!! Form::number('value', null, ['class' => 'form-control']) !!}
</div>

<!-- Period Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('period_unit', 'Period Unit:') !!}
    {!! Form::text('period_unit', null, ['class' => 'form-control','placeholder'=>'Months','readonly']) !!}
</div>
