<!-- Url Field -->
<div class="col-sm-12">
    {!! Form::label('url', 'Url:') !!}
    <p>{{ $rentVendorImage->url }}</p>
</div>

<!-- Rent Vendor Service Id Field -->
<div class="col-sm-12">
    {!! Form::label('rent_vendor_service_id', 'Rent Vendor Service Id:') !!}
    <p>{{ $rentVendorImage->rent_vendor_service_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $rentVendorImage->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $rentVendorImage->updated_at }}</p>
</div>

