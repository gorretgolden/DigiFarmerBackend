<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $rentVendorSubCategory->name }}</p>
</div>

<!-- Rent Vendor Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('rent_vendor_category_id', 'Rent Vendor Category Id:') !!}
    <p>{{ $rentVendorSubCategory->rent_vendor_category_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $rentVendorSubCategory->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $rentVendorSubCategory->updated_at }}</p>
</div>

