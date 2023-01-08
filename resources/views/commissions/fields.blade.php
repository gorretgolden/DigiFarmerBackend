<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Commission value:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control','placeholder'=>'1']) !!}
</div>

<!-- Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unit', 'Unit:') !!}
    {!! Form::text('unit', null, ['class' => 'form-control','placeholder'=>'%','readonly']) !!}
</div>
