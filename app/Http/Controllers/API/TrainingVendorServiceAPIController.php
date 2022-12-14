<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTrainingVendorServiceAPIRequest;
use App\Http\Requests\API\UpdateTrainingVendorServiceAPIRequest;
use App\Models\TrainingVendorService;
use App\Repositories\TrainingVendorServiceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Carbon\Carbon;
/**
 * Class TrainingVendorServiceController
 * @package App\Http\Controllers\API
 */

class TrainingVendorServiceAPIController extends AppBaseController
{
    /** @var  TrainingVendorServiceRepository */
    private $trainingVendorServiceRepository;

    public function __construct(TrainingVendorServiceRepository $trainingVendorServiceRepo)
    {
        $this->trainingVendorServiceRepository = $trainingVendorServiceRepo;
    }

    /**
     * Display a listing of the TrainingVendorService.
     * GET|HEAD /trainingVendorServices
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $trainingVendorServices = $this->trainingVendorServiceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($trainingVendorServices->toArray(), 'Training Vendor Services retrieved successfully');
    }

    /**
     * Store a newly created TrainingVendorService in storage.
     * POST /trainingVendorServices
     *
     * @param CreateTrainingVendorServiceAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required|string|unique:training_vendor_services',
            'charge' => 'required|integer',
            'description' => 'required|string',
            'period' => 'required|integer',
            'access' => 'required|string',
            'starting_date' => 'required|date',
            'ending_date' => 'required|after_or_equal:starting_date',
            'starting_time' => 'required|before:ending_time',
            'ending_time' => 'required|after:starting_time',
            'location_details' => 'nullable',
            'period_unit_id'  => 'required|integer',
        ];
        $request->validate($rules);
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;

        //access
        if($input['access']=='Online'){
            $request->validate(['zoom_details' => 'required|string']);
            $input['zoom_details'] = $request->zoom_details;
            $input['vendor_category_id'] = 5;
            $trainingVendorService = $this->trainingVendorServiceRepository->create($input);
            return $this->sendResponse($trainingVendorService->toArray(), 'Training Vendor Service saved successfully');


        }else{
            if($input['access']=='Offline'){

                $request->validate(['location_details' => 'required|string']);
                $input['location_details'] = $request->location_details;
                $input['vendor_category_id'] = 5;
                $trainingVendorService = $this->trainingVendorServiceRepository->create($input);
                return $this->sendResponse($trainingVendorService->toArray(), 'Training Vendor Service saved successfully');
            }


        }



    }

    /**
     * Display the specified TrainingVendorService.
     * GET|HEAD /trainingVendorServices/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var TrainingVendorService $trainingVendorService */
        $trainingVendorService = $this->trainingVendorServiceRepository->find($id);

        if (empty($trainingVendorService)) {
            return $this->sendError('Training Vendor Service not found');
        }

        return $this->sendResponse($trainingVendorService->toArray(), 'Training Vendor Service retrieved successfully');
    }

    /**
     * Update the specified TrainingVendorService in storage.
     * PUT/PATCH /trainingVendorServices/{id}
     *
     * @param int $id
     * @param UpdateTrainingVendorServiceAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTrainingVendorServiceAPIRequest $request)
    {
        $input = $request->all();

        /** @var TrainingVendorService $trainingVendorService */
        $trainingVendorService = $this->trainingVendorServiceRepository->find($id);

        if (empty($trainingVendorService)) {
            return $this->sendError('Training Vendor Service not found');
        }

        $trainingVendorService = $this->trainingVendorServiceRepository->update($input, $id);

        return $this->sendResponse($trainingVendorService->toArray(), 'TrainingVendorService updated successfully');
    }

    /**
     * Remove the specified TrainingVendorService from storage.
     * DELETE /trainingVendorServices/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var TrainingVendorService $trainingVendorService */
        $trainingVendorService = $this->trainingVendorServiceRepository->find($id);

        if (empty($trainingVendorService)) {
            return $this->sendError('Training Vendor Service not found');
        }

        $trainingVendorService->delete();

        return $this->sendSuccess('Training Vendor Service deleted successfully');
    }
}
