<div class="table-responsive">
    <table class="table" id="cropOnSales-table">
        <thead>
        <tr>
            <th>Quantity</th>
        <th>Selling Price</th>
        <th>Price Unit</th>
        <th>Description</th>
        <th>Image</th>
        <th>Status</th>
        <th>Crop Id</th>
        <th>User Id</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cropOnSales as $cropOnSale)
            <tr>
                <td>{{ $cropOnSale->quantity }}</td>
            <td>{{ $cropOnSale->selling_price }}</td>
            <td>{{ $cropOnSale->price_unit }}</td>
            <td>{{ $cropOnSale->description }}</td>
            <td>{{ $cropOnSale->image }}</td>
            <td>{{ $cropOnSale->status }}</td>
            <td>{{ $cropOnSale->crop_id }}</td>
            <td>{{ $cropOnSale->user_id }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['cropOnSales.destroy', $cropOnSale->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('cropOnSales.show', [$cropOnSale->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('cropOnSales.edit', [$cropOnSale->id]) }}"
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
