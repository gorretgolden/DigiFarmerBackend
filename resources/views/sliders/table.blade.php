<div class="table-responsive">
    <table class="table" id="sliders-table">
        <thead>
        <tr>
            <th>Image</th>
        <th>Title</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sliders as $slider)
            <tr>
                <td>{{ $slider->image }}</td>
            <td>{{ $slider->title }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['sliders.destroy', $slider->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('sliders.show', [$slider->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('sliders.edit', [$slider->id]) }}"
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
