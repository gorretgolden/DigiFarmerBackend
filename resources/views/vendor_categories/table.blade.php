<div class="table-responsive">
    <table class="table" id="vendorCategories-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>


                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vendorCategories as $vendorCategory)
                <tr>
                    <td>
                        <img
                            src="{{ $vendorCategory->image ? $vendorCategory->image  : asset('img/crop.png') }}"
                            width="50px" height="50px"/>
                    </td>
                    <td>{{ $vendorCategory->name }}</td>




                    <td width="120">
                        {!! Form::open(['route' => ['vendorCategories.destroy', $vendorCategory->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('vendorCategories.show', [$vendorCategory->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('vendorCategories.edit', [$vendorCategory->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'onclick' => "return confirm('Are you sure you want to delete $vendorCategory->name ?')",
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="float-right">
        {{ $vendorCategories->links() }}
    </div>
</div>
