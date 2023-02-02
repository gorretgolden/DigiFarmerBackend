<div class="table-responsive">
    <table class="table" id="crops-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Standard Price</th>
                <th>Category</th>
                <th>Status</th>

                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($crops as $crop)
                <tr>
                    <td>
                        <img
                            src="{{ $crop->image ?  $crop->image : asset('img/crop.png') }}"
                            width="50px" height="50px"/>
                    </td>
                    <td>{{ $crop->name }}</td>
                    <td>{{ $crop->standard_price }} {{ $crop->price_unit}}</td>
                    <td>{{ $crop->category->name }}</td>
                    <td>
                        @if ($crop->is_active == 1)
                            <p class="badge rounded-pill bg-success">enabled</p>
                            @else
                            <p class="badge rounded-pill bg-danger">disabled</p>
                        @endif
                    </td>



                    <td width="120">
                        {!! Form::open(['route' => ['crops.destroy', $crop->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('crops.show', [$crop->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('crops.edit', [$crop->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'onclick' => "return confirm('Are you sure you want to delete $crop->name ?')",
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="float-right">
        {{ $crops->links() }}
    </div>
</div>
