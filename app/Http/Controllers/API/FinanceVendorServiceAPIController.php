<?php


namespace App\Http\Controllers\API;


use App\Http\Requests\API\CreateFinanceVendorServiceAPIRequest;
use App\Http\Requests\API\UpdateFinanceVendorServiceAPIRequest;
use App\Models\FinanceVendorService;
use App\Repositories\FinanceVendorServiceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\LoanPlan;
use App\Models\LoanPayBack;
use App\Models\Address;
use App\Models\VendorCategory;
use App\Models\User;
use Illuminate\Support\Str;

require_once('vendor/autoload.php');
/**
 * Class FinanceVendorServiceController
 * @package App\Http\Controllers\API
 */


class FinanceVendorServiceAPIController extends AppBaseController
{
    /** @var  FinanceVendorServiceRepository */
    private $financeVendorServiceRepository;


    public function __construct(FinanceVendorServiceRepository $financeVendorServiceRepo)
    {
        $this->financeVendorServiceRepository = $financeVendorServiceRepo;
    }


    /**
     * Display a listing of the FinanceVendorService.
     * GET|HEAD /financeVendorServices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $financeVendorService = FinanceVendorService::where('is_verified',1)->latest()->with('user')->get();
        $response = [
            'success'=>true,
            'data'=> $financeVendorService,
            'message'=> 'Finance VendorService retrieved successfully'
         ];
         return response()->json($response,200);
    }


    /**
     * Store a newly created FinanceVendorService in storage.
     * POST /financeVendorServices
     *
     * @param CreateFinanceVendorServiceAPIRequest $request
     *
     * @return Response
     */


     public function random_strings($length_of_string)
     {


         // String of all alphanumeric character
         $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';




         return substr(str_shuffle($str_result),0, $length_of_string);
     }


    public function store(Request $request)
    {


         //existing finance


        $rules = [
            'name' => 'required|string',
            'principal' => 'required|numeric|min:10000',
            'interest_rate' => 'required|integer|numeric|min:1|max:20',
            'loan_plan_id' => 'integer|required',
            'loan_pay_back' => 'string|required',
            'document_type' => 'required|string',
            'image' => 'required',
            'terms'=>'required|string|min:10',
            'address_id'=>'required|integer',
        ];


        $request->validate($rules);
        $existing_finance = FinanceVendorService::where('name',$request->name)->first();
        $vendor_category = VendorCategory::where('name','Finance')->first();
        $location = Address::find($request->address_id);
        if(!$existing_finance){


            $new_finance_service = new FinanceVendorService();
            $new_finance_service->name = $request->name;
            $new_finance_service->principal = $request->principal;
            $new_finance_service->interest_rate = $request->interest_rate;
            $new_finance_service->interest_rate_unit = "%";
            $new_finance_service->loan_plan_id = $request->loan_plan_id;
            $new_finance_service->loan_pay_back = $request->loan_pay_back;
            $new_finance_service->is_verified = $request->is_verified;
            $new_finance_service->terms = $request->terms;
            $new_finance_service->vendor_category_id = $vendor_category->id;
            $new_finance_service->document_type = $request->document_type;
            $new_finance_service->user_id = auth()->user()->id;
            $new_finance_service->location = $location->district_name;
            $new_finance_service->is_verified = 0;




            //simple interest
            $percentage_interest_rate = ($request->interest_rate / 100);


            //calculate duration
            $loan_plan = LoanPlan::find($request->loan_plan_id);
            $loan_plan_duration =$loan_plan->value;
            $time = ($loan_plan_duration/12);


            $calculated_year_simple_interest = (int)($request->principal * $percentage_interest_rate * $time);
            $total_pay_amount = $calculated_year_simple_interest + $request->principal;




            $new_finance_service->simple_interest = $calculated_year_simple_interest;
            $new_finance_service->total_amount_paid_back = $total_pay_amount;
            $new_finance_service->save();




                  //set user as a vendor
            $user = User::find(auth()->user()->id);
             if(!$user->is_vendor ==1){
                $user->is_vendor =1;
                 $user->save();
             }




            $new_finance_service = FinanceVendorService::find($new_finance_service->id);
            $new_finance_service->image = \App\Models\ImageUploader::upload($request->file('image'),'finance');
            $new_finance_service->save();








            if($request->loan_pay_back == "Daily"){


                $payment_frequency_pay =  $percentage_interest_rate * $request->principal;
                #a month has 30.417 days
                $total_days = $loan_plan_duration * 30.417 ;
                $daily_pay = ($total_pay_amount / $total_days);
                $new_finance_service->payment_frequency_pay = $daily_pay;
                $new_finance_service->save();




            }elseif($request->loan_pay_back == "Weekly"){
                #a month has 4 weeks
                $total_weeks = $loan_plan_duration * 4;
                $weekly_pay = ($total_pay_amount / $total_weeks);
                $new_finance_service->payment_frequency_pay = $weekly_pay;
                $new_finance_service->save();


            }elseif($request->loan_pay_back == "Monthly"){


                $monthly_payment =  ($total_pay_amount / $loan_plan_duration);
                $new_finance_service->payment_frequency_pay = $monthly_payment;
                $new_finance_service->save();




            }
            $success['name'] = $new_finance_service->name;
            $success['principal'] = $new_finance_service->principal;
            $success['interest_rate'] = $new_finance_service->interest_rate.$new_finance_service->interest_rate_unit;
            $success['simple_interest'] = $new_finance_service->simple_interest;
            $success['duration'] = $new_finance_service->loan_plan->value." ".$new_finance_service->loan_plan->period_unit;
            $success['total_amount_paid_back'] = $new_finance_service->total_amount_paid_back;
            $success['status'] = $new_finance_service->status;
            $success['payment_frequency'] = $new_finance_service->loan_pay_back;
            $success['vendor_category'] = $new_finance_service->vendor_category;
            $success['document_type'] = $new_finance_service->document_type;
            $success['vendor'] = $new_finance_service->username;


            $response = [
               'success'=>true,
               'data'=> $success,
               'message'=> 'Finance Vendor service created successfully'
            ];


       return response()->json($response,200);


       }
       else{
           $response = [
               'success'=>false,
               'message'=> 'Finance Vendor service name exists'
            ];
            return response()->json($response,409);
       }
    }


    /**
     * Display the specified FinanceVendorService.
     * GET|HEAD /financeVendorServices/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FinanceVendorService $financeVendorService */
        $financeVendorService = $this->financeVendorServiceRepository->find($id);


        if (empty($financeVendorService)) {
            return $this->sendError('Finance Vendor Service not found');
        }
        else{
            $success['id'] = $crop->id;
            $success['name'] = $crop->name;
            $success['principal'] = $crop->principal;
            $success['interest_rate'] = $crop->interest_rate;
            $success['interest_rate_unit'] = $crop->interest_rate_unit;
            $success['duration'] = $crop->duration;
            $success['duration_unit'] = $crop->duration_unit;
            $success['payment_frequency'] = $crop->payment_frequency;
            $success['status'] = $crop->status;
            $success['simple_interest'] = $crop->simple_interest;
            $success['total_amount_paid_back'] = $crop->total_amount_paid_back;
            $success['vendor_category'] = $crop->vendor_category;
            $success['user'] = $crop->user;


            $response = [
                'success'=>true,
                'data'=> $success,
                'message'=> 'Crop details retrieved successfully'
             ];


             return response()->json($response,200);
        }
    }


    /**
     * Update the specified FinanceVendorService in storage.
     * PUT/PATCH /financeVendorServices/{id}
     *
     * @param int $id
     * @param UpdateFinanceVendorServiceAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFinanceVendorServiceAPIRequest $request)
    {
        $input = $request->all();


        /** @var FinanceVendorService $financeVendorService */
        $financeVendorService = $this->financeVendorServiceRepository->find($id);


        if (empty($financeVendorService)) {
            return $this->sendError('Finance Vendor Service not found');
        }


        $financeVendorService = $this->financeVendorServiceRepository->update($input, $id);


        return $this->sendResponse($financeVendorService->toArray(), 'FinanceVendorService updated successfully');
    }


    /**
     * Remove the specified FinanceVendorService from storage.
     * DELETE /financeVendorServices/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FinanceVendorService $financeVendorService */
        $financeVendorService = $this->financeVendorServiceRepository->find($id);


        if (empty($financeVendorService)) {
            return $this->sendError('Finance Vendor Service not found');
        }


        $financeVendorService->delete();


        return $this->sendSuccess('Finance Vendor Service deleted successfully');
    }
}
