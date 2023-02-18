<?php


namespace App\Http\Controllers;


use App\DataTables\FinanceVendorServiceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateFinanceVendorServiceRequest;
use App\Http\Requests\UpdateFinanceVendorServiceRequest;
use App\Repositories\FinanceVendorServiceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\FinanceVendorService;
use App\Models\LoanPlan;
use App\Models\LoanPayBack;
use App\Models\Address;
use App\Models\VendorCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class FinanceVendorServiceController extends AppBaseController
{
    /** @var FinanceVendorServiceRepository $financeVendorServiceRepository*/
    private $financeVendorServiceRepository;


    public function __construct(FinanceVendorServiceRepository $financeVendorServiceRepo)
    {
        $this->financeVendorServiceRepository = $financeVendorServiceRepo;
    }


    /**
     * Display a listing of the FinanceVendorService.
     *
     * @param FinanceVendorServiceDataTable $financeVendorServiceDataTable
     *
     * @return Response
     */
    public function index(FinanceVendorServiceDataTable $financeVendorServiceDataTable)
    {
        return $financeVendorServiceDataTable->render('finance_vendor_services.index');
    }


    /**
     * Show the form for creating a new FinanceVendorService.
     *
     * @return Response
     */
    public function create()
    {
        return view('finance_vendor_services.create');
    }





    /**
     * Store a newly created FinanceVendorService in storage.
     *
     * @param CreateFinanceVendorServiceRequest $request
     *
     * @return Response
     */
    public function store(CreateFinanceVendorServiceRequest $request)
    {


         //dd($request->all());
        $existing_finance = FinanceVendorService::where('name',$request->name)->first();
        $location = Address::find($request->address_id);
        $vendor_category = VendorCategory::where('name','Finance')->first();


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
            $new_finance_service->vendor_category_id =  $vendor_category->id;
            $new_finance_service->document_type = $request->document_type;
            $new_finance_service->user_id = $request->user_id;
            $new_finance_service->location = $location->district_name;
            $new_finance_service->save();


              //set user as a vendor
            $user = User::find($request->user_id);
            if(!$user->is_vendor ==1){
               $user->is_vendor =1;
               $user->save();
             }



             $new_finance_service = FinanceVendorService::find($new_finance_service->id);
             $new_finance_service->image = \App\Models\ImageUploader::upload($request->file('image'),'finance');
             $new_finance_service->save();


            //percentage simple interest
            $percentage_interest_rate = ($request->interest_rate / 100);


            //loan  duration period in months
            $loan_plan = LoanPlan::find($request->loan_plan_id);
            $loan_plan_duration =$loan_plan->value;
            $time = ($loan_plan_duration/12);
            // dd($request->principal,$percentage_interest_rate,$time);


            $calculated_year_simple_interest = (int)($request->principal * $percentage_interest_rate * $time);
            $total_pay_amount = $calculated_year_simple_interest + $request->principal;


            $new_finance_service->simple_interest = $calculated_year_simple_interest;
            $new_finance_service->total_amount_paid_back = $total_pay_amount;
            $new_finance_service->save();


          //  $loan_number = $this->random_strings(10);
            // $new_finance_service->loan_number = $loan_number;





            if($request->loan_pay_back == "Daily"){

                #a month has 30.417 days
                $total_days = $loan_plan_duration * 30.417 ;
                $daily_pay = ($total_pay_amount / $total_days);
                $new_finance_service->payment_frequency_pay = $daily_pay;
                $new_finance_service->save();


            }elseif($request->loan_pay_back  == "Weekly"){
                #a month has 4 weeks
                $total_weeks = $loan_plan_duration * 4;
                $weekly_pay = ($total_pay_amount / $total_weeks);
                $new_finance_service->payment_frequency_pay = $weekly_pay;
                $new_finance_service->save();


            }elseif($request->loan_pay_back  == "Monthly"){


                $monthly_payment = ($total_pay_amount / $loan_plan_duration) ;
                $new_finance_service->payment_frequency_pay = $monthly_payment;
                $new_finance_service->save();


            }


             Flash::success('Finance Vendor Service saved successfully.');


             return redirect(route('financeVendorServices.index'));


        }
        else{


            Flash::error('Finance Vendor name already exists.');


             return redirect(route('financeVendorServices.index'));




        }




    }




    /**
     * Display the specified FinanceVendorService.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $financeVendorService = $this->financeVendorServiceRepository->find($id);


        if (empty($financeVendorService)) {
            Flash::error('Finance Vendor Service not found');


            return redirect(route('financeVendorServices.index'));
        }


        return view('finance_vendor_services.show')->with('financeVendorService', $financeVendorService);
    }


    /**
     * Show the form for editing the specified FinanceVendorService.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $financeVendorService = $this->financeVendorServiceRepository->find($id);


        if (empty($financeVendorService)) {
            Flash::error('Finance Vendor Service not found');


            return redirect(route('financeVendorServices.index'));
        }


        return view('finance_vendor_services.edit')->with('financeVendorService', $financeVendorService);
    }


    /**
     * Update the specified FinanceVendorService in storage.
     *
     * @param int $id
     * @param UpdateFinanceVendorServiceRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $financeVendorService = $this->financeVendorServiceRepository->find($id);


        if (empty($financeVendorService)) {
            Flash::error('Finance Vendor Service not found');
            return redirect(route('financeVendorServices.index'));
        }

        $rules = [
            'name' => 'required|string',
            'principal' => 'required|integer',
            'interest_rate' => 'required|integer',
            'interest_rate_unit' => 'nullable',
            'payment_frequency_pay' => 'nullable',
            'is_verified' => 'nullable',
            'simple_interest' => 'nullable',
            'total_amount_paid_back' => 'nullable',
            'vendor_category_id' => 'nullable',
            'user_id' => 'required|integer',
            'loan_plan_id' => 'required|integer',
            'loan_pay_back' => 'required|string',
            'document_type' => 'required|string',
            'location' => 'nullable',
            'terms' => 'required|string|min:10',
            'payment_frequency_pay' => 'nullable',
            'image' => 'nullable',
            'address_id'=>'nullable|integer',
        ];
        $request->validate($rules);

        $financeVendorService->name = $request->name;
        $financeVendorService->principal = $request->principal;
        $financeVendorService->interest_rate = $request->interest_rate;
        $financeVendorService->interest_rate_unit = "%";
        $financeVendorService->loan_plan_id = $request->loan_plan_id;
        $financeVendorService->loan_pay_back = $request->loan_pay_back;
        $financeVendorService->is_verified = $request->is_verified;
        $financeVendorService->terms = $request->terms;
        $financeVendorService->user_id = $request->user_id;
        $financeVendorService->document_type = $request->document_type;
        $financeVendorService->save();


           //percentage simple interest
        $percentage_interest_rate = ($request->interest_rate / 100);


        //loan  duration period in months
        $loan_plan = LoanPlan::find($request->loan_plan_id);
        $loan_plan_duration =$loan_plan->value;
        $time = ($loan_plan_duration/12);
        // dd($request->principal,$percentage_interest_rate,$time);


        $calculated_year_simple_interest = (int)($request->principal * $percentage_interest_rate * $time);
        $total_pay_amount = $calculated_year_simple_interest + $request->principal;


        $financeVendorService->simple_interest = $calculated_year_simple_interest;
        $financeVendorService->total_amount_paid_back = $total_pay_amount;
        $financeVendorService->save();



        if($request->loan_pay_back == "Daily"){
            #a month has 30.417 days
            $total_days = $loan_plan_duration * 30.417 ;
            $daily_pay = ($total_pay_amount / $total_days);
            $financeVendorService->payment_frequency_pay = $daily_pay;
            $financeVendorService->save();

        }elseif($request->loan_pay_back  == "Weekly"){
            #a month has 4 weeks
            $total_weeks = $loan_plan_duration * 4;
            $weekly_pay = ($total_pay_amount / $total_weeks);
            $financeVendorService->payment_frequency_pay = $weekly_pay;
            $financeVendorService->save();

        }elseif($request->loan_pay_back  == "Monthly"){

            $monthly_payment = ($total_pay_amount / $loan_plan_duration) ;
            $financeVendorService->payment_frequency_pay = $monthly_payment;
            $financeVendorService->save();

        }


        if(!empty($request->address_id)){
            $location = Address::find($request->address_id);
            $financeVendorService->location = $location->district_name;
            $financeVendorService->save();
        }

       if(!empty($request->file('image'))){
           File::delete('storage/finance/'.$financeVendorService->image);
           $financeVendorService->image = \App\Models\ImageUploader::upload($request->file('image'),'finance');
           $financeVendorService->save();
       }


    //    if(!empty($request->document_type)){

    //       $financeVendorService->save();
    //    }


        Flash::success('Finance Vendor Service updated successfully.');


        return redirect(route('financeVendorServices.index'));
    }


    /**
     * Remove the specified FinanceVendorService from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $financeVendorService = $this->financeVendorServiceRepository->find($id);


        if (empty($financeVendorService)) {
            Flash::error('Finance Vendor Service not found');


            return redirect(route('financeVendorServices.index'));
        }


        $this->financeVendorServiceRepository->delete($id);


        Flash::success('Finance Vendor Service deleted successfully.');


        return redirect(route('financeVendorServices.index'));
    }
}
