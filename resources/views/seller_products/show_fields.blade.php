<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $sellerProduct->name }}</p>
</div>

<!-- Image Field -->
<div class="col-sm-12">
    {!! Form::label('image', 'Image:') !!}
    <p>{{ $sellerProduct->image }}</p>
</div>

<!-- Price Field -->
<div class="col-sm-12">
    {!! Form::label('price', 'Price:') !!}
    <p>{{ $sellerProduct->price }}</p>
</div>

<!-- Stock Amount Field -->
<div class="col-sm-12">
    {!! Form::label('stock_amount', 'Stock Amount:') !!}
    <p>{{ $sellerProduct->stock_amount }}</p>
</div>

<!-- Is Verified Field -->
<div class="col-sm-12">
    {!! Form::label('is_verified', 'Is Verified:') !!}
    <p>{{ $sellerProduct->is_verified }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $sellerProduct->status }}</p>
</div>

<!-- Price Unit Field -->
<div class="col-sm-12">
    {!! Form::label('price_unit', 'Price Unit:') !!}
    <p>{{ $sellerProduct->price_unit }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $sellerProduct->description }}</p>
</div>

<!-- Seller Product Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('seller_product_category_id', 'Seller Product Category Id:') !!}
    <p>{{ $sellerProduct->seller_product_category_id }}</p>
</div>

<!-- Vendor Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('vendor_category_id', 'Vendor Category Id:') !!}
    <p>{{ $sellerProduct->vendor_category_id }}</p>
</div>

<!-- Location Field -->
<div class="col-sm-12">
    {!! Form::label('location', 'Location:') !!}
    <p>{{ $sellerProduct->location }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $sellerProduct->user_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $sellerProduct->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $sellerProduct->updated_at }}</p>
</div>

