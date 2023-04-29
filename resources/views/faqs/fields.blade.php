<?php
$categories= App\Models\Category::where('is_active',1)->where('type','faqs')->pluck('name','id');
?>

<!-- Faq Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('faq_category_id', 'Faq Category:') !!}
    {!! Form::select('faq_category_id', $categories, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Question Field -->
<div class="form-group col-sm-6">
    {!! Form::label('question', 'Question:') !!}
    {!! Form::text('question', null, ['class' => 'form-control','maxlength' => 50]) !!}
</div>

<!-- Answer Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('answer', 'Answer:') !!}
    {!! Form::textarea('answer', null, ['class' => 'form-control','maxlength' => 255]) !!}
</div>

<!-- Enabled Field -->
<div class="form-group col-sm-6">
    {!! Form::label('enabled', 'Enabled:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', '1', null) !!}
    </label>
</div>
