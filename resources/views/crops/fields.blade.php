
<?php
$sub_categories= App\Models\SubCategory::pluck('name','id');
?>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>


<!-- Standard Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('standard_price', 'Standard Price:') !!}
    {!! Form::text('standard_price', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('Price Unit') !!}
    {!! Form::select('price_unit', ['per-kg' => 'per-kg'],null, ['class' => 'form-control','placeholder'=>'Select Price Unit'] ) !!}
</div>


<!-- Sub Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sub_category_id', 'Sub Category:') !!}
    {!! Form::select('sub_category_id', $sub_categories, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('image', ['class' => 'custom-file-input']) !!}
            {!! Form::label('image', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>
<div class="clearfix"></div>
