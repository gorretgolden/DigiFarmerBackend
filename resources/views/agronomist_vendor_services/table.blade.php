<div class="table-responsive">
    <table class="table" id="agronomistVendorServices-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Charge</th>
                <th>Availability</th>
                <th>User </th>
                <th>Vendor Category </th>
                <th>Zoom Details</th>
                <th>Location Details</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($agronomistVendorServices as $agronomistVendorService)
                <tr>
                    <td>
                        <img style="width: 20%" src=" {{asset('/storage/agronomists/'. $agronomistVendorService->image)}}"/>
                     </td>
                    <td>{{ $agronomistVendorService->name }}</td>

                    <td>{{ $agronomistVendorService->charge }} {{ $agronomistVendorService->charge_unit }}</td>

                    <td>{{ $agronomistVendorService->availability }}</td>

                    <td>{{ $agronomistVendorService->user->username }}</td>
                    <td>{{ $agronomistVendorService->vendor_category->name }}</td>
                    <td>{{ $agronomistVendorService->zoom_details }}</td>
                    <td>{{ $agronomistVendorService->location_details }}</td>
                    <td width="120">
                        {!! Form::open([
                            'route' => ['agronomistVendorServices.destroy', $agronomistVendorService->id],
                            'method' => 'delete',
                        ]) !!}
                        <div class='btn-group'>
                            <a href="{{ route('agronomistVendorServices.show', [$agronomistVendorService->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('agronomistVendorServices.edit', [$agronomistVendorService->id]) }}"
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
