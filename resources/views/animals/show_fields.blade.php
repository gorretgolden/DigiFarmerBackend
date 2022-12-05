<!-- Animal Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('animal_category_id', 'Animal Category Id:') !!}
    <p>{{ $animal->animal_category_id }}</p>
</div>

<!-- Plot Id Field -->
<div class="col-sm-12">
    {!! Form::label('plot_id', 'Plot Id:') !!}
    <p>{{ $animal->plot_id }}</p>
</div>

<!-- Total Field -->
<div class="col-sm-12">
    {!! Form::label('total', 'Total:') !!}
    <p>{{ $animal->total }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $animal->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $animal->updated_at }}</p>
</div>

