<?php

namespace App\Http\Controllers;

use App\DataTables\LoanApplicationDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateLoanApplicationRequest;
use App\Http\Requests\UpdateLoanApplicationRequest;
use App\Repositories\LoanApplicationRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Str;
use App\Models\Address;
use Carbon;
use App\Models\LoanApplication;

class LoanApplicationController extends AppBaseController
{
    /** @var LoanApplicationRepository $loanApplicationRepository*/
    private $loanApplicationRepository;

    public function __construct(LoanApplicationRepository $loanApplicationRepo)
    {
        $this->loanApplicationRepository = $loanApplicationRepo;
    }

    /**
     * Display a listing of the LoanApplication.
     *
     * @param LoanApplicationDataTable $loanApplicationDataTable
     *
     * @return Response
     */
    public function index(LoanApplicationDataTable $loanApplicationDataTable)
    {
        return $loanApplicationDataTable->render('loan_applications.index');
    }

    /**
     * Show the form for creating a new LoanApplication.
     *
     * @return Response
     */
    public function create()
    {
        return view('loan_applications.create');
    }



    public function random_strings($length_of_string)
     {

         // String of all alphanumeric character
         $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

         return substr(str_shuffle($str_result),0, $length_of_string);
     }

    /**
     * Store a newly created LoanApplication in storage.
     *
     * @param CreateLoanApplicationRequest $request
     *
     * @return Response
     */
    public function store(CreateLoanApplicationRequest $request)
    {


        $location = Address::find($request->address_id);
        $loan_number = $this->random_strings(10);
        $applicant_age = Carbon::parse($request->dob)->age;

        //existing loan application
        $existing_loan_application = LoanApplication::where('user_id',$request->user_id)->where('finance_vendor_service_id',$request->finance_vendor_service_id)->first();


        if($existing_loan_application){

           Flash::error('Farmer already applied for this loan');
           return redirect(route('loanApplications.index'));

        }

        $loanApplication = new LoanApplication();
        $loanApplication->loan_number = $loan_number;
        $loanApplication->location =    $location->district_name;
        $loanApplication->location_details = $location->address_name;
        $loanApplication->age =  $applicant_age ;
        $loanApplication->gender =  $request->gender;
        $loanApplication->dob =  $request->dob;
        $loanApplication->nok_name =  $request->nok_name;
        $loanApplication->nok_email =  $request->nok_email;
        $loanApplication->nok_phone =  $request->nok_phone;
        $loanApplication->nok_location =  $request->nok_location;
        $loanApplication->nok_relationship =  $request->nok_relationship;
        $loanApplication->employment_status =  $request->employment_status;
        $loanApplication->user_id =  $request->user_id;
        $loanApplication->document =  $request->document;
        $loanApplication->finance_vendor_service_id =  $request->finance_vendor_service_id;
        $loanApplication->finance_vendor_category_id =  $request->finance_vendor_category_id;
        $loanApplication->save();


        $loanApplication = LoanApplication::find($loanApplication->id);
        $loanApplication->document = \App\Models\ImageUploader::upload($request->file('document'),'loan_applications');
        $loanApplication->save();



        Flash::success('Loan Application saved successfully.');
        return redirect(route('loanApplications.index'));
    }

    /**
     * Display the specified LoanApplication.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $loanApplication = $this->loanApplicationRepository->find($id);

        if (empty($loanApplication)) {
            Flash::error('Loan Application not found');

            return redirect(route('loanApplications.index'));
        }

        return view('loan_applications.show')->with('loanApplication', $loanApplication);
    }


     //approve loan

     public function approve_loan($id)
     {
         $loanApplication = $this->loanApplicationRepository->find($id);

         if (empty($loanApplication)) {
            Flash::error('Loan Application not found');

            return redirect(route('loanApplications.index'));
        }
         $loanPlan->status = 'approved';
         $loanPlan->save();
         return view('loan_applications.show')->with('loanApplication', $loanApplication);


     }


    public function edit($id)
    {
        $loanApplication = $this->loanApplicationRepository->find($id);

        if (empty($loanApplication)) {
            Flash::error('Loan Application not found');

            return redirect(route('loanApplications.index'));
        }

        return view('loan_applications.edit')->with('loanApplication', $loanApplication);
    }




}
