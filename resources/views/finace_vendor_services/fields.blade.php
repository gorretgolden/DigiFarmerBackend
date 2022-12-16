
<?php
$vendor_categories = App\Models\VendorCategory::pluck('name','id');
$finance_vendor_categories = App\Models\FinanceVendorCategories::pluck('name','id');
$vendors = App\Models\User::where('user_type','farmer')->pluck('username','id');
$loan_plans = App\Models\LoanPlan::all();
$loan_pay_backs = App\Models\LoanPayBack::all()->pluck('name','id');

?>


<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Principal Field -->
<div class="form-group col-sm-6">
    {!! Form::label('principal', 'Principal:') !!}
    {!! Form::number('principal', null, ['class' => 'form-control','min'=>1000]) !!}
</div>

<!-- Interest Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('interest_rate', 'Interest Rate:') !!}
    {!! Form::number('interest_rate', null, ['class' => 'form-control','min'=>1,'max'=>20]) !!}
</div>

<!-- Interest Rate Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('interest_rate_unit', 'Interest Rate Unit:') !!}
    {!! Form::text('interest_rate_unit', null, ['class' => 'form-control','placeholder'=>'%','readonly']) !!}
</div>


<!--Status-->
<div class="form-group col-sm-6">
    {!! Form::label('Status') !!}
    {!! Form::select('status', ['Secured'=>'Secured','Unsecured'=>'Unsecured'],null, ['class' => 'form-control select select-access'] ) !!}
</div>


<!-- Payment Frequency Pay Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('payment_frequency_pay', 'Payment Frequency Pay:') !!}
    {!! Form::number('payment_frequency_pay', null, ['class' => 'form-control']) !!}
</div> --}}



<!-- Loan Plan Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_pan_id', 'Loan Plan:') !!}
    <select name="loan_plan_id" class="form-control custom-select ">
        <option value="">--Select a loan plan--</option>
        @foreach ($loan_plans as $plan)
            <option value="{{ $plan->id }}">
                {{ $plan->value}}  {{$plan->period_unit}}
            </option>
        @endforeach
    </select>
</div>


<!-- Loan Payback Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loan_pay_back_id', 'Loan Payback Period:') !!}
    {!! Form::select('loan_pay_back_id', $loan_pay_backs, null, ['class' => 'form-control custom-select']) !!}
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

<!-- Vendor Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('vendor_category_id', 'Vendor Category Id:') !!}
    {!! Form::select('vendor_category_id', $vendor_categories, null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Finance Vendor Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('finance_vendor_category_id', 'Finance Vendor Category:') !!}
    {!! Form::select('finance_vendor_category_id', $finance_vendor_categories, null, ['class' => 'form-control custom-select']) !!}
</div>



<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Vendors:') !!}
    {!! Form::select('user_id', $vendors, null, ['class' => 'form-control custom-select']) !!}
</div>
