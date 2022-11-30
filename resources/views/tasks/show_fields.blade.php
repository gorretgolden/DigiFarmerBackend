<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $task->name }}</p>
</div>

<!-- Task Date Field -->
<div class="col-sm-12">
    {!! Form::label('task_date', 'Task Date:') !!}
    <p>{{ $task->task_date }}</p>
</div>

<!-- Plot Id Field -->
<div class="col-sm-12">
    {!! Form::label('plot_id', 'Plot Id:') !!}
    <p>{{ $task->plot_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $task->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $task->updated_at }}</p>
</div>

