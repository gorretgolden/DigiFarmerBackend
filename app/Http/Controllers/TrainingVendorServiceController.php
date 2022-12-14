<?php

namespace App\Http\Controllers;

use App\DataTables\TrainingVendorServiceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTrainingVendorServiceRequest;
use App\Http\Requests\UpdateTrainingVendorServiceRequest;
use App\Repositories\TrainingVendorServiceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Http\Request;
use App\Models\TrainingVendorService;

class TrainingVendorServiceController extends AppBaseController
{
    /** @var TrainingVendorServiceRepository $trainingVendorServiceRepository*/
    private $trainingVendorServiceRepository;

    public function __construct(TrainingVendorServiceRepository $trainingVendorServiceRepo)
    {
        $this->trainingVendorServiceRepository = $trainingVendorServiceRepo;
    }

    /**
     * Display a listing of the TrainingVendorService.
     *
     * @param TrainingVendorServiceDataTable $trainingVendorServiceDataTable
     *
     * @return Response
     */
    public function index(TrainingVendorServiceDataTable $trainingVendorServiceDataTable)
    {
        return $trainingVendorServiceDataTable->render('training_vendor_services.index');
    }

    /**
     * Show the form for creating a new TrainingVendorService.
     *
     * @return Response
     */
    public function create()
    {
        return view('training_vendor_services.create');
    }

    /**
     * Store a newly created TrainingVendorService in storage.
     *
     * @param CreateTrainingVendorServiceRequest $request
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
            'vendor_category_id' => 'required|integer',
            'period_unit_id'  => 'required|integer',
        ];
        $request->validate($rules);

        //access
        if($request->access == 'Online'){

            $request->validate(['zoom_details' => 'required|string']);
            $input['zoom_details'] = $request->zoom_details;
            $online_training = new TrainingVendorService();
            $online_training->name = $request->name;
            $online_training->charge = $request->charge;
            $online_training->description = $request->description;
            $online_training->period = $request->period;
            $online_training->period_unit_id = $request->period_unit_id;
            $online_training->access = $request->access;
            $online_training->starting_time = $request->starting_time;
            $online_training->ending_time = $request->ending_time;
            $online_training->starting_date = $request->starting_date;
            $online_training->ending_date = $request->ending_date;
            $online_training->vendor_category_id = $request->vendor_category_id;
            $online_training->user_id = $request->user_id;
            $online_training->zoom_details = $request->zoom_details;
            $online_training->save();

            Flash::success('Training Vendor Service saved successfully.');
            return redirect(route('trainingVendorServices.index'));


        }else{
            if($request->access =='Offline'){

                $request->validate(['location_details' => 'required|string']);
                $input['location_details'] = $request->location_details;


                $online_training = new TrainingVendorService();
                $online_training->name = $request->name;
                $online_training->charge = $request->charge;
                $online_training->description = $request->description;
                $online_training->period = $request->period;
                $online_training->period_unit_id = $request->period_unit_id;
                $online_training->access = $request->access;
                $online_training->starting_time = $request->starting_time;
                $online_training->ending_time = $request->ending_time;
                $online_training->starting_date = $request->starting_date;
                $online_training->ending_date = $request->ending_date;
                $online_training->vendor_category_id = $request->vendor_category_id;
                $online_training->user_id = $request->user_id;
                $online_training->location_details = $request->location_details;
                $online_training->save();

                Flash::success('Training Vendor Service saved successfully.');

                return redirect(route('trainingVendorServices.index'));

            }


        }


    }

    /**
     * Display the specified TrainingVendorService.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $trainingVendorService = $this->trainingVendorServiceRepository->find($id);

        if (empty($trainingVendorService)) {
            Flash::error('Training Vendor Service not found');

            return redirect(route('trainingVendorServices.index'));
        }

        return view('training_vendor_services.show')->with('trainingVendorService', $trainingVendorService);
    }

    /**
     * Show the form for editing the specified TrainingVendorService.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $trainingVendorService = $this->trainingVendorServiceRepository->find($id);

        if (empty($trainingVendorService)) {
            Flash::error('Training Vendor Service not found');

            return redirect(route('trainingVendorServices.index'));
        }

        return view('training_vendor_services.edit')->with('trainingVendorService', $trainingVendorService);
    }

    /**
     * Update the specified TrainingVendorService in storage.
     *
     * @param int $id
     * @param UpdateTrainingVendorServiceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTrainingVendorServiceRequest $request)
    {
        $trainingVendorService = $this->trainingVendorServiceRepository->find($id);

        if (empty($trainingVendorService)) {
            Flash::error('Training Vendor Service not found');

            return redirect(route('trainingVendorServices.index'));
        }

        $trainingVendorService = $this->trainingVendorServiceRepository->update($request->all(), $id);

        Flash::success('Training Vendor Service updated successfully.');

        return redirect(route('trainingVendorServices.index'));
    }

    /**
     * Remove the specified TrainingVendorService from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $trainingVendorService = $this->trainingVendorServiceRepository->find($id);

        if (empty($trainingVendorService)) {
            Flash::error('Training Vendor Service not found');

            return redirect(route('trainingVendorServices.index'));
        }

        $this->trainingVendorServiceRepository->delete($id);

        Flash::success('Training Vendor Service deleted successfully.');

        return redirect(route('trainingVendorServices.index'));
    }
}
