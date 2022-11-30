<?php
$plots = App\Models\Plot::all();
?>


<!-- Quantity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity', 'Quantity:') !!}
    {!! Form::number('quantity', null, ['class' => 'form-control']) !!}
</div>

<!-- Quantity Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity_unit', 'Quantity Unit:') !!}
    {!! Form::text('quantity_unit', null, ['class' => 'form-control']) !!}
</div>

{{-- <!-- Plot Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('plot_id', 'Plot Id:') !!}
    {!! Form::select('plot_id', $plots, null, ['class' => 'form-control custom-select']) !!}
</div> --}}


<select class="custom-select" name="plot_id" >
    <option value="" selected disabled hidden>Select Plot for harvest</option>
    @foreach ($plots as $plot)
        <option value="{{ $plot->id }}">
            {{ $plot->name}}  on {{ $plot->farm->name}} by Farmer: {{ $plot->farm->user->username}}
        </option>
    @endforeach

</select>


