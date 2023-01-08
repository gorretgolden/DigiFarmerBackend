<!-- Agronomist Shedule Id Field -->
<div class="col-sm-12">
    {!! Form::label('agronomist_shedule_id', 'Agronomist Shedule Id:') !!}
    <p>{{ $agronomistSlot->agronomist_shedule_id }}</p>
</div>

<!-- Start Time Field -->
<div class="col-sm-12">
    {!! Form::label('start_time', 'Start Time:') !!}
    <p>{{ $agronomistSlot->start_time }}</p>
</div>

<!-- End Time Field -->
<div class="col-sm-12">
    {!! Form::label('end_time', 'End Time:') !!}
    <p>{{ $agronomistSlot->end_time }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $agronomistSlot->status }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $agronomistSlot->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $agronomistSlot->updated_at }}</p>
</div>

