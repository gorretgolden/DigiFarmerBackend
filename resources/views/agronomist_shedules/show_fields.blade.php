<!-- Day Id Field -->
<div class="col-sm-12">
    {!! Form::label('day_id', 'Day Id:') !!}
    <p>{{ $agronomistShedule->day_id }}</p>
</div>

<!-- Start Time Field -->
<div class="col-sm-12">
    {!! Form::label('start_time', 'Start Time:') !!}
    <p>{{ $agronomistShedule->start_time }}</p>
</div>

<!-- End Time Field -->
<div class="col-sm-12">
    {!! Form::label('end_time', 'End Time:') !!}
    <p>{{ $agronomistShedule->end_time }}</p>
</div>

<!-- Agronomist Vendor Service Id Field -->
<div class="col-sm-12">
    {!! Form::label('agronomist_vendor_service_id', 'Agronomist Vendor Service Id:') !!}
    <p>{{ $agronomistShedule->agronomist_vendor_service_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $agronomistShedule->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $agronomistShedule->updated_at }}</p>
</div>

