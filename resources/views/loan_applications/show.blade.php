@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <div class="card gray-bg">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <h5>Loan Application Number: {{ $loanApplication->loan_number }} </h5>
                                </div>
                                <div class="col-md-2">

                                    <a class="btn btn-default bg-success " href="{{ route('loanApplications.index') }}">
                                       Approve
                                    </a>
                                    <a class="btn btn-default float-right" href="{{ route('loanApplications.index') }}">
                                        Back
                                    </a>
                                </div>
                            </div>


                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('loan_applications.show_fields')

    </div>
@endsection
