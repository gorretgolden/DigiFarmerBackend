
<?php

$animal_categories = App\Models\AnimalCategory::pluck('name', 'id');

?>
<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>


<!-- Animal Category Id Field -->

<div class="form-group col-sm-6">
    {!! Form::label('animal_category_id', 'Animal  Category :') !!}
    {!! Form::select('animal_category_id', $animal_categories, null, ['class' => 'form-control custom-select']) !!}
</div>
