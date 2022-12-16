<!-- Value Field -->
<div class="col-sm-12">
    {!! Form::label('value', 'Value:') !!}
    <p>{{ $loanPlan->value }}</p>
</div>

<!-- Period Unit Field -->
<div class="col-sm-12">
    {!! Form::label('period_unit', 'Period Unit:') !!}
    <p>{{ $loanPlan->period_unit }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $loanPlan->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $loanPlan->updated_at }}</p>
</div>

