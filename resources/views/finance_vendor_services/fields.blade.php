<?php

$vendor_categories = App\Models\VendorCategory::pluck('name', 'id');
$finance_vendor_categories = App\Models\FinanceVendorCategories::pluck('name', 'id');
$vendors = App\Models\User::where('user_type', 'farmer')->pluck('username', 'id');

$loan_plans = \DB::table("loan_plans")->select(\DB::raw("CONCAT(value, ' ', period_unit) AS duration"),"id")
->orderBy('value','ASC')
->pluck("duration","id");
?>



<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>




<!-- Principal Field -->
<div class="form-group col-sm-6">
    {!! Form::label('principal', 'Principal:') !!}
    {!! Form::number('principal', null, ['class' => 'form-control', 'min' => 1000]) !!}
</div>




<!-- Interest Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('interest_rate', 'Interest Rate:') !!}
    {!! Form::number('interest_rate', null, ['class' => 'form-control', 'min' => 1, 'max' => 20]) !!}
</div>




<!-- Interest Rate Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('interest_rate_unit', 'Interest Rate Unit:') !!}
    {!! Form::text('interest_rate_unit', null, ['class' => 'form-control', 'placeholder' => '%', 'readonly']) !!}
</div>




{{-- <!--Status-->
<div class="form-group col-sm-6">
    {!! Form::label('Status') !!}
    {!! Form::select('status', ['Secured'=>'Secured','Unsecured'=>'Unsecured'],null, ['class' => 'form-control select select-access'] ) !!}
</div> --}}


<!-- Payment Frequency Pay Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('payment_frequency_pay', 'Payment Frequency Pay:') !!}
    {!! Form::number('payment_frequency_pay', null, ['class' => 'form-control']) !!}
</div> --}}




<!-- Loan Plan Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_pan_id', 'Loan Plan:') !!}
    {!! Form::select('loan_plan_id', $loan_plans, null, [
        'class' => 'form-control custom-select',
    ]) !!}
    {{-- <select name="loan_plan_id" class="form-control custom-select ">
        <option value="">--Select a loan plan--</option>
        @foreach ($loan_plans as $plan)
            <option value="{{ $plan->id }}">
                {{ $plan->value }} {{ $plan->period_unit }}
            </option>
        @endforeach
    </select> --}}
</div>








<!-- Loan Payback Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_pay_back', 'Loan Payback Period:') !!}
    {!! Form::select('loan_pay_back', ['Daily' => 'Daily', 'Weekly' => 'Weekly', 'Monthly' => 'Monthly'], null, [
        'class' => 'form-control',
    ]) !!}
</div>



<!-- Document Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('document_type', 'Document Type :') !!}
    {!! Form::select('document_type', ['National Id' => 'National Id', 'Driving Permit' => 'Driving Permit', 'Land Title' => 'Land Title'], null, [
        'class' => 'form-control',
    ]) !!}
</div>






<!-- Simple Interest Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('simple_interest', 'Simple Interest:') !!}
    {!! Form::number('simple_interest', null, ['class' => 'form-control']) !!}
</div> --}}




<!-- Total Amount Paid Back Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('total_amount_paid_back', 'Total Amount Paid Back:') !!}
    {!! Form::number('total_amount_paid_back', null, ['class' => 'form-control']) !!}
</div> --}}




{{-- <!-- Vendor Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('vendor_category_id', 'Vendor Category:') !!}
    {!! Form::select('vendor_category_id', null, ['class' => 'form-control custom-select','placeholder'=>'Finance']) !!}
</div> --}}



{{--
<!-- Finance Vendor Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('finance_vendor_category_id', 'Finance Vendor Category:') !!}
    {!! Form::select('finance_vendor_category_id', $finance_vendor_categories, null, [
        'class' => 'form-control custom-select',
    ]) !!}
</div>
 --}}





<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Vendors:') !!}
    {!! Form::select('user_id', $vendors, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Address Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address_id', 'Address:') !!}
    <select id="farmer-address" name="address_id" class="form-control">



    </select>
</div>




<!-- Is verified Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_verified', 'Verify:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('is_verified', 0) !!}
        {!! Form::checkbox('is_verified', '1', null) !!}
    </label>
</div>






<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', 'Image:') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('image', ['class' => 'custom-file-input']) !!}
            {!! Form::label('image', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>
<div class="clearfix"></div>




<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('terms', 'Terms:') !!}
    {!! Form::textarea('terms', null, [
        'class' => 'form-control find',
        'placeholder' => 'Terms for the loan',
    ]) !!}
</div>











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
                            .district_name + '</option>');
















                        console.log('hello', value.district_name)
















                    });
















                }
            });
        });
    </script>
@endpush
