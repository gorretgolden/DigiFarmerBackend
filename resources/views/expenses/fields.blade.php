<?php
$expense_categories= App\Models\ExpenseCategory::pluck('name','id');
$plots= App\Models\Plot::pluck('name','id');
?>
<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Expense Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('expense_category_id', 'Expense Category:') !!}
    {!! Form::select('expense_category_id', $expense_categories, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Plot Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('plot_id', 'Plot:') !!}
    {!! Form::select('plot_id', $plots, null, ['class' => 'form-control custom-select']) !!}
</div>
