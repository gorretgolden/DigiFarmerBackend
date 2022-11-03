<div class="table-responsive">
    <table class="table" id="plots-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Crop </th>
                <th>Size</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($plots as $plot)
                <tr>
                    <td>{{ $plot->name }}</td>
                    <td>{{ $plot->crop_id }}</td>
                    <td>{{ $plot->size }}</td>
                    <td>{{ $plot->latitude }}</td>
                    <td>{{ $plot->longitude }}</td>
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
