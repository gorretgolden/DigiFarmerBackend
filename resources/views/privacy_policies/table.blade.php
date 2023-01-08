<div class="table-responsive">
    <table class="table" id="privacyPolicies-table">
        <thead>
        <tr>
            <th>Title</th>
        <th>Description</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($privacyPolicies as $privacyPolicy)
            <tr>
                <td>{{ $privacyPolicy->title }}</td>
            <td>{{ $privacyPolicy->description }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['privacyPolicies.destroy', $privacyPolicy->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('privacyPolicies.show', [$privacyPolicy->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('privacyPolicies.edit', [$privacyPolicy->id]) }}"
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

    <div class="float-right">
        {{ $privacyPolicies->links() }}
    </div>
</div>
