<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $plot->name }}</p>
</div>

<!-- Size Field -->
<div class="col-sm-12">
    {!! Form::label('size', 'Size:') !!}
    <p>{{ $plot->size }}</p>
</div>

<!-- Size Unit Field -->
<div class="col-sm-12">
    {!! Form::label('size_unit', 'Size Unit:') !!}
    <p>{{ $plot->size_unit }}</p>
</div>

<!-- Farm Id Field -->
<div class="col-sm-12">
    {!! Form::label('farm_id', 'Farm Id:') !!}
    <p>{{ $plot->farm_id }}</p>
</div>

<!-- Crop Id Field -->
<div class="col-sm-12">
    {!! Form::label('crop_id', 'Crop Id:') !!}
    <p>{{ $plot->crop_id }}</p>
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

