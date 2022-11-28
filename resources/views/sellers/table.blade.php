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
                <th>Total Products For Sale</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sellers as $seller)
                <tr>
                    <td>  <img src="{{$seller->image_url ? asset('/storage/users/'.$seller->image_url) : asset('img/avatar-1.png') }}" width="50px" height="50px"></td>
                    <td>{{ $seller->username}}</td>
                    <td>{{ $seller->first_name }}</td>
                    <td>{{ $seller->last_name }}</td>
                    <td>{{ $seller->email }}</td>
                    <td>{{ $seller->country->name }}</td>
                    <td>{{ $seller->phone }}</td>
                    <td>{{ $seller->user_type }}</td>


                    <td>

                        @if (!empty($seller->getRoleNames()))
                            @foreach ($seller->getRoleNames() as $name)
                                <span class="badge rounded-pill bg-success">{{ $name }}</span>
                            @endforeach
                        @endif
                    </td>
                    <td class="text-center">{{ $seller->seller_products->count()}}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['sellers.destroy', $seller->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('sellers.show', [$seller->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('sellers.edit', [$seller->id]) }}" class='btn btn-default btn-xs'>
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
        {{ $sellers->links() }}
    </div>
</div>
