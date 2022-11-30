
<?php
$users = App\Models\User::where('user_type','farmer')->pluck('username','id');
$training_vendor_services = App\Models\TrainingVendorService::pluck('name','id');
?>

<!-- Is Registered Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_registered', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_registered', '1', null, ['class' => 'form-check-input','checked']) !!}
        {!! Form::label('is_registered', 'Is Registered', ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Training Vendor Service Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('training_vendor_service_id', 'Training Vendor Services:') !!}
    {!! Form::select('training_vendor_service_id', $training_vendor_services, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Farmers:') !!}
    {!! Form::select('user_id', $users, null, ['class' => 'form-control custom-select']) !!}
</div>
