<div class="table-responsive">
    <table class="table" id="agronomistShedules-table">
        <thead>
            <tr>
                <th>Day</th>
                <th>Agronomist Vendor Service </th>
                <th>Agronomist Vendor Service </th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($agronomistShedules as $agronomistShedule)
                <tr>
                    <td>{{ $agronomistShedule->day->name }}</td>
                    <td>{{ $agronomistShedule->agronomist_vendor_service->name }}</td>
                    <td>{{ $agronomistShedule->agronomist_vendor_service->user->username }}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['agronomistShedules.destroy', $agronomistShedule->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('agronomistShedules.show', [$agronomistShedule->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('agronomistShedules.edit', [$agronomistShedule->id]) }}"
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
