<!-- Time Field -->
<div class="col-sm-12">
    {!! Form::label('time', 'Time:') !!}
    <p>{{ $veterinarySlot->time }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $veterinarySlot->status }}</p>
</div>

<!-- Veterinary Shedule Id Field -->
<div class="col-sm-12">
    {!! Form::label('veterinary_shedule_id', 'Veterinary Shedule Id:') !!}
    <p>{{ $veterinarySlot->veterinary_shedule_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $veterinarySlot->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $veterinarySlot->updated_at }}</p>
</div>

