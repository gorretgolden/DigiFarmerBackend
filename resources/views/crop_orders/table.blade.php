{{-- @push('third_party_stylesheets')
    @include('layouts.datatables_css')
@endpush

{!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']) !!}

@push('third_party_scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endpush --}}


<div class="table-responsive">
    <table class="table" id="crops-table">
        <thead>
            <tr>
                <th>Is Paid</th>
                <th>Is Accepted</th>
                <th>Crop Buyer</th>
                <th>Total Buy Requests</th>
                <th class="text-center">Crop On Sale Details</th>


                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>
                        @if ($order->is_paid == 0)
                        <span class="badge rounded-pill bg-warning">Not paid</span>
                        @else
                        <span class="badge rounded-pill bg-success">Paid</span>

                        @endif
                    </td>
                    <td>
                        @if ($order->is_accepted == 0)
                        <span class="badge rounded-pill bg-info">Price not accepted</span>
                        @else
                        <span class="badge rounded-pill bg-success">Price accepted</span>

                        @endif

                    </td>
                    <td>{{ $order->user->username }}</td>
                    <td class="text-center"><span class="badge rounded-pill bg-success text-center">{{ $order->user->crop_orders->count() }}</span></td>

                    {{-- <td>
                        <ul>
                        @foreach($order->crop_on_sale as $item)
                            <li> Crop:  {{ $item->crop->name}} Farmer: {{ $item->user->username}}   Buying Price Request: UGX {{ $item->pivot->buying_price}} Quantity: {{ $item->quantity }}{{ $item->quantity_unit }}</li>
                        @endforeach
                        </ul>
                    </td> --}}
                    <td>



                    <td width="120">
                        {!! Form::open(['route' => ['cropOrders.destroy', $order->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('cropOrders.show', [$order->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('cropOrders.edit', [$order->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'onclick' => "return confirm('Are you sure you want to delete this order ?')",
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- <div class="float-right">
        {{ $orders->links() }}
    </div> --}}
</div>
