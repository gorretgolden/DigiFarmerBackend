<div class="table-responsive">
    <table class="table" id="terms-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>status</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($terms as $term)
                <tr>
                    <td>{{ $term->title }}</td>
                    <td>
                        {{ substr($term->description, 0, 50) }}

                    </td>
                    <td>
                        @if ($term->is_active == 1)
                            <p class="badge rounded-pill bg-success">enabled</p>
                        @else
                            <p class="badge rounded-pill bg-danger">disabled</p>
                        @endif
                    </td>

                    <td width="120">
                        {!! Form::open(['route' => ['terms.destroy', $term->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('terms.show', [$term->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('terms.edit', [$term->id]) }}" class='btn btn-default btn-xs'>
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
