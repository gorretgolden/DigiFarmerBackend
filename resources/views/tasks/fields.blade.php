
<?php
$plots= App\Models\Plot::all();
?>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>'Enter task name']) !!}
</div>

<!-- Task Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('task_date', 'Task Date:') !!}
    {!! Form::text('task_date', null, ['class' => 'form-control','id'=>'task_date','placeholder'=>'Enter task date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#task_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Plot Id Field -->
<select class="custom-select" name="plot_id" >
    <option value="" selected disabled hidden>Select Plot for task</option>
    @foreach ($plots as $plot)
        <option value="{{ $plot->id }}">
            {{ $plot->name}}  on {{ $plot->farm->name}} by Farmer: {{ $plot->farm->user->username}}
        </option>
    @endforeach

</select>
