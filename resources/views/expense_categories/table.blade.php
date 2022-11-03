<div class="table-responsive">
    <table class="table" id="expenseCategories-table">
        <thead>
        <tr>
            <th>Name</th>
        <th>Standard Value</th>
        <th>Description</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($expenseCategories as $expenseCategory)
            <tr>
                <td>{{ $expenseCategory->name }}</td>
            <td>{{ $expenseCategory->standard_value }}</td>
            <td>{{ $expenseCategory->description }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['expenseCategories.destroy', $expenseCategory->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('expenseCategories.show', [$expenseCategory->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('expenseCategories.edit', [$expenseCategory->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
