<div class="table-responsive">
    <table class="table" id="loanPayBacks-table">
        <thead>
        <tr>
            <th>Name</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($loanPayBacks as $loanPayBack)
            <tr>
                <td>{{ $loanPayBack->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['loanPayBacks.destroy', $loanPayBack->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('loanPayBacks.show', [$loanPayBack->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('loanPayBacks.edit', [$loanPayBack->id]) }}"
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
