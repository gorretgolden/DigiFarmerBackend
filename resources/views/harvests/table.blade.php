<div class="table-responsive">
    <table class="table" id="harvests-table">
        <thead>
        <tr>
            <th>Farm Id</th>
        <th>Harvest Amount</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($harvests as $harvest)
            <tr>
                <td>{{ $harvest->farm_id }}</td>
            <td>{{ $harvest->harvest_amount }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['harvests.destroy', $harvest->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('harvests.show', [$harvest->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('harvests.edit', [$harvest->id]) }}"
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
