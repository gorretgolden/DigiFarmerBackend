{{-- <!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $vendorService->name }}</p>
</div>

<!-- Image Field -->
<div class="col-sm-12">
    {!! Form::label('image', 'Image:') !!}
    <p>{{ $vendorService->image }}</p>
</div>

<!-- Price Unit Field -->
<div class="col-sm-12">
    {!! Form::label('price_unit', 'Price Unit:') !!}
    <p>{{ $vendorService->price_unit }}</p>
</div>

<!-- Price Field -->
<div class="col-sm-12">
    {!! Form::label('price', 'Price:') !!}
    <p>{{ $vendorService->price }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $vendorService->description }}</p>
</div>

<!-- Weight Unit Field -->
<div class="col-sm-12">
    {!! Form::label('weight_unit', 'Weight Unit:') !!}
    <p>{{ $vendorService->weight_unit }}</p>
</div>

<!-- Stock Amount Field -->
<div class="col-sm-12">
    {!! Form::label('stock_amount', 'Stock Amount:') !!}
    <p>{{ $vendorService->stock_amount }}</p>
</div>

<!-- Is Verified Field -->
<div class="col-sm-12">
    {!! Form::label('is_verified', 'Is Verified:') !!}
    <p>{{ $vendorService->is_verified }}</p>
</div>

<!-- Expertise Field -->
<div class="col-sm-12">
    {!! Form::label('expertise', 'Expertise:') !!}
    <p>{{ $vendorService->expertise }}</p>
</div>

<!-- Charge Field -->
<div class="col-sm-12">
    {!! Form::label('charge', 'Charge:') !!}
    <p>{{ $vendorService->charge }}</p>
</div>

<!-- Charge Frequency Field -->
<div class="col-sm-12">
    {!! Form::label('charge_frequency', 'Charge Frequency:') !!}
    <p>{{ $vendorService->charge_frequency }}</p>
</div>

<!-- Zoom Details Field -->
<div class="col-sm-12">
    {!! Form::label('zoom_details', 'Zoom Details:') !!}
    <p>{{ $vendorService->zoom_details }}</p>
</div>

<!-- Location Field -->
<div class="col-sm-12">
    {!! Form::label('location', 'Location:') !!}
    <p>{{ $vendorService->location }}</p>
</div>

<!-- Starting Date Field -->
<div class="col-sm-12">
    {!! Form::label('starting_date', 'Starting Date:') !!}
    <p>{{ $vendorService->starting_date }}</p>
</div>

<!-- Ending Date Field -->
<div class="col-sm-12">
    {!! Form::label('ending_date', 'Ending Date:') !!}
    <p>{{ $vendorService->ending_date }}</p>
</div>

<!-- Starting Time Field -->
<div class="col-sm-12">
    {!! Form::label('starting_time', 'Starting Time:') !!}
    <p>{{ $vendorService->starting_time }}</p>
</div>

<!-- Ending Time Field -->
<div class="col-sm-12">
    {!! Form::label('ending_time', 'Ending Time:') !!}
    <p>{{ $vendorService->ending_time }}</p>
</div>

<!-- Principal Field -->
<div class="col-sm-12">
    {!! Form::label('principal', 'Principal:') !!}
    <p>{{ $vendorService->principal }}</p>
</div>

<!-- Interest Rate Field -->
<div class="col-sm-12">
    {!! Form::label('interest_rate', 'Interest Rate:') !!}
    <p>{{ $vendorService->interest_rate }}</p>
</div>

<!-- Interest Rate Unit Field -->
<div class="col-sm-12">
    {!! Form::label('interest_rate_unit', 'Interest Rate Unit:') !!}
    <p>{{ $vendorService->interest_rate_unit }}</p>
</div>

<!-- Payment Frequency Pay Field -->
<div class="col-sm-12">
    {!! Form::label('payment_frequency_pay', 'Payment Frequency Pay:') !!}
    <p>{{ $vendorService->payment_frequency_pay }}</p>
</div>

<!-- Simple Interest Field -->
<div class="col-sm-12">
    {!! Form::label('simple_interest', 'Simple Interest:') !!}
    <p>{{ $vendorService->simple_interest }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $vendorService->status }}</p>
</div>

<!-- Total Amount Paid Back Field -->
<div class="col-sm-12">
    {!! Form::label('total_amount_paid_back', 'Total Amount Paid Back:') !!}
    <p>{{ $vendorService->total_amount_paid_back }}</p>
</div>

<!-- Document Type Field -->
<div class="col-sm-12">
    {!! Form::label('document_type', 'Document Type:') !!}
    <p>{{ $vendorService->document_type }}</p>
</div>

<!-- Terms Field -->
<div class="col-sm-12">
    {!! Form::label('terms', 'Terms:') !!}
    <p>{{ $vendorService->terms }}</p>
</div>

<!-- Loan Pay Back Field -->
<div class="col-sm-12">
    {!! Form::label('loan_pay_back', 'Loan Pay Back:') !!}
    <p>{{ $vendorService->loan_pay_back }}</p>
</div>

<!-- Access Field -->
<div class="col-sm-12">
    {!! Form::label('access', 'Access:') !!}
    <p>{{ $vendorService->access }}</p>
</div>

<!-- Loan Plan Id Field -->
<div class="col-sm-12">
    {!! Form::label('loan_plan_id', 'Loan Plan Id:') !!}
    <p>{{ $vendorService->loan_plan_id }}</p>
</div>

<!-- Sub Category Id Field -->
<div class="col-sm-12">
    {!! Form::label('sub_category_id', 'Sub Category Id:') !!}
    <p>{{ $vendorService->sub_category_id }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $vendorService->user_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $vendorService->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $vendorService->updated_at }}</p>
</div> --}}



<div class="row">


    <div class="col-md-6">


        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md ">

                        <img src="{{ $vendorService->vendor->image ? $vendorService->vendor->image : asset('img/avatar-1.png') }}"
                        class="img-thumbnail rounded-circle shadow-4-strong w-25"/>
                    </div>


                    <div class="col-md-12 mt-2">
                        {!! Form::label('name', 'Vendor details:') !!}
                        <p>Name: {{ $vendorService->vendor->username }}</p>
                        <p>Contact: {{ $vendorService->vendor->phone }}</p>
                        <p>Email: {{ $vendorService->vendor->email }}</p>
                    </div>
                </div>




            </div>
        </div>
    </div>






    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">


                    <div>
                        <img class="img-thumbnail w-25 mb-3" src="{{ URL::asset("$vendorService->image") }}" />
                    </div>


                    <!-- Name Field -->
                    <div class="d-inline">
                        {!! Form::label('name', 'Name:') !!}
                        <p>{{ $vendorService->name }}</p>
                    </div>


                    <!-- Animal Feed Sub Category Id Field -->
                    <div>
                        {!! Form::label('sub_category_id', 'Sub  Category:') !!}
                        <p>{{ $vendorService->sub_category->name }}</p>
                    </div>




                    <!-- Price /charge Field -->
                    @if (empty($vendor_service->charge))
                    <div>
                        {!! Form::label('price', 'Price:') !!}
                        <p>{{ $vendorService->price_unit }} {{ $vendorService->price }}</p>
                    </div>
                    @else
                    <div>
                        {!! Form::label('charge', 'Charge:') !!}
                        <p>{{ $vendorService->price_unit }} {{ $vendorService->charge}}</p>
                    </div>
                    @endif


                    <!---weight-->
                    @if (empty($vendor_service->weight) && empty($vendor_service->weight_unit))
                    <div>

                    </div>
                    @else
                    <div>
                        {!! Form::label('weight', 'Weight:') !!}
                        <p>{{ $vendorService->weight }} {{ $vendorService->weight_unit }}</p>
                    </div>
                    @endif




                    <!-- status Field -->
                    <div>
                        {!! Form::label('status', 'Status:') !!}
                        <p class="badge rounded-pill bg-success">{{ $vendorService->status }}</p>
                        @if ($vendorService->is_verified == 1)
                            <p class="badge rounded-pill bg-success">Verified</p>
                        @else
                            <p class="badge rounded-pill bg-danger">Not verified</p>
                        @endif


                    </div>






                    <!-- Description Field -->
                    <div>
                        {!! Form::label('description', 'Description:') !!} <p>{{ $vendorService->description }}</p>


                    </div>

                    <div>
                        {!! Form::label('location', 'Location:') !!} <p>{{ $vendorService->location }}</p>


                    </div>



                    <!-- Created At Field -->
                    <div>
                        {!! Form::label('created_at', 'Created At:') !!}
                        <p>{{ $vendorService->created_at }}, {{ $vendorService->created_at->diffForHumans() }}</p>
                    </div>






                </div>
            </div>
        </div>


    </div>










</div>
