<!-- Is Registered Field -->
<div class="col-sm-12">
    {!! Form::label('is_registered', 'Is Registered:') !!}
    <p>{{ $farmerTraining->is_registered }}</p>
</div>

<!-- Training Vendor Service Id Field -->
<div class="col-sm-12">
    {!! Form::label('training_vendor_service_id', 'Training Vendor Service Id:') !!}
    <p>{{ $farmerTraining->training_vendor_service_id }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $farmerTraining->user_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $farmerTraining->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $farmerTraining->updated_at }}</p>
</div>

