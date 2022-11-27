<div class="table-responsive">
    <table class="table" id="users-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Country</th>
                <th>Phone</th>
                <th>User Type</th>


                <th>Role</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>  <img src="{{$user->image_url ? asset('/storage/users/'.$user->image_url) : asset('img/avatar-1.png') }}" width="50px" height="50px"></td>
                    <td>{{ $user->username}}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->country_id }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->user_type }}</td>


                    <td>

                        @if (!empty($user->getRoleNames()))
                            @foreach ($user->getRoleNames() as $name)
                                <span class="badge rounded-pill bg-success">{{ $name }}</span>
                            @endforeach
                        @endif
                    </td>
                    <td width="120">
                        {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('users.show', [$user->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('users.edit', [$user->id]) }}" class='btn btn-default btn-xs'>
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
