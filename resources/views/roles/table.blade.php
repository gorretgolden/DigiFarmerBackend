<div class="table-responsive">
    <table class="table" id="roles-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <th>{{ $role->id}}</th>
                    <td>{{ $role->name }}</td>
                    <td width="120">
                        @role('admin')
                            {!! Form::open(['route' => ['roles.destroy', $role->id], 'method' => 'delete']) !!}
                        @endrole
                        <div class='btn-group'>
                            @role('admin')
                                <a href="{{ route('roles.show', [$role->id]) }}" class='btn btn-default btn-xs'>
                                    <i class="far fa-eye"></i>
                                </a>
                            @endrole
                            @role('admin')
                                <a href="{{ route('roles.edit', [$role->id]) }}" class='btn btn-default btn-xs'>
                                    <i class="far fa-edit"></i>
                                </a>
                            @endrole
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'onclick' => "return confirm('Are you sure you want to delete'. $role->name .'role?')",
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
