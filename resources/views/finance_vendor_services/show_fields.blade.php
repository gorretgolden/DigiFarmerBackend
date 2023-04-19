<div class="row">


    <div class="col-md-6">


        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md ">

                        <img src="{{ $financeVendorService->user->image ? $financeVendorService->user->image : asset('img/avatar-1.png') }}"
                            class="img-thumbnail rounded-circle shadow-4-strong w-25" />
                    </div>


                    <div class="col-md-12 mt-2">
                        {!! Form::label('name', 'Vendor details:') !!}
                        <p>Name: {{ $financeVendorService->user->username }}</p>
                        <p>Contact: {{ $financeVendorService->user->phone }}</p>
                        <p>Email: {{ $financeVendorService->user->email }}</p>
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
                        <img class="img-thumbnail w-75" src="{{ URL::asset("$financeVendorService->image") }}" />
                    </div>


                    <!-- Name Field -->
                    <div class="d-inline">
                        {!! Form::label('name', 'Name:') !!}
                        <p>{{ $financeVendorService->name }}</p>
                    </div>

                    <!-- Terms Field -->
                    <div class="col-sm-12">
                        {!! Form::label('terms', 'Terms:') !!}
                        <p>{{ $financeVendorService->terms }}</p>
                    </div>




                    <!-- Vendor Category Id Field -->
                    <div class="col-sm-12">
                        {!! Form::label('vendor_category_id', 'Vendor Category:') !!}
                        <p>{{ $financeVendorService->vendor_category->name }}</p>
                    </div>


                    <!-- Principal Field -->
                    <div class="col-sm-12">
                        {!! Form::label('principal', 'Principal:') !!}
                        <p>{{ $financeVendorService->principal }}</p>
                    </div>

                    <!-- Interest Rate Field -->
                    <div class="col-sm-12">
                        {!! Form::label('interest_rate', 'Interest Rate:') !!}
                        <p>{{ $financeVendorService->interest_rate }}{{ $financeVendorService->interest_rate_unit }}
                        </p>
                    </div>


                    <!-- Payment Frequency Pay Field -->
                    <div class="col-sm-12">
                        {!! Form::label('payment_frequency_pay', 'Payment Frequency Pay:') !!}
                        <p>UGX {{ $financeVendorService->payment_frequency_pay }}
                            {{ $financeVendorService->loan_pay_back }}</p>
                    </div>


                    {{--
                    <!-- Loan Plan Id Field -->
                    <div class="col-sm-12">
                        {!! Form::label('loan_plan_id', 'Loan Plan Id:') !!}
                        <p>{{ $financeVendorService->loan_plan->name}}</p>
                    </div> --}}

                    <!-- Loan Pay Back Id Field -->
                    {{-- <div class="col-sm-12">
                        {!! Form::label('loan_pay_back_id', 'Loan Pay Back:') !!}
                        <p>{{ $financeVendorService->loan_pay_back }}</p>
                    </div> --}}

                    <!-- Finance Vendor Category Id Field -->
                    {{-- <div class="col-sm-12">
                        {!! Form::label('finance_vendor_category_id', 'Finance Vendor Category Id:') !!}
                        <p>{{ $financeVendorService->finance_vendor_category_id }}</p>
                    </div> --}}

                    <!-- Simple Interest Field -->
                    <div class="col-sm-12">
                        {!! Form::label('simple_interest', 'Simple Interest:') !!}
                        <p>UGX {{ $financeVendorService->simple_interest }}</p>
                    </div>

                    <!-- Total Amount Paid Back Field -->
                    <div class="col-sm-12">
                        {!! Form::label('total_amount_paid_back', 'Total Amount Paid Back:') !!}
                        <p>UGX {{ $financeVendorService->total_amount_paid_back }}</p>
                    </div>




                    <!-- status Field -->
                    <div>
                        {!! Form::label('status', 'Status:') !!}
                        <p class="badge rounded-pill bg-success">{{ $financeVendorService->status }}</p>
                        @if ($financeVendorService->is_verified == 1)
                            <p class="badge rounded-pill bg-success">Verified</p>
                        @else
                            <p class="badge rounded-pill bg-danger">Not verified</p>
                        @endif


                    </div>





                    <!-- Description Field -->
                    <div>
                        {!! Form::label('description', 'Description:') !!} <p>{{ $financeVendorService->description }}</p>


                    </div>

                    <div>
                        {!! Form::label('location', 'Location:') !!} <p>{{ $financeVendorService->location }}</p>


                    </div>



                    <!-- Created At Field -->
                    <div>
                        {!! Form::label('created_at', 'Created At:') !!}
                        <p>{{ $financeVendorService->created_at }},
                            {{ $financeVendorService->created_at->diffForHumans() }}
                        </p>
                    </div>






                </div>
            </div>
        </div>


    </div>


</div>
