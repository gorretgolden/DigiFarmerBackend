<?php
$plots = App\Models\Plot::all();
$animal_categories = App\Models\AnimalCategory::pluck('name','id');
?>


<!-- Animal Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('animal_category_id', 'Animal Category:') !!}
    {!! Form::select('animal_category_id', $animal_categories, null, ['class' => 'form-control custom-select']) !!}
</div>

<select class="custom-select" name="plot_id" >
    <option value="" selected disabled hidden>Select Animal Plot</option>
    @foreach ($plots as $plot)
        <option value="{{ $plot->id }}">
            {{ $plot->name}}  on {{ $plot->farm->name}} by Farmer: {{ $plot->farm->user->username}}
        </option>
    @endforeach

</select>

<!-- Plot Id Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('plot_id', 'Plot Id:') !!}
    {!! Form::select('plot_id', ], null, ['class' => 'form-control custom-select']) !!}
</div> --}}


<!-- Total Field -->
<div class="form-group col-sm-6">
    {!! Form::label('total', 'Total:') !!}
    {!! Form::number('total', null, ['class' => 'form-control']) !!}
</div>
