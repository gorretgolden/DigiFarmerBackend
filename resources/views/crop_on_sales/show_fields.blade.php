<!-- Quantity Field -->
<div class="col-sm-12">
    {!! Form::label('quantity', 'Quantity:') !!}
    <p>{{ $cropOnSale->quantity }}</p>
</div>

<!-- Selling Price Field -->
<div class="col-sm-12">
    {!! Form::label('selling_price', 'Selling Price:') !!}
    <p>{{ $cropOnSale->selling_price }}</p>
</div>

<!-- Quantity Unit Field -->
<div class="col-sm-12">
    {!! Form::label('quantity_unit', 'Quantity Unit:') !!}
    <p>{{ $cropOnSale->quantity_unit }}</p>
</div>

<!-- Price Unit Field -->
<div class="col-sm-12">
    {!! Form::label('price_unit', 'Price Unit:') !!}
    <p>{{ $cropOnSale->price_unit }}</p>
</div>

<!-- Is Sold Field -->
<div class="col-sm-12">
    {!! Form::label('is_sold', 'Is Sold:') !!}
    <p>{{ $cropOnSale->is_sold }}</p>
</div>

<!-- Crop Id Field -->
<div class="col-sm-12">
    {!! Form::label('crop_id', 'Crop Id:') !!}
    <p>{{ $cropOnSale->crop_id }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $cropOnSale->user_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $cropOnSale->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $cropOnSale->updated_at }}</p>
</div>

