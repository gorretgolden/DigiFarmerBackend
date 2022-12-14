<div class="table-responsive">
    <table class="table" id="userVerifications-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>User Id</th>
                <th>Verification Status</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userVerifications as $userVerification)
                <tr>
                    <td>
                        <img class="w-25" src="{{ $userVerification->image }}" />
                    </td>
                    <td>{{ $userVerification->user_id }}</td>
                    <td>{{ $userVerification->verified }}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['userVerifications.destroy', $userVerification->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('userVerifications.show', [$userVerification->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('userVerifications.edit', [$userVerification->id]) }}"
                                class='btn btn-default btn-xs'>
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
