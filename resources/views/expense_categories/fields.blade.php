<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Standard Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('standard_value', 'Standard Value:') !!}
    {!! Form::number('standard_value', null, ['class' => 'form-control']) !!}
</div>

