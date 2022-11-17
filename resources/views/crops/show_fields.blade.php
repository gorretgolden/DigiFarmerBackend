<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $crop->name }}</p>
</div>

<!-- Standard Price Field -->

<div class="col-sm-12">
    {!! Form::label('standard_price', 'Standard Price:') !!}
    <p>{{ $crop->standard_price }} {{ $crop->price_unit}}</p>
</div>
<!-- Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('sub_category_id', 'Sub Category :') !!}
    <p>{{ $crop->sub_category->name }}</p>
</div>

<!-- Image Field -->
<div class="col-sm-12">
    {!! Form::label('image', 'Image:') !!}
    <p>{{ $crop->image }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $crop->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $crop->updated_at }}</p>
</div>

