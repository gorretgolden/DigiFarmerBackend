<!-- Amount Field -->
<div class="col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $expense->amount }}</p>
</div>

<!-- Expense Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('expense_category_id', 'Expense Category Id:') !!}
    <p>{{ $expense->expense_category_id }}</p>
</div>

<!-- Plot Id Field -->
<div class="col-sm-12">
    {!! Form::label('plot_id', 'Plot Id:') !!}
    <p>{{ $expense->plot_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $expense->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $expense->updated_at }}</p>
</div>

