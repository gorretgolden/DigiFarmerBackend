<div class="table-responsive">
    <table class="table" id="farms-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>District</th>
                <th>Address</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Field Area</th>
                <th>User </th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($farms as $farm)
                <tr>
                    <td>{{ $farm->name }}</td>
                    <td>{{ $farm->district_id }}</td>
                    <td>{{ $farm->address }}</td>
                    <td>{{ $farm->latitude }}</td>
                    <td>{{ $farm->longitude }}</td>
                    <td>{{ $farm->field_area }}</td>
                    <td>{{ $farm->user_id }}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['farms.destroy', $farm->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('farms.show', [$farm->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('farms.edit', [$farm->id]) }}" class='btn btn-default btn-xs'>
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
