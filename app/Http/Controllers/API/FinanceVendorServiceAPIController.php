<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFinanceVendorServiceAPIRequest;
use App\Http\Requests\API\UpdateFinanceVendorServiceAPIRequest;
use App\Models\FinanceVendorService;
use App\Repositories\FinanceVendorServiceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

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
        $financeVendorService = FinanceVendorService::with('vendory_category','user')->get();
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
    public function store(CreateFinanceVendorServiceAPIRequest $request)
    {
         //existing finance
       $existing_finance = FinanceVendorService::where('name',$request->name)->first();
       if(!$existing_finance){
           $new_finance_service = new FinanceVendorService();
           $new_finance_service->name = $request->name;
           $new_finance_service->principal = $request->principal;
           $new_finance_service->interest_rate = $request->interest_rate;
           $new_finance_service->duration = $request->duration;

           //simple interest
           $percentage_interest_rate = ($request->interest_rate / 100);
           $calculate_simple_interest = (int)($request->principal * $percentage_interest_rate * $request->duration);

           $new_finance_service->simple_interest = $calculate_simple_interest;
           $new_finance_service->interest_rate = $request->interest_rate;

           if($request->payment_frequency == 'Monthly'){
            $monthly_pay =  ($request->principal * (((int)$request->duration) /365) * 30);
            dd($monthly_pay);
            $new_finance_service->total_amount_paid_back = $request->total_amount_paid_back;
           }

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
            return response()->json($response,403);
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
