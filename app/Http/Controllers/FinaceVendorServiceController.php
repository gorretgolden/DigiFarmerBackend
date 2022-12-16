<?php

namespace App\Http\Controllers;

use App\DataTables\FinaceVendorServiceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateFinaceVendorServiceRequest;
use App\Http\Requests\UpdateFinaceVendorServiceRequest;
use App\Repositories\FinaceVendorServiceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\FinanceVendorService;
use App\Models\LoanPlan;
use App\Models\LoanPayBack;

class FinaceVendorServiceController extends AppBaseController
{
    /** @var FinaceVendorServiceRepository $finaceVendorServiceRepository*/
    private $finaceVendorServiceRepository;

    public function __construct(FinaceVendorServiceRepository $finaceVendorServiceRepo)
    {
        $this->finaceVendorServiceRepository = $finaceVendorServiceRepo;
    }

    /**
     * Display a listing of the FinaceVendorService.
     *
     * @param FinaceVendorServiceDataTable $finaceVendorServiceDataTable
     *
     * @return Response
     */
    public function index(FinaceVendorServiceDataTable $finaceVendorServiceDataTable)
    {
        return $finaceVendorServiceDataTable->render('finace_vendor_services.index');
    }

    /**
     * Show the form for creating a new FinaceVendorService.
     *
     * @return Response
     */
    public function create()
    {
        return view('finace_vendor_services.create');
    }

    /**
     * Store a newly created FinaceVendorService in storage.
     *
     * @param CreateFinaceVendorServiceRequest $request
     *
     * @return Response
     */


     public function random_strings($length_of_string)
     {

         // String of all alphanumeric character
         $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';


         return substr(str_shuffle($str_result),0, $length_of_string);
     }
    public function store(CreateFinaceVendorServiceRequest $request)
    {
        $existing_finance = FinanceVendorService::where('name',$request->name)->first();





        if(!$existing_finance){

            $new_finance_service = new FinanceVendorService();
            $new_finance_service->name = $request->name;
            $new_finance_service->principal = $request->principal;
            $new_finance_service->interest_rate = $request->interest_rate;
            $new_finance_service->interest_rate_unit = "%";
            $new_finance_service->loan_plan_id = $request->loan_plan_id;
            $new_finance_service->loan_pay_back_id = $request->loan_pay_back_id;
            $new_finance_service->status = $request->status;
            $new_finance_service->vendor_category_id = $request->vendor_category_id;
            $new_finance_service->finance_vendor_category_id = $request->finance_vendor_category_id;
            $new_finance_service->user_id = auth()->user()->id;


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


            $loan_number = $this->random_strings(10);
            $new_finance_service->loan_number = $loan_number;

            $new_finance_service->save();


            //frequency pay
            $loan_pay_back = LoanPayBack::find($request->loan_pay_back_id);

            if($loan_pay_back->name == "Daily"){

                $payment_frequency_pay =  $percentage_interest_rate * $request->principal;
                #a month has 30.417 days
                $total_days = $loan_plan_duration * 30.417 ;
                $daily_pay = ($total_pay_amount / $total_days);
                $new_finance_service->payment_frequency_pay = $daily_pay;
                $new_finance_service->save();


            }elseif($loan_pay_back->name == "Weekly"){
                #a month has 4 weeks
                $total_weeks = $loan_plan_duration * 4;
                $weekly_pay = ($total_pay_amount / $total_weeks);
                $new_finance_service->payment_frequency_pay = $weekly_pay;
                $new_finance_service->save();

            }elseif($loan_pay_back->name == "Monthly"){

                $monthly_payment =  $percentage_interest_rate * $request->principal;
                $new_finance_service->payment_frequency_pay = $monthly_payment;
                $new_finance_service->save();


            }


             Flash::success('Finace Vendor Service saved successfully.');

             return redirect(route('finaceVendorServices.index'));

        }
        else{

            Flash::success('Finace Vendor name already exists.');

             return redirect(route('finaceVendorServices.index'));


        }


    }

    /**
     * Display the specified FinaceVendorService.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $finaceVendorService = $this->finaceVendorServiceRepository->find($id);

        if (empty($finaceVendorService)) {
            Flash::error('Finace Vendor Service not found');

            return redirect(route('finaceVendorServices.index'));
        }

        return view('finace_vendor_services.show')->with('finaceVendorService', $finaceVendorService);
    }

    /**
     * Show the form for editing the specified FinaceVendorService.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $finaceVendorService = $this->finaceVendorServiceRepository->find($id);

        if (empty($finaceVendorService)) {
            Flash::error('Finace Vendor Service not found');

            return redirect(route('finaceVendorServices.index'));
        }

        return view('finace_vendor_services.edit')->with('finaceVendorService', $finaceVendorService);
    }

    /**
     * Update the specified FinaceVendorService in storage.
     *
     * @param int $id
     * @param UpdateFinaceVendorServiceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFinaceVendorServiceRequest $request)
    {
        $finaceVendorService = $this->finaceVendorServiceRepository->find($id);

        if (empty($finaceVendorService)) {
            Flash::error('Finace Vendor Service not found');

            return redirect(route('finaceVendorServices.index'));
        }

        $finaceVendorService = $this->finaceVendorServiceRepository->update($request->all(), $id);

        Flash::success('Finace Vendor Service updated successfully.');

        return redirect(route('finaceVendorServices.index'));
    }

    /**
     * Remove the specified FinaceVendorService from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $finaceVendorService = $this->finaceVendorServiceRepository->find($id);

        if (empty($finaceVendorService)) {
            Flash::error('Finace Vendor Service not found');

            return redirect(route('finaceVendorServices.index'));
        }

        $this->finaceVendorServiceRepository->delete($id);

        Flash::success('Finace Vendor Service deleted successfully.');

        return redirect(route('finaceVendorServices.index'));
    }
}
