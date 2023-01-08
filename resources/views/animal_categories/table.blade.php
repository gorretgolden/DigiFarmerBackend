<div class="table-responsive">
    <table class="table" id="animalCategories-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>


                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($animalCategories as $category)
                <tr>
                    <td>
                        <img
                            src="{{ $category->image ?  $category->image : asset('img/animal.png') }}"
                            width="50px" height="50px"/>
                    </td>
                    <td>{{ $category->name }}</td>



                    <td width="120">
                        {!! Form::open(['route' => ['animalCategories.destroy', $category->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('animalCategories.show', [$category->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('animalCategories.edit', [$category->id]) }}" class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-xs',
                                'onclick' => "return confirm('Are you sure you want to delete $category->name ?')",
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="float-right">
        {{ $animalCategories->links() }}
    </div>
</div>


