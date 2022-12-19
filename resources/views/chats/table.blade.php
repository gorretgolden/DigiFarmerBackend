<div class="table-responsive">
    <table class="table" id="chats-table">
        <thead>
        <tr>
            <th>Name</th>
        <th>Is Private</th>
        <th>Created By</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($chats as $chat)
            <tr>
                <td>{{ $chat->name }}</td>
            <td>{{ $chat->is_private }}</td>
            <td>{{ $chat->created_by }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['chats.destroy', $chat->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('chats.show', [$chat->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('chats.edit', [$chat->id]) }}"
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
