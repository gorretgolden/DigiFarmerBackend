<!-- Time Field -->
<div class="col-sm-12">
    {!! Form::label('time', 'Time:') !!}
    <p>{{ $veterinaryShedule->time }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $veterinaryShedule->status }}</p>
</div>

<!-- Veterinary Shedule Id Field -->
<div class="col-sm-12">
    {!! Form::label('veterinary_shedule_id', 'Veterinary Shedule Id:') !!}
    <p>{{ $veterinaryShedule->veterinary_shedule_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $veterinaryShedule->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $veterinaryShedule->updated_at }}</p>
</div>

