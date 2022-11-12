<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $traningVendorService->name }}</p>
</div>

<!-- Charge Field -->
<div class="col-sm-12">
    {!! Form::label('charge', 'Charge:') !!}
    <p>{{ $traningVendorService->charge }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $traningVendorService->description }}</p>
</div>

<!-- Vendor Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('vendor_category_id', 'Vendor Category Id:') !!}
    <p>{{ $traningVendorService->vendor_category_id }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $traningVendorService->user_id }}</p>
</div>

<!-- Slots Field -->
<div class="col-sm-12">
    {!! Form::label('slots', 'Slots:') !!}
    <p>{{ $traningVendorService->slots }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $traningVendorService->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $traningVendorService->updated_at }}</p>
</div>

