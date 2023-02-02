<div class="table-responsive">
    <table class="table" id="tasks-table">
        <thead>
            <tr>

                <th>Name</th>
                <th>Plot</th>
                <th>Date</th>
                <th>Status</th>

                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>

                    <td>{{ $task->name }}</td>
                    <td>{{ $task->plot->name }}</td>
                    <td>{{ $task->task_date }}</td>
                    <td>{{ $task->status}}</td>



                    <td width="120">
                        {!! Form::open(['route' => ['tasks.destroy', $task->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('tasks.show', [$task->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('tasks.edit', [$task->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'onclick' => "return confirm('Are you sure you want to delete $task->name ?')",
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="float-right">
        {{ $tasks->links() }}
    </div>
</div>
