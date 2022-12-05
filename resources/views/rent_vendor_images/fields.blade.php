<?php
$rent_vendor_services = App\Models\RentVendorSubCategory::pluck('name','id');
?>



<!-- Rent Vendor Service Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rent_vendor_service_id', 'Rent Vendor Service:') !!}
    {!! Form::select('rent_vendor_service_id', $rent_vendor_services, null, ['class' => 'form-control custom-select']) !!}
</div>
