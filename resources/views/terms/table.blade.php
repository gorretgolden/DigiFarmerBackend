<div class="table-responsive">
    <table class="table" id="terms-table">
        <thead>
        <tr>
            <th>Title</th>
        <th>Description</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($terms as $terms)
            <tr>
                <td>{{ $terms->title }}</td>
            <td>{{ $terms->description }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['terms.destroy', $terms->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('terms.show', [$terms->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('terms.edit', [$terms->id]) }}"
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
