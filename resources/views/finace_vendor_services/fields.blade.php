
<?php
$vendor_categories = App\Models\VendorCategory::pluck('name','id');
$vendors = App\Models\User::where('user_type_id',4)->pluck('username','id');

?>


<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Principal Field -->
<div class="form-group col-sm-6">
    {!! Form::label('principal', 'Principal:') !!}
    {!! Form::number('principal', null, ['class' => 'form-control']) !!}
</div>

<!-- Interest Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('interest_rate', 'Interest Rate:') !!}
    {!! Form::number('interest_rate', null, ['class' => 'form-control']) !!}
</div>

<!-- Interest Rate Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('interest_rate_unit', 'Interest Rate Unit:') !!}
    {!! Form::text('interest_rate_unit', null, ['class' => 'form-control']) !!}
</div>

<!-- Payment Frequency Pay Field -->
<div class="form-group col-sm-6">
    {!! Form::label('payment_frequency_pay', 'Payment Frequency Pay:') !!}
    {!! Form::number('payment_frequency_pay', null, ['class' => 'form-control']) !!}
</div>

<!-- Duration Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('duration_unit', 'Duration Unit:') !!}
    {!! Form::text('duration_unit', null, ['class' => 'form-control']) !!}
</div>

<!-- Duration Field -->
<div class="form-group col-sm-6">
    {!! Form::label('duration', 'Duration:') !!}
    {!! Form::number('duration', null, ['class' => 'form-control']) !!}
</div>

<!-- Payment Frequency Field -->
<div class="form-group col-sm-6">
    {!! Form::label('payment_frequency', 'Payment Frequency:') !!}
    {!! Form::text('payment_frequency', null, ['class' => 'form-control']) !!}
</div>

<!-- Simple Interest Field -->
<div class="form-group col-sm-6">
    {!! Form::label('simple_interest', 'Simple Interest:') !!}
    {!! Form::number('simple_interest', null, ['class' => 'form-control']) !!}
</div>

<!-- Total Amount Paid Back Field -->
<div class="form-group col-sm-6">
    {!! Form::label('total_amount_paid_back', 'Total Amount Paid Back:') !!}
    {!! Form::number('total_amount_paid_back', null, ['class' => 'form-control']) !!}
</div>

<!-- Vendor Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('vendor_category_id', 'Vendor Category Id:') !!}
    {!! Form::select('vendor_category_id', $vendor_categories, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Vendors:') !!}
    {!! Form::select('user_id', $vendors, null, ['class' => 'form-control custom-select']) !!}
</div>
