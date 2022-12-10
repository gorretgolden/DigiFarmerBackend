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
    public function store(CreateFinaceVendorServiceRequest $request)
    {
        $existing_finance = FinanceVendorService::where('name',$request->name)->first();

        if(!$existing_finance){
            $new_finance_service = new FinanceVendorService();
            $new_finance_service->name = $request->name;
            $new_finance_service->principal = $request->principal;
            $new_finance_service->interest_rate = $request->interest_rate;
            $new_finance_service->duration = $request->duration;
            $new_finance_service->duration_unit = $request->duration_unit;

            //simple interest
            $percentage_interest_rate = ($request->interest_rate / 100);

            //year loan
            if($request->duration_unit == 'years'){
                $calculated_year_simple_interest = (int)($request->principal * $percentage_interest_rate * $request->duration);
                $new_finance_service->simple_interest = $calculated_year_simple_interest;

                //total-amount paid back
                $total_year_pay = int($calculated_year_simple_interest +  $request->principal);
                $new_finance_service->total_amount_paid_back = $total_year_pay ;

                 if($request->payment_frequency == 'Monthly'){
                    $monthly_pay = ($total_pay_back / ($request->duration * 12));
                    dd($monthly_pay);
                    $new_finance_service->payment_frequency_pay = $monthly_pay;

                   }
            }else{
                //month loan
                $monthly_duration = ($request->duration/ 12);
                $calculated_month_simple_interest = (int)($request->principal * $percentage_interest_rate * $monthly_duration);
                $new_finance_service->simple_interest = $calculated_month_simple_interest;
                 //total-amount paid back
                $total_pay_back = int($calculated_month_simple_interest +  $request->principal);
                $new_finance_service->total_amount_paid_back = $total_pay_back;


               if($request->payment_frequency == 'Monthly'){
                $monthly_pay = ($total_pay_back/ $request->duration) ;
                dd($monthly_pay);
                $new_finance_service->payment_frequency_pay = $monthly_pay;

               }
               elseif($request->payment_frequency == 'Yearly'){

               }

            }





            $new_finance_service->status = $request->status;
            $new_finance_service->vendor_category_id = $request->vendor_category_id;
            $new_finance_service->user_id = auth()->user()->id;
            $new_finance_service->save();

             $success['name'] = $new_finance_service->name;
             $success['principal'] = $new_finance_service->principal;
             $success['interest_rate'] = $new_finance_service->interest_rate;
             $success['duration'] = $new_finance_service->duration;
             $success['payment_frequency'] = $new_finance_service->payment_frequency;
             $success['vendor_category'] = $new_finance_service->vendor_category;
             $success['vendor'] = $new_finance_service->user;

             Flash::success('Finace Vendor Service saved successfully.');

             return redirect(route('finaceVendorServices.index'));

        }
        else{

             return response()->json($response,403);
             Flash::success('Finance Vendor service name exists');


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
