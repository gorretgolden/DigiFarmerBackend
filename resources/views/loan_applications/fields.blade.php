<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::select('user_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Finance Vendor Service Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('finance_vendor_service_id', 'Finance Vendor Service Id:') !!}
    {!! Form::select('finance_vendor_service_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Location Field -->
<div class="form-group col-sm-6">
    {!! Form::label('location', 'Location:') !!}
    {!! Form::text('location', null, ['class' => 'form-control']) !!}
</div>

<!-- Location Details Field -->
<div class="form-group col-sm-6">
    {!! Form::label('location_details', 'Location Details:') !!}
    {!! Form::text('location_details', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::text('status', null, ['class' => 'form-control']) !!}
</div>

<!-- Loan Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_number', 'Loan Number:') !!}
    {!! Form::text('loan_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Finance Vendor Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('finance_vendor_category_id', 'Finance Vendor Category Id:') !!}
    {!! Form::select('finance_vendor_category_id', ], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Gender Field -->
<div class="form-group col-sm-6">
    {!! Form::label('gender', 'Gender:') !!}
    {!! Form::text('gender', null, ['class' => 'form-control']) !!}
</div>

<!-- Dob Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dob', 'Dob:') !!}
    {!! Form::text('dob', null, ['class' => 'form-control','id'=>'dob']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#dob').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Nok Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nok_name', 'Nok Name:') !!}
    {!! Form::text('nok_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Nok Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nok_email', 'Nok Email:') !!}
    {!! Form::text('nok_email', null, ['class' => 'form-control']) !!}
</div>

<!-- Nok Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nok_phone', 'Nok Phone:') !!}
    {!! Form::text('nok_phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Nok Location Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nok_location', 'Nok Location:') !!}
    {!! Form::text('nok_location', null, ['class' => 'form-control']) !!}
</div>

<!-- Nok Relationship Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nok_relationship', 'Nok Relationship:') !!}
    {!! Form::text('nok_relationship', null, ['class' => 'form-control']) !!}
</div>

<!-- Employment Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('employment_status', 'Employment Status:') !!}
    {!! Form::text('employment_status', null, ['class' => 'form-control']) !!}
</div>

<!-- Loan Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_start_date', 'Loan Start Date:') !!}
    {!! Form::text('loan_start_date', null, ['class' => 'form-control','id'=>'loan_start_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#loan_start_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Loan Due Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_due_date', 'Loan Due Date:') !!}
    {!! Form::text('loan_due_date', null, ['class' => 'form-control','id'=>'loan_due_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#loan_due_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Document Field -->
<div class="form-group col-sm-6">
    {!! Form::label('document', 'Document:') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('document', ['class' => 'custom-file-input']) !!}
            {!! Form::label('document', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>
<div class="clearfix"></div>
