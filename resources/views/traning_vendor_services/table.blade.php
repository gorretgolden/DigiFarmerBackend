<div class="table-responsive">
    <table class="table" id="traningVendorServices-table">
        <thead>
        <tr>
            <th>Name</th>
        <th>Charge</th>
        <th>Description</th>
        <th>Vendor Category Id</th>
        <th>User Id</th>
        <th>Slots</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($traningVendorServices as $traningVendorService)
            <tr>
                <td>{{ $traningVendorService->name }}</td>
            <td>{{ $traningVendorService->charge }}</td>
            <td>{{ $traningVendorService->description }}</td>
            <td>{{ $traningVendorService->vendor_category_id }}</td>
            <td>{{ $traningVendorService->user_id }}</td>
            <td>{{ $traningVendorService->slots }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['traningVendorServices.destroy', $traningVendorService->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('traningVendorServices.show', [$traningVendorService->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('traningVendorServices.edit', [$traningVendorService->id]) }}"
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
