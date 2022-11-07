<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $plot->name }}</p>
</div>

<!-- Crop Id Field -->
<div class="col-sm-12">
    {!! Form::label('crop_id', 'Crop Id:') !!}
    <p>{{ $plot->crop_id }}</p>
</div>

<!-- Size Field -->
<div class="col-sm-12">
    {!! Form::label('size', 'Size:') !!}
    <p>{{ $plot->size }}</p>
</div>

<!-- Latitude Field -->
<div class="col-sm-12">
    {!! Form::label('latitude', 'Latitude:') !!}
    <p>{{ $plot->latitude }}</p>
</div>

<!-- Longitude Field -->
<div class="col-sm-12">
    {!! Form::label('longitude', 'Longitude:') !!}
    <p>{{ $plot->longitude }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $plot->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $plot->updated_at }}</p>
</div>

