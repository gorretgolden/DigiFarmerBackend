<div class="table-responsive">
    <table class="table" id="sellerProducts-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th>
                <th>Seller</th>
                <th>Location</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sellerProducts as $sellerProduct)
                <tr>
                    <td>
                        <img src="{{ $sellerProduct->image ? asset('/storage/seller_products/' . $sellerProduct->image) : asset('img/crop.png') }}"
                            width="50px" height="50px" />
                    </td>
                    <td>{{ $sellerProduct->name }}</td>
                    <td>{{ $sellerProduct->description }}</td>
                    <td>{{ $sellerProduct->price }}</td>

                    <td>{{ $sellerProduct->seller_product_category->name }}</td>
                    <td>{{ $sellerProduct->user->username }}</td>
                    <td>{{ $sellerProduct->address->district_name }}</td>
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
