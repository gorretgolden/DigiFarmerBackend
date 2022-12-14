<div class="table-responsive">
    <table class="table" id="onboardings-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>


                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($onBoardings as $onBoarding)
                <tr>
                    <td>
                        <img
                            src="{{ $onBoarding->image ? asset('/storage/onboardings/' . $onBoarding->image) : asset('img/farmer.png') }}"
                            width="100px" height="100px"/>
                    </td>
                    <td>{{ $onBoarding->title}}</td>
                    <td>{{ $onBoarding->description }} </td>




                    <td width="120">
                        {!! Form::open(['route' => ['onboardings.destroy', $onBoarding->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('onboardings.show', [$onBoarding->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('onboardings.edit', [$onBoarding->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'onclick' => "return confirm('Are you sure you want to delete $onBoarding->title ?')",
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="float-right">
        {{ $onBoardings->links() }}
    </div>
</div>
