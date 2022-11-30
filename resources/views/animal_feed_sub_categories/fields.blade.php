<?php
$categories = App\Models\AnimalFeedCategory::pluck('name','id');
?>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Animal Feed Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('animal_feed_category_id', 'Animal Feed Category:') !!}
    {!! Form::select('animal_feed_category_id', $categories, null, ['class' => 'form-control custom-select']) !!}
</div>
