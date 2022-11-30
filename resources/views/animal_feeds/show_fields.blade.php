<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $animalFeed->name }}</p>
</div>

<!-- Animal Feed Sub Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('animal_feed_sub_category_id', 'Animal Feed Sub Category Id:') !!}
    <p>{{ $animalFeed->animal_feed_sub_category_id }}</p>
</div>

<!-- Price Field -->
<div class="col-sm-12">
    {!! Form::label('price', 'Price:') !!}
    <p>{{ $animalFeed->price }}</p>
</div>

<!-- Price Unit Field -->
<div class="col-sm-12">
    {!! Form::label('price_unit', 'Price Unit:') !!}
    <p>{{ $animalFeed->price_unit }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $animalFeed->description }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $animalFeed->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $animalFeed->updated_at }}</p>
</div>

