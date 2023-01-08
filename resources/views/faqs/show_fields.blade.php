<!-- Faq Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('faq_category_id', 'Faq Category Id:') !!}
    <p>{{ $faq->faq_category_id }}</p>
</div>

<!-- Question Field -->
<div class="col-sm-12">
    {!! Form::label('question', 'Question:') !!}
    <p>{{ $faq->question }}</p>
</div>

<!-- Answer Field -->
<div class="col-sm-12">
    {!! Form::label('answer', 'Answer:') !!}
    <p>{{ $faq->answer }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $faq->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $faq->updated_at }}</p>
</div>

