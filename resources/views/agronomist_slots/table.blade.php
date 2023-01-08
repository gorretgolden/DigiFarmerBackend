<div class="table-responsive">
    <table class="table" id="agronomistSlots-table">
        <thead>
            <tr>
                <th>Agronomist Shedule</th>
                <th>Time</th>
                <th>Status</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($agronomistSlots as $agronomistSlot)
                <tr>
                    <td>{{ $agronomistSlot->agronomist_shedule_id }}</td>
                    <td>{{ $agronomistSlot->time }}</td>
                    <td>
                        @if ($agronomistSlot->status ==0)
                        <span class="badge rounded-pill bg-success">available</span>
                        @else
                        <span class="badge rounded-pill bg-success">taken</span>
                        @endif
                    </td>
                    <td width="120">
                        {!! Form::open(['route' => ['agronomistSlots.destroy', $agronomistSlot->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('agronomistSlots.show', [$agronomistSlot->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('agronomistSlots.edit', [$agronomistSlot->id]) }}"
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
