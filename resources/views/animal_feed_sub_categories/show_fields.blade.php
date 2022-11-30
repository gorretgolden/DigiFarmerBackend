<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $animalFeedSubCategory->name }}</p>
</div>

<!-- Animal Feed Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('animal_feed_category_id', 'Animal Feed Category Id:') !!}
    <p>{{ $animalFeedSubCategory->animal_feed_category_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $animalFeedSubCategory->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $animalFeedSubCategory->updated_at }}</p>
</div>

