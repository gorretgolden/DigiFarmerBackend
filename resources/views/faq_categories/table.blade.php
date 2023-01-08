<div class="table-responsive">
    <table class="table" id="faqCategories-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Image</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($faqCategories as $faqCategory)
                <tr>
                    <td>{{ $faqCategory->name }}</td>
                    <td>

                        <img
                        src="{{$faqCategory->image}}"
                        width="50px" height="50px"/>
                    </td>
                    <td width="120">
                        {!! Form::open(['route' => ['faqCategories.destroy', $faqCategory->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('faqCategories.show', [$faqCategory->id]) }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('faqCategories.edit', [$faqCategory->id]) }}"
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
