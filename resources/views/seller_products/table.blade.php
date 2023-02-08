<div class="table-responsive">
    <table class="table" id="sellerProducts-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>In Stock</th>
                <th>Category</th>
                <th>Vendor Name</th>
                <th>Phone Number</th>
                <th>Location</th>
                <th>Status</th>
                <th>Verified</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sellerProducts as $sellerProduct)
                <tr>
                    <td>
                        <img src="{{ $sellerProduct->image ?  $sellerProduct->image : asset('img/crop.png') }}"
                            width="50px" height="50px" />
                    </td>
                    <td>{{ $sellerProduct->name }}</td>
                    <td>{{ $sellerProduct->price }}</td>
                    <td class="text-center">{{ $sellerProduct->stock_amount }}</td>
                    <td>{{ $sellerProduct->seller_product_category->name }}</td>
                    <td>{{ $sellerProduct->user->username }}</td>
                    <td>{{ $sellerProduct->user->phone}}</td>
                    <td>{{ $sellerProduct->location }}</td>
                    <td>{{$sellerProduct->status}}</td>
                    <td>
                        @if ($sellerProduct->is_verified == 1)
                            <p class="badge rounded-pill bg-success">Yes</p>
                            @else
                            <p class="badge rounded-pill bg-danger">No</p>
                        @endif
                    </td>
                    <td width="120">
                        {!! Form::open(['route' => ['sellerProducts.destroy', $sellerProduct->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('sellerProducts.show', [$sellerProduct->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('sellerProducts.edit', [$sellerProduct->id]) }}"
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

    <div class="float-right">
        {{ $sellerProducts->links() }}
    </div>
</div>
