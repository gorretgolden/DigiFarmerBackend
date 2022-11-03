<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $expenseCategory->name }}</p>
</div>

<!-- Standard Value Field -->
<div class="col-sm-12">
    {!! Form::label('standard_value', 'Standard Value:') !!}
    <p>{{ $expenseCategory->standard_value }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $expenseCategory->description }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $expenseCategory->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $expenseCategory->updated_at }}</p>
</div>

