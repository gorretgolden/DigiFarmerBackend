<!-- Buying Price Field -->
<div class="col-sm-12">
    {!! Form::label('buying_price', 'Buying Price:') !!}
    <p>{{ $cropBuyer->buying_price }}</p>
</div>

<!-- Crop On Sale Id Field -->
<div class="col-sm-12">
    {!! Form::label('crop_on_sale_id', 'Crop On Sale Id:') !!}
    <p>{{ $cropBuyer->crop_on_sale_id }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $cropBuyer->status }}</p>
</div>

<!-- Is Bought Field -->
<div class="col-sm-12">
    {!! Form::label('is_bought', 'Is Bought:') !!}
    <p>{{ $cropBuyer->is_bought }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $cropBuyer->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $cropBuyer->updated_at }}</p>
</div>

