<div class="table-responsive">
    <table class="table" id="sellerProductCategories-table">
        <thead>
        <tr>
            <th>Name</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sellerProductCategories as $sellerProductCategory)
            <tr>
                <td>{{ $sellerProductCategory->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['sellerProductCategories.destroy', $sellerProductCategory->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('sellerProductCategories.show', [$sellerProductCategory->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('sellerProductCategories.edit', [$sellerProductCategory->id]) }}"
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
