<div class="table-responsive">
    <table class="table" id="generalSettings-table">
        <thead>
            <tr>
                <th>Commission</th>
                <th>App Name</th>
                <th>Currency Unit</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>

                <tr>
                    <td>{{ $commission }} {{ $commission_unit }} </td>

                    <td>{{ $app_name }}</td>
                    <td>{{ $currency_unit }}</td>
                    <td width="120">

                        <div class='btn-group'>

                            <a href="{{ route('general-settings-edit') }}"
                                class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>

                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>

        </tbody>
    </table>
</div>
