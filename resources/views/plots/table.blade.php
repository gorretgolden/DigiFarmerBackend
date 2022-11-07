<div class="table-responsive">
    <table class="table" id="plots-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Size</th>
                <th>Farm</th>
                <th>Crop</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($plots as $plot)
                <tr>
                    <td>{{ $plot->name }}</td>
                    <td>{{ $plot->size }}  {{ $plot->size_unit }}</td>
                    <td>{{ $plot->farm->name }}</td>
                    <td>{{ $plot->crop->name }}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['plots.destroy', $plot->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('plots.show', [$plot->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('plots.edit', [$plot->id]) }}" class='btn btn-default btn-xs'>
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
