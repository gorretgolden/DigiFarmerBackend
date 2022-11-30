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
    public function store(CreateTrainingVendorServiceRequest $request)
    {
        $input = $request->all();

        $trainingVendorService = $this->trainingVendorServiceRepository->create($input);

        Flash::success('Training Vendor Service saved successfully.');

        return redirect(route('trainingVendorServices.index'));
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
