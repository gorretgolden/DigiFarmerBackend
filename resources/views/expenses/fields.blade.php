
<?php
$expense_categories = App\Models\ExpenseCategory::pluck('name','id');
$farms = App\Models\Farm::pluck('name','id');
?>

<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'Category:') !!}
    {!! Form::select('category_id',$expense_categories, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Farm Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('farm_id', 'Farm :') !!}
    {!! Form::select('farm_id',$farms, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>
