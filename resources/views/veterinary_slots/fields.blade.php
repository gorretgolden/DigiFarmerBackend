<!-- Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('time', 'Time:') !!}
    {!! Form::text('time', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::number('status', null, ['class' => 'form-control']) !!}
</div>

<!-- Veterinary Shedule Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('veterinary_shedule_id', 'Veterinary Shedule Id:') !!}
    {!! Form::select('veterinary_shedule_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>
