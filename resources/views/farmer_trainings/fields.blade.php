<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::select('user_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Training Vendor Service Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('training_vendor_service_id', 'Training Vendor Service Id:') !!}
    {!! Form::select('training_vendor_service_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Starting Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('starting_date', 'Starting Date:') !!}
    {!! Form::text('starting_date', null, ['class' => 'form-control','id'=>'starting_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#starting_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Ending Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ending_date', 'Ending Date:') !!}
    {!! Form::text('ending_date', null, ['class' => 'form-control','id'=>'ending_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#ending_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Period Field -->
<div class="form-group col-sm-6">
    {!! Form::label('period', 'Period:') !!}
    {!! Form::number('period', null, ['class' => 'form-control']) !!}
</div>