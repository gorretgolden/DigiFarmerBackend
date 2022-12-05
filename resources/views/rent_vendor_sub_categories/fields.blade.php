<?php
$rent_categories= App\Models\RentVendorCategory::pluck('name','id');
?>


<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Rent Vendor Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rent_vendor_category_id', 'Rent Vendor Category:') !!}
    {!! Form::select('rent_vendor_category_id', $rent_categories, null, ['class' => 'form-control custom-select']) !!}
</div>
