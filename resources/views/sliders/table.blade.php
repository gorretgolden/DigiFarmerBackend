<div class="table-responsive">
    <table class="table" id="sliders-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Image</th>
                <th>status</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sliders as $slider)
                <tr>
                    <td>{{ $slider->title }}</td>
                    <td>{{ $slider->type }}</td>
                    <td>

                        <img src="{{ $slider->image ? $slider->image : asset('img/crop.png') }}" width="50px"
                            height="50px" />
                    </td>
                    <td>
                        @if ($slider->is_active == 1)
                            <p class="badge rounded-pill bg-success">enabled</p>
                            @else
                            <p class="badge rounded-pill bg-danger">disabled</p>
                        @endif
                    </td>

                    <td width="120">
                        {!! Form::open(['route' => ['sliders.destroy', $slider->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('sliders.show', [$slider->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('sliders.edit', [$slider->id]) }}" class='btn btn-default btn-xs'>
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
