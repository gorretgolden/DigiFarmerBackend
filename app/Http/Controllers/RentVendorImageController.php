<?php

namespace App\Http\Controllers;

use App\DataTables\RentVendorImageDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateRentVendorImageRequest;
use App\Http\Requests\UpdateRentVendorImageRequest;
use App\Repositories\RentVendorImageRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class RentVendorImageController extends AppBaseController
{
    /** @var RentVendorImageRepository $rentVendorImageRepository*/
    private $rentVendorImageRepository;

    public function __construct(RentVendorImageRepository $rentVendorImageRepo)
    {
        $this->rentVendorImageRepository = $rentVendorImageRepo;
    }

    /**
     * Display a listing of the RentVendorImage.
     *
     * @param RentVendorImageDataTable $rentVendorImageDataTable
     *
     * @return Response
     */
    public function index(RentVendorImageDataTable $rentVendorImageDataTable)
    {
        return $rentVendorImageDataTable->render('rent_vendor_images.index');
    }

    /**
     * Show the form for creating a new RentVendorImage.
     *
     * @return Response
     */
    public function create()
    {
        return view('rent_vendor_images.create');
    }

    /**
     * Store a newly created RentVendorImage in storage.
     *
     * @param CreateRentVendorImageRequest $request
     *
     * @return Response
     */
    public function store(CreateRentVendorImageRequest $request)
    {
        $input = $request->all();

        $rentVendorImage = $this->rentVendorImageRepository->create($input);

        Flash::success('Rent Vendor Image saved successfully.');

        return redirect(route('rentVendorImages.index'));
    }

    /**
     * Display the specified RentVendorImage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $rentVendorImage = $this->rentVendorImageRepository->find($id);

        if (empty($rentVendorImage)) {
            Flash::error('Rent Vendor Image not found');

            return redirect(route('rentVendorImages.index'));
        }

        return view('rent_vendor_images.show')->with('rentVendorImage', $rentVendorImage);
    }

    /**
     * Show the form for editing the specified RentVendorImage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $rentVendorImage = $this->rentVendorImageRepository->find($id);

        if (empty($rentVendorImage)) {
            Flash::error('Rent Vendor Image not found');

            return redirect(route('rentVendorImages.index'));
        }

        return view('rent_vendor_images.edit')->with('rentVendorImage', $rentVendorImage);
    }

    /**
     * Update the specified RentVendorImage in storage.
     *
     * @param int $id
     * @param UpdateRentVendorImageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRentVendorImageRequest $request)
    {
        $rentVendorImage = $this->rentVendorImageRepository->find($id);

        if (empty($rentVendorImage)) {
            Flash::error('Rent Vendor Image not found');

            return redirect(route('rentVendorImages.index'));
        }

        $rentVendorImage = $this->rentVendorImageRepository->update($request->all(), $id);

        Flash::success('Rent Vendor Image updated successfully.');

        return redirect(route('rentVendorImages.index'));
    }

    /**
     * Remove the specified RentVendorImage from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $rentVendorImage = $this->rentVendorImageRepository->find($id);

        if (empty($rentVendorImage)) {
            Flash::error('Rent Vendor Image not found');

            return redirect(route('rentVendorImages.index'));
        }

        $this->rentVendorImageRepository->delete($id);

        Flash::success('Rent Vendor Image deleted successfully.');

        return redirect(route('rentVendorImages.index'));
    }
}
