<div class="table-responsive">
    <table class="table" id="crops-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Standard Price</th>
                <th>Sub Category</th>
                <th>Image</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($crops as $crop)
                <tr>
                    <td>{{ $crop->name }}</td>
                    <td>{{ $crop->standard_price }} {{ $crop->price_unit}}</td>
                    <td>{{ $crop->sub_category->name }}</td>

                    <td>
                        <img
                            src="{{ $crop->image ? asset('/storage/crops/' . $crop->image) : asset('img/avatar-1.png') }}"
                            width="50px" height="50px"/>
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
