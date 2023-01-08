<?php

namespace App\Http\Controllers;

use App\DataTables\InsuaranceVendorServiceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateInsuaranceVendorServiceRequest;
use App\Http\Requests\UpdateInsuaranceVendorServiceRequest;
use App\Repositories\InsuaranceVendorServiceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\VendorCategory;
use App\Models\InsuaranceVendorService;

class InsuaranceVendorServiceController extends AppBaseController
{
    /** @var InsuaranceVendorServiceRepository $insuaranceVendorServiceRepository*/
    private $insuaranceVendorServiceRepository;

    public function __construct(InsuaranceVendorServiceRepository $insuaranceVendorServiceRepo)
    {
        $this->insuaranceVendorServiceRepository = $insuaranceVendorServiceRepo;
    }

    /**
     * Display a listing of the InsuaranceVendorService.
     *
     * @param InsuaranceVendorServiceDataTable $insuaranceVendorServiceDataTable
     *
     * @return Response
     */
    public function index(InsuaranceVendorServiceDataTable $insuaranceVendorServiceDataTable)
    {
        return $insuaranceVendorServiceDataTable->render('insuarance_vendor_services.index');
    }

    /**
     * Show the form for creating a new InsuaranceVendorService.
     *
     * @return Response
     */
    public function create()
    {
        return view('insuarance_vendor_services.create');
    }

    /**
     * Store a newly created InsuaranceVendorService in storage.
     *
     * @param CreateInsuaranceVendorServiceRequest $request
     *
     * @return Response
     */
    public function store(CreateInsuaranceVendorServiceRequest $request)
    {

        $vendor_category = VendorCategory::where('name','Insuarance')->first();


        $new_insuarance = new InsuaranceVendorService();
        $new_insuarance->name = $request->name;
        $new_insuarance->terms = $request->terms;
        $new_insuarance->description = $request->description;
        $new_insuarance->user_id = $request->user_id;
        $new_insuarance->vendor_category_id = $vendor_category->id;
        $new_insuarance->image = $request->image;
        $new_insuarance->save();


        if(!empty($request->file('image'))){
            $new_insuarance->image = \App\Models\ImageUploader::upload($request->file('image'),'insuarance_services');
        }
        $new_insuarance->save();

        Flash::success('Insuarance Vendor Service saved successfully.');

        return redirect(route('insuaranceVendorServices.index'));
    }

    /**
     * Display the specified InsuaranceVendorService.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $insuaranceVendorService = $this->insuaranceVendorServiceRepository->find($id);

        if (empty($insuaranceVendorService)) {
            Flash::error('Insuarance Vendor Service not found');

            return redirect(route('insuaranceVendorServices.index'));
        }

        return view('insuarance_vendor_services.show')->with('insuaranceVendorService', $insuaranceVendorService);
    }

    /**
     * Show the form for editing the specified InsuaranceVendorService.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $insuaranceVendorService = $this->insuaranceVendorServiceRepository->find($id);

        if (empty($insuaranceVendorService)) {
            Flash::error('Insuarance Vendor Service not found');

            return redirect(route('insuaranceVendorServices.index'));
        }

        return view('insuarance_vendor_services.edit')->with('insuaranceVendorService', $insuaranceVendorService);
    }

    /**
     * Update the specified InsuaranceVendorService in storage.
     *
     * @param int $id
     * @param UpdateInsuaranceVendorServiceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInsuaranceVendorServiceRequest $request)
    {
        $insuaranceVendorService = $this->insuaranceVendorServiceRepository->find($id);

        if (empty($insuaranceVendorService)) {
            Flash::error('Insuarance Vendor Service not found');

            return redirect(route('insuaranceVendorServices.index'));
        }

        $insuaranceVendorService = $this->insuaranceVendorServiceRepository->update($request->all(), $id);

        Flash::success('Insuarance Vendor Service updated successfully.');

        return redirect(route('insuaranceVendorServices.index'));
    }

    /**
     * Remove the specified InsuaranceVendorService from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $insuaranceVendorService = $this->insuaranceVendorServiceRepository->find($id);

        if (empty($insuaranceVendorService)) {
            Flash::error('Insuarance Vendor Service not found');

            return redirect(route('insuaranceVendorServices.index'));
        }

        $this->insuaranceVendorServiceRepository->delete($id);

        Flash::success('Insuarance Vendor Service deleted successfully.');

        return redirect(route('insuaranceVendorServices.index'));
    }
}
