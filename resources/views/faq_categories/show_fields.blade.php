<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $faqCategory->name }}</p>
</div>

<!-- Image Field -->
<div class="col-sm-12">
    {!! Form::label('image', 'Image:') !!}
    <p>{{ $faqCategory->image }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $faqCategory->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $faqCategory->updated_at }}</p>
</div>

