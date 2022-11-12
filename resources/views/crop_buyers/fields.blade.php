<!-- Buying Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('buying_price', 'Buying Price:') !!}
    {!! Form::number('buying_price', null, ['class' => 'form-control']) !!}
</div>

<!-- Crop On Sale Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('crop_on_sale_id', 'Crop On Sale Id:') !!}
    {!! Form::select('crop_on_sale_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Is Bought Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('is_bought', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('is_bought', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_bought', 'Is Bought', ['class' => 'form-check-label']) !!}
    </div>
</div>
