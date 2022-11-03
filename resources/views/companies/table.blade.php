<div class="table-responsive">
    <table class="table" id="companies-table">
        <thead>
        <tr>
            <th>Name</th>
        <th>Logo</th>
        <th>Description</th>
        <th>Contact</th>
        <th>Email</th>
        <th>Crop Price</th>
        <th>Crop Id</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($companies as $company)
            <tr>
                <td>{{ $company->name }}</td>
            <td>{{ $company->logo }}</td>
            <td>{{ $company->description }}</td>
            <td>{{ $company->contact }}</td>
            <td>{{ $company->email }}</td>
            <td>{{ $company->crop_price }}</td>
            <td>{{ $company->crop_id }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['companies.destroy', $company->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('companies.show', [$company->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('companies.edit', [$company->id]) }}"
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
