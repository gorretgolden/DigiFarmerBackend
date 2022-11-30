<?php
$sub_categories= App\Models\AnimalFeedSubCategory::pluck('name','id');
$vendors = App\Models\User::where('user_type','seller')->pluck('username','id');
?>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Animal Feed Sub Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('animal_feed_sub_category_id', 'Animal Feed Sub Category :') !!}
    {!! Form::select('animal_feed_sub_category_id', $sub_categories, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::number('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Price Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price_unit', 'Price Unit:') !!}
    {!! Form::text('price_unit', null, ['class' => 'form-control','placeholder'=>'kg','readonly']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Vendors:') !!}
    {!! Form::select('user_id', $vendors, null, ['class' => 'form-control custom-select']) !!}
</div>
