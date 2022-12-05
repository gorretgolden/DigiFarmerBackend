<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $insuaranceVendorService->name }}</p>
</div>

<!-- Terms Field -->
<div class="col-sm-12">
    {!! Form::label('terms', 'Terms:') !!}
    <p>{{ $insuaranceVendorService->terms }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $insuaranceVendorService->description }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $insuaranceVendorService->user_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $insuaranceVendorService->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $insuaranceVendorService->updated_at }}</p>
</div>

