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
                <th>Total Buy Requests</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($buyers as $buyer)
                <tr>
                    <td>  <img src="{{$buyer->image_url ? asset('/storage/users/'.$buyer->image_url) : asset('img/avatar-1.png') }}" width="50px" height="50px"></td>
                    <td>{{ $buyer->username}}</td>
                    <td>{{ $buyer->first_name }}</td>
                    <td>{{ $buyer->last_name }}</td>
                    <td>{{ $buyer->email }}</td>
                    <td>{{ $buyer->country->name }}</td>
                    <td>{{ $buyer->phone }}</td>
                    <td>{{ $buyer->user_type }}</td>


                    <td>

                        @if (!empty($buyer->getRoleNames()))
                            @foreach ($buyer->getRoleNames() as $name)
                                <span class="badge rounded-pill bg-success">{{ $name }}</span>
                            @endforeach
                        @endif
                    </td>
                    <td class="text-center">{{ $buyer->crops_on_sale->count()}}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['buyers.destroy', $buyer->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('buyers.show', [$buyer->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('buyers.edit', [$buyer->id]) }}" class='btn btn-default btn-xs'>
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
        {{ $buyers->links() }}
    </div>
</div>
