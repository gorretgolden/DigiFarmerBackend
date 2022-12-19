<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Is Private Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_private', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_private', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_private', 'Is Private', ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Created By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created_by', 'Created By:') !!}
    {!! Form::select('created_by', ], null, ['class' => 'form-control custom-select']) !!}
</div>
