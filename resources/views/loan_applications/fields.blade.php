<?php
$finance_vendor_services = App\Models\FinanceVendorService::where('is_verified',1)->where('status','available')->pluck('name', 'id');
$finance_vendor_categories = App\Models\FinanceVendorCategories::orderBy('name','ASC')->pluck('name', 'id');
$farmers = App\Models\User::where('user_type', 'farmer')->pluck('username', 'id');

?>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Farmers:') !!}
    {!! Form::select('user_id', $farmers, null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Address Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address_id', 'Address:') !!}
    <select id="farmer-address" name="address_id" class="form-control">

    </select>
</div>



<!-- Finance Vendor Service Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('finance_vendor_service_id', 'Finance Vendor Services:') !!}
    {!! Form::select('finance_vendor_service_id', $finance_vendor_services, null, ['class' => 'form-control custom-select']) !!}
</div>


{{-- <!-- Location Field -->
<div class="form-group col-sm-6">
    {!! Form::label('location', 'Location:') !!}
    {!! Form::text('location', null, ['class' => 'form-control']) !!}
</div>

<!-- Location Details Field -->
<div class="form-group col-sm-6">
    {!! Form::label('location_details', 'Location Details:') !!}
    {!! Form::text('location_details', null, ['class' => 'form-control']) !!}
</div> --}}



{{-- <!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::text('status', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Loan Number Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('loan_number', 'Loan Number:') !!}
    {!! Form::text('loan_number', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Finance Vendor Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('finance_vendor_category_id', 'Finance Vendor Category:') !!}
    {!! Form::select('finance_vendor_category_id', $finance_vendor_categories, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Gender Field -->
<div class="form-group col-sm-6">
    {!! Form::label('gender', 'Gender:') !!}
    {!! Form::select('gender', ['Male' => 'Male', 'Female' => 'Female'], null, [
        'class' => 'form-control',
    ]) !!}
</div>

<!-- Dob Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dob', 'Date of birth:') !!}
    {!! Form::text('dob', null, [
        'class' => 'form-control',
        'id' => 'dob',
        'placeholder' => 'Select applicant date of birth',
    ]) !!}
</div>


@push('page_scripts')
    <script type="text/javascript">
        $('#dob').datetimepicker({
            format: 'DD-MM-YYYY',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush


<!-- Nok Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nok_name', 'Next of kin name:') !!}
    {!! Form::text('nok_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Nok Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nok_email', 'Next of kin email:') !!}
    {!! Form::text('nok_email', null, ['class' => 'form-control']) !!}
</div>

<!-- Nok Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nok_phone', 'Next of kin phone:') !!}
    {!! Form::text('nok_phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Nok Location Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nok_location', 'Next of kin location:') !!}
    {!! Form::text('nok_location', null, ['class' => 'form-control']) !!}
</div>

<!-- Nok Relationship Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nok_relationship', 'Next of kin relationship:') !!}
    {!! Form::select('nok_relationship', ['Father' => 'Father', 'Mother' => 'Mother', 'Brother' => 'Brother','Sister'=>'Sister'], null, [
        'class' => 'form-control',
    ]) !!}
</div>

<!-- Employment Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('employment_status', 'Employment Status:') !!}
    {!! Form::select('employment_status', ['Employed' => 'Employed', 'Self Employed' => 'Self Employed', 'Jobless' => 'Jobless'], null, [
        'class' => 'form-control',
    ]) !!}
</div>

{{-- <!-- Loan Start Date Field -->
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
@endpush --}}

<!-- Loan Due Date Field -->
{{-- <div class="form-group col-sm-6">
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
@endpush --}}

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


@push('scripts')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script>
        $('#user_id').on('change', function() {
            var idFarmer = this.value;
            console.log(idFarmer)

            $('#farmer-address').html('<option selected="selected" value="">Loading...</option>');
            $.ajax({
                url: "{{ route('sellers.fetch-address') }}",
                type: "get",
                data: {
                    user_id: idFarmer
                },
                dataType: 'json',
                success: function(result) {

                    $('#farmer-address').html(
                        '<option value="">-- Select farmer address --</option>');


                    $.each(result.addresses, function(key, value) {
                        console.log(result)



                        $("#farmer-address").append('<option value="' + value
                            .id + '">' + value
                            .district_name + '</option>')


                        console.log('hello', value.district_name)


                    });


                }
            });
        });
    </script>
@endpush
