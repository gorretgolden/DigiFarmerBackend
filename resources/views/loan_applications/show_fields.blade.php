<div class="row">
    <!--finance service details-->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="font-weight-bold">LOAN DETAILS</h6>

            </div>
            <div class="card-body">
                <!-- Finance Vendor Service  -->
                <div class="col-sm-12">
                    <div class="img">
                        <img src="https://img.freepik.com/free-photo/piggy-money-box-with-laptop-wooden-table_93675-128547.jpg?size=626&ext=jpg&uid=R46484519&ga=GA1.2.1085104606.1668665649&semt=sph"
                        class="img-thumbnail" alt="..."/>
                    </div>
                    {!! Form::label('finance_vendor_service_id', 'Finance Vendor service:') !!}
                    <p>{{ $loanApplication->finance_vendor_service->name }}</p>
                    {!! Form::label('vendor', 'Vendor') !!}
                    <p>{{ $loanApplication->finance_vendor_service->user->username }}</p>
                    {!! Form::label('vendor', 'Contact') !!}
                    <p>{{ $loanApplication->finance_vendor_service->user->phone }}</p>

                    <hr/>
                    {!! Form::label('vendor', 'Loan Offer') !!}
                    <p>UGX {{ $loanApplication->finance_vendor_service->principal }}</p>

                    {!! Form::label('vendor', 'Interest Rate') !!}
                    <p>{{ $loanApplication->finance_vendor_service->interest_rate }} {{ $loanApplication->finance_vendor_service->interest_rate_unit }}</p>


                    {!! Form::label('vendor', 'Duration') !!}
                    <p>{{ $loanApplication->finance_vendor_service->loan_plan->value }} {{ $loanApplication->finance_vendor_service->loan_plan->period_unit}}</p>

                    {!! Form::label('vendor', 'Payback Amount') !!}
                    <p>UGX {{ $loanApplication->finance_vendor_service->total_amount_paid_back }}</p>

                </div>

            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h6 class="font-weight-bold">LOAN STATUS</h6>

            </div>
            <div class="card-body">


                <!-- Status Field -->
                <div class="col-sm-12">
                    {!! Form::label('status', 'Status:') !!}
                    @if ($loanApplication->status == 'pending')
                        <p class="badge rounded-pill bg-success">pending</p>
                    @else
                        <p class="badge rounded-pill bg-danger">rejected</p>
                    @endif
                    <p>{{ $loanApplication->status }}</p>
                </div>

                <!-- Loan Start Date Field -->
                <div class="col-sm-12">
                    {!! Form::label('loan_start_date', 'Loan Start Date:') !!}
                    <p>{{ $loanApplication->loan_start_date }}</p>
                </div>

                <!-- Loan Due Date Field -->
                <div class="col-sm-12">
                    {!! Form::label('loan_due_date', 'Loan Due Date:') !!}
                    <p>{{ $loanApplication->loan_due_date }}</p>
                </div>

                <!-- Document Field -->
                <div class="col-sm-12">
                    {!! Form::label('document', 'Document:') !!}
                    <p>{{ $loanApplication->document }}</p>
                </div>

                <!-- Created At Field -->
                <div class="col-sm-12">
                    {!! Form::label('created_at', 'Created At:') !!}
                    <p>{{ $loanApplication->created_at }}</p>
                </div>

                <!-- Updated At Field -->
                <div class="col-sm-12">
                    {!! Form::label('updated_at', 'Updated At:') !!}
                    <p>{{ $loanApplication->updated_at }}</p>
                </div>


            </div>
        </div>
    </div>



    <!--applicant details-->

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="font-weight-bold">APPLICANT DETAILS</h6>

            </div>
            <div class="card-body">

                <div class="img">
                    <img src="https://img.freepik.com/free-photo/countryside-woman-holding-plant-leaves_23-2148761766.jpg?size=626&ext=jpg&uid=R46484519&ga=GA1.1.1085104606.1668665649&semt=sph"
                        class="img-thumbnail" alt="...">
                </div>

                <!-- User Id Field -->
                <div class="col-sm-12">
                    {!! Form::label('user_id', 'Farmer:') !!}
                    <p>{{ $loanApplication->user->username }}</p>
                </div>

                <!-- Location Field -->
                <div class="col-sm-12">
                    {!! Form::label('location', 'Location:') !!}
                    <p>{{ $loanApplication->location }} {{ $loanApplication->location_details }}</p>
                </div>

                <!-- Finance Vendor Category  Field -->
                <div class="col-sm-12">
                    {!! Form::label('finance_vendor_category_id', 'Loan Type:') !!}
                    <p>{{ $loanApplication->finance_vendor_category->name }}</p>
                </div>

                <!-- Gender Field -->
                <div class="col-sm-12">
                    {!! Form::label('gender', 'Gender:') !!}
                    <p>{{ $loanApplication->gender }}</p>
                </div>

                <!-- Dob Field -->
                <div class="col-sm-12">
                    {!! Form::label('dob', 'Dob:') !!}
                    <p>{{ $loanApplication->dob }}</p>
                </div>

                <!-- Age Field -->
                <div class="col-sm-12">
                    {!! Form::label('age', 'Age:') !!}
                    <p>{{ $loanApplication->age }}</p>
                </div>

                <!-- Employment Status Field -->
                <div class="col-sm-12">
                    {!! Form::label('employment_status', 'Employment Status:') !!}
                    <p>{{ $loanApplication->employment_status }}</p>
                </div>


            </div>
        </div>
    </div>

    <!---next of kin details-->

    <div class="col-md-4">

        <div class="card">
            <div class="card-header">
                <h6 class="font-weight-bold">NEXT OF KIN DETAILS</h6>

            </div>
            <div class="card-body">

                <!-- Nok Name Field -->
                <div class="col-sm-12">
                    {!! Form::label('nok_name', 'Name:') !!}
                    <p>{{ $loanApplication->nok_name }}</p>
                </div>

                <!-- Nok Email Field -->
                <div class="col-sm-12">
                    {!! Form::label('nok_email', 'Email:') !!}
                    <p>{{ $loanApplication->nok_email }}</p>
                </div>

                <!-- Phone Field -->
                <div class="col-sm-12">
                    {!! Form::label('nok_phone', 'Phone:') !!}
                    <p>{{ $loanApplication->nok_phone }}</p>
                </div>

                <!-- Location Field -->
                <div class="col-sm-12">
                    {!! Form::label('nok_location', 'Location:') !!}
                    <p>{{ $loanApplication->nok_location }}</p>
                </div>

                <!-- Relationship Field -->
                <div class="col-sm-12">
                    {!! Form::label('nok_relationship', 'Relationship:') !!}
                    <p>{{ $loanApplication->nok_relationship }}</p>
                </div>

            </div>
        </div>
    </div>

</div>

</div>



</div>
</div>
