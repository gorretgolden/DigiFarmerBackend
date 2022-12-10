<div class="table-responsive">
    <table class="table" id="users-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>

                <th>Role</th>
                <th>Total Farms</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($farmers as $farmer)
                <tr>
                    <td>  <img src="{{$farmer->image_url ? asset('/storage/users/'.$farmer->image_url) : asset('img/avatar-1.png') }}" width="50px" height="50px"></td>
                    <td>{{ $farmer->username}}</td>
                    <td>{{ $farmer->first_name }}</td>
                    <td>{{ $farmer->last_name }}</td>
                    <td>{{ $farmer->email }}</td>

                    <td>{{ $farmer->phone }}</td>





                    <td>

                        @if (!empty($farmer->getRoleNames()))
                            @foreach ($farmer->getRoleNames() as $name)
                                <span class="badge rounded-pill bg-success">{{ $name }}</span>
                            @endforeach
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $farmer->farms->count()}}

                    </td>
                    <td width="120">
                        {!! Form::open(['route' => ['farmers.destroy', $farmer->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('farmers.show', [$farmer->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('farmers.edit', [$farmer->id]) }}" class='btn btn-default btn-xs'>
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

    <div class="float-right">
        {{ $farmers->links() }}
    </div>
</div>
