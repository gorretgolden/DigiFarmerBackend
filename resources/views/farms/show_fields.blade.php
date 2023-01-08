<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $farm->name }}</p>
</div>

<!-- Owner Field -->
<div class="col-sm-12">
    {!! Form::label('owner', 'Owner:') !!}
    <p>{{ $farm->owner }}</p>
</div>

<!-- Field Area Field -->
<div class="col-sm-12">
    {!! Form::label('field_area', 'Field Area:') !!}
    <p>{{ $farm->field_area }}</p>
</div>

<!-- Size Unit Field -->
<div class="col-sm-12">
    {!! Form::label('size_unit', 'Size Unit:') !!}
    <p>{{ $farm->size_unit }}</p>
</div>

<!-- Address Id Field -->
<div class="col-sm-12">
    {!! Form::label('address_id', 'Address Id:') !!}
    <p>{{ $farm->address_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $farm->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $farm->updated_at }}</p>
</div>

