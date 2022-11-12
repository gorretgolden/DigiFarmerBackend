<div class="table-responsive">
    <table class="table" id="cropBuyers-table">
        <thead>
        <tr>
            <th>Buying Price</th>
        <th>Crop On Sale Id</th>
        <th>Status</th>
        <th>Is Bought</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cropBuyers as $cropBuyer)
            <tr>
                <td>{{ $cropBuyer->buying_price }}</td>
            <td>{{ $cropBuyer->crop_on_sale_id }}</td>
            <td>{{ $cropBuyer->status }}</td>
            <td>{{ $cropBuyer->is_bought }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['cropBuyers.destroy', $cropBuyer->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('cropBuyers.show', [$cropBuyer->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('cropBuyers.edit', [$cropBuyer->id]) }}"
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
