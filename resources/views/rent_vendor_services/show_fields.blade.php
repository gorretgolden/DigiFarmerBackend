<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $rentVendorService->name }}</p>
</div>

<!-- Rent Vendor Sub Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('rent_vendor_sub_category_id', 'Rent Vendor Sub Category Id:') !!}
    <p>{{ $rentVendorService->rent_vendor_sub_category_id }}</p>
</div>

<!-- Charge Field -->
<div class="col-sm-12">
    {!! Form::label('charge', 'Charge:') !!}
    <p>{{ $rentVendorService->charge }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $rentVendorService->description }}</p>
</div>

<!-- Image Field -->
<div class="col-sm-12">
    {!! Form::label('image', 'Image:') !!}
    <p>{{ $rentVendorService->image }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $rentVendorService->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $rentVendorService->updated_at }}</p>
</div>

