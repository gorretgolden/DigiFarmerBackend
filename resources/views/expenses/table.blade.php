<div class="table-responsive">
    <table class="table" id="expenses-table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Farm</th>
                <th>Amount</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $expense)
                <tr>
                    <td>{{ $expense->category_id }}</td>
                    <td>{{ $expense->farm_id }}</td>
                    <td>{{ $expense->amount }}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['expenses.destroy', $expense->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('expenses.show', [$expense->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('expenses.edit', [$expense->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'onclick' => "return confirm('Are you sure?')",
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
