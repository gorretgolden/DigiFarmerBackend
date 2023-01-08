<?php
$categories= App\Models\FaqCategory::pluck('name','id');
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
