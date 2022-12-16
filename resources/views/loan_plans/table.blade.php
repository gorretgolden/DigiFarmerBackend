<div class="table-responsive">
    <table class="table" id="loanPlans-table">
        <thead>
        <tr>
            <th>Value</th>
        <th>Period Unit</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($loanPlans as $loanPlan)
            <tr>
                <td>{{ $loanPlan->value }}</td>
            <td>{{ $loanPlan->period_unit }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['loanPlans.destroy', $loanPlan->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('loanPlans.show', [$loanPlan->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('loanPlans.edit', [$loanPlan->id]) }}"
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
