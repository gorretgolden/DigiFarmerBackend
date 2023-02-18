<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLoanApplicationAPIRequest;
use App\Http\Requests\API\UpdateLoanApplicationAPIRequest;
use App\Models\LoanApplication;
use App\Repositories\LoanApplicationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Support\Str;
use App\Models\Address;
use Carbon;
use App\Models\FinanceVendorService;
use DB;


/**
 * Class LoanApplicationController
 * @package App\Http\Controllers\API
 */

class LoanApplicationAPIController extends AppBaseController
{
    /** @var  LoanApplicationRepository */
    private $loanApplicationRepository;

    public function __construct(LoanApplicationRepository $loanApplicationRepo)
    {
        $this->loanApplicationRepository = $loanApplicationRepo;
    }

    /**
     * Display a listing of the LoanApplication.
     * GET|HEAD /loanApplications
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $loanApplications = $this->loanApplicationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($loanApplications->toArray(), 'Loan Applications retrieved successfully');
    }


    public function random_strings($length_of_string)
     {

         // String of all alphanumeric character
         $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

         return substr(str_shuffle($str_result),0, $length_of_string);
     }
    /**
     * Store a newly created LoanApplication in storage.
     * POST /loanApplications
     *
     * @param CreateLoanApplicationAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request,$id)
    {

        $rules = [
            'location' => 'nullable',
            'location_details' => 'nullable',
            'status' => 'nullable|string',
            'loan_number' => 'nullable',
            'finance_vendor_category_id' => 'required|integer',
            'gender' => 'required|string',
            'dob' => 'required|date|before:8 years',
            'age' => 'nullable',
            'nok_name' => 'required|string',
            'nok_email' => 'required|string',
            'nok_phone' => 'required|string',
            'nok_location' => 'required|string',
            'nok_relationship' => 'required|string',
            'employment_status' => 'required|string',
            'loan_start_date' => 'nullable',
            'loan_due_date' => 'nullable',
            'document' => 'required|image',
            'address_id'=>'required|integer'
        ];

        $request->validate($rules);

        $financeVendorService = FinanceVendorService::find($id);


        if (empty($financeVendorService)) {

            $response = [
                'success'=>false,
                'message'=> 'Finance Vendor service not found'
              ];
              return response()->json($response,404);

        }

        $location = Address::find($request->address_id);
        $loan_number = $this->random_strings(10);
        $applicant_age = Carbon::parse($request->dob)->age;

        //existing loan application
        $existing_loan_application = LoanApplication::where('user_id',auth()->user()->id)->where('finance_vendor_service_id',$id)->first();


        if($existing_loan_application){

           $response = [
            'success'=>false,
            'message'=> 'You already applied for this loan'
          ];
          return response()->json($response,409);

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
        $loanApplication->user_id =  auth()->user()->id;
        $loanApplication->document =  $request->document;
        $loanApplication->finance_vendor_service_id = $id;
        $loanApplication->finance_vendor_category_id =  $request->finance_vendor_category_id;
        $loanApplication->save();


        $loanApplication = LoanApplication::find($loanApplication->id);
        $loanApplication->document = \App\Models\ImageUploader::upload($request->file('document'),'loan_applications');
        $loanApplication->save();


        $response = [
            'success'=>true,
            'message'=> 'Loan Application request sent'
          ];
          return response()->json($response,200);
       ;
    }


    public function approve_loan($id)
    {
        $loanApplication = LoanApplication::find($id);

        if (empty($loanApplication)) {

            $response = [
                'success'=>false,
                'message'=> 'Loan application not found'
              ];

              return response()->json($response,404);

       }elseif($loanApplication->status == 'approved'){

             $response = [
              'success'=>false,
              'message'=> 'Loan application already approved'
             ];

             return response()->json($response,409);

       }else{


              $loanApplication->status = 'approved';
              $loanApplication->save();

              $response = [
              'success'=>true,
              'message'=> 'Loan application has been approved successfully'
          ];

          return response()->json($response,200);





       }



    }

    //reject a loan application
    public function reject_loan($id)
    {
        $loanApplication = LoanApplication::find($id);

        if (empty($loanApplication)) {

            $response = [
                'success'=>false,
                'message'=> 'Loan application not found'
              ];

              return response()->json($response,404);

       }elseif($loanApplication->status == 'rejected'){

             $response = [
              'success'=>false,
              'message'=> 'Loan application already rejected'
             ];

             return response()->json($response,409);

       }else{


              $loanApplication->status = 'rejected';
              $loanApplication->save();

              $response = [
              'success'=>true,
              'message'=> 'Loan application has been rejected successfully'
          ];

          return response()->json($response,200);





       }



    }


    //farmer application loans
    public function farmer_loan_applications(Request $request)
    {

       $farmer_loan_applications = LoanApplication::where('user_id',auth()->user()->id)->latest()->get();


        if ($farmer_loan_applications->count() == 0) {
            return $this->sendError("You haven't applied for any loan");
        }
        else{



            $response = [
                'success'=>true,
                'data'=> [
                    'total-loan-applications' =>$farmer_loan_applications->count(),
                    'loan-applications'=>$farmer_loan_applications
                ],
                'message'=> 'Vendor finance services  retrieved'
             ];

             return response()->json($response,200);
        }




    }


    //vendor search for loan applications
    public function loan_application_search(Request $request){
        $search = $request->loan_number;

        if(empty($request->loan_number)){

            $response = [
                'success'=>false,
                'message'=> 'Enter loan application number'
              ];
             return response()->json($response,400);

        }
        $all_services = FinanceVendorService::where('is_verified',1)->get();
        $finance = FinanceVendorService::where('is_verified',1)->where('name', 'like', '%' . $search. '%')->orWhere('terms','like', '%' . $search.'%')->get();


        if(count($finance) == 0){
            $response = [
                'success'=>false,
                'message'=> 'No results found'
              ];
             return response()->json($response,404);

        }else{
            $response = [
                'success'=>true,
                'data'=> [
                    'total-results'=>count($finance)." "."results found out of"." ".count($all_services),
                    'search-results'=>$finance,

                ],

                'message'=> 'search results'
              ];
             return response()->json($response,200);

        }



}


   //vendor view loan applications
   public function vendor_loan_applications(){



      $loan_applications = DB::table('finance_vendor_services')
                         ->join('loan_applications','loan_applications.finance_vendor_service_id','=','finance_vendor_services.id')
                         ->where('finance_vendor_services.user_id',auth()->user()->id)
                         ->select('finance_vendor_services.name')
                         ->get();

       dd($loan_applications);

   }


    /**
     * Display the specified LoanApplication.
     * GET|HEAD /loanApplications/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var LoanApplication $loanApplication */
        $loanApplication = $this->loanApplicationRepository->find($id);

        if (empty($loanApplication)) {
            return $this->sendError('Loan Application not found');
        }

        return $this->sendResponse($loanApplication->toArray(), 'Loan Application retrieved successfully');
    }

    /**
     * Update the specified LoanApplication in storage.
     * PUT/PATCH /loanApplications/{id}
     *
     * @param int $id
     * @param UpdateLoanApplicationAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLoanApplicationAPIRequest $request)
    {
        $input = $request->all();

        /** @var LoanApplication $loanApplication */
        $loanApplication = $this->loanApplicationRepository->find($id);

        if (empty($loanApplication)) {
            return $this->sendError('Loan Application not found');
        }

        $loanApplication = $this->loanApplicationRepository->update($input, $id);

        return $this->sendResponse($loanApplication->toArray(), 'LoanApplication updated successfully');
    }

    /**
     * Remove the specified LoanApplication from storage.
     * DELETE /loanApplications/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var LoanApplication $loanApplication */
        $loanApplication = $this->loanApplicationRepository->find($id);

        if (empty($loanApplication)) {
            return $this->sendError('Loan Application not found');
        }

        $loanApplication->delete();

        return $this->sendSuccess('Loan Application deleted successfully');
    }
}
