<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTraningVendorServiceRequest;
use App\Http\Requests\UpdateTraningVendorServiceRequest;
use App\Repositories\TraningVendorServiceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class TraningVendorServiceController extends AppBaseController
{
    /** @var TraningVendorServiceRepository $traningVendorServiceRepository*/
    private $traningVendorServiceRepository;

    public function __construct(TraningVendorServiceRepository $traningVendorServiceRepo)
    {
        $this->traningVendorServiceRepository = $traningVendorServiceRepo;
    }

    /**
     * Display a listing of the TraningVendorService.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $traningVendorServices = $this->traningVendorServiceRepository->all();

        return view('traning_vendor_services.index')
            ->with('traningVendorServices', $traningVendorServices);
    }

    /**
     * Show the form for creating a new TraningVendorService.
     *
     * @return Response
     */
    public function create()
    {
        return view('traning_vendor_services.create');
    }

    /**
     * Store a newly created TraningVendorService in storage.
     *
     * @param CreateTraningVendorServiceRequest $request
     *
     * @return Response
     */
    public function store(CreateTraningVendorServiceRequest $request)
    {
        $input = $request->all();

        $traningVendorService = $this->traningVendorServiceRepository->create($input);

        Flash::success('Traning Vendor Service saved successfully.');

        return redirect(route('traningVendorServices.index'));
    }

    /**
     * Display the specified TraningVendorService.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $traningVendorService = $this->traningVendorServiceRepository->find($id);

        if (empty($traningVendorService)) {
            Flash::error('Traning Vendor Service not found');

            return redirect(route('traningVendorServices.index'));
        }

        return view('traning_vendor_services.show')->with('traningVendorService', $traningVendorService);
    }

    /**
     * Show the form for editing the specified TraningVendorService.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $traningVendorService = $this->traningVendorServiceRepository->find($id);

        if (empty($traningVendorService)) {
            Flash::error('Traning Vendor Service not found');

            return redirect(route('traningVendorServices.index'));
        }

        return view('traning_vendor_services.edit')->with('traningVendorService', $traningVendorService);
    }

    /**
     * Update the specified TraningVendorService in storage.
     *
     * @param int $id
     * @param UpdateTraningVendorServiceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTraningVendorServiceRequest $request)
    {
        $traningVendorService = $this->traningVendorServiceRepository->find($id);

        if (empty($traningVendorService)) {
            Flash::error('Traning Vendor Service not found');

            return redirect(route('traningVendorServices.index'));
        }

        $traningVendorService = $this->traningVendorServiceRepository->update($request->all(), $id);

        Flash::success('Traning Vendor Service updated successfully.');

        return redirect(route('traningVendorServices.index'));
    }

    /**
     * Remove the specified TraningVendorService from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $traningVendorService = $this->traningVendorServiceRepository->find($id);

        if (empty($traningVendorService)) {
            Flash::error('Traning Vendor Service not found');

            return redirect(route('traningVendorServices.index'));
        }

        $this->traningVendorServiceRepository->delete($id);

        Flash::success('Traning Vendor Service deleted successfully.');

        return redirect(route('traningVendorServices.index'));
    }
}
