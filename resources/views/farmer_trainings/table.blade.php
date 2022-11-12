<div class="table-responsive">
    <table class="table" id="farmerTrainings-table">
        <thead>
        <tr>
            <th>User Id</th>
        <th>Training Vendor Service Id</th>
        <th>Starting Date</th>
        <th>Ending Date</th>
        <th>Access</th>
        <th>Period</th>
        <th>Period Unit</th>
        <th>Farmer Time</th>
        <th>Status</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($farmerTrainings as $farmerTraining)
            <tr>
                <td>{{ $farmerTraining->user_id }}</td>
            <td>{{ $farmerTraining->training_vendor_service_id }}</td>
            <td>{{ $farmerTraining->starting_date }}</td>
            <td>{{ $farmerTraining->ending_date }}</td>
            <td>{{ $farmerTraining->access }}</td>
            <td>{{ $farmerTraining->period }}</td>
            <td>{{ $farmerTraining->period_unit }}</td>
            <td>{{ $farmerTraining->farmer_time }}</td>
            <td>{{ $farmerTraining->status }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['farmerTrainings.destroy', $farmerTraining->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('farmerTrainings.show', [$farmerTraining->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('farmerTrainings.edit', [$farmerTraining->id]) }}"
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
