<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCropBuyerRequest;
use App\Http\Requests\UpdateCropBuyerRequest;
use App\Repositories\CropBuyerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CropBuyerController extends AppBaseController
{
    /** @var CropBuyerRepository $cropBuyerRepository*/
    private $cropBuyerRepository;

    public function __construct(CropBuyerRepository $cropBuyerRepo)
    {
        $this->cropBuyerRepository = $cropBuyerRepo;
    }

    /**
     * Display a listing of the CropBuyer.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $cropBuyers = $this->cropBuyerRepository->all();

        return view('crop_buyers.index')
            ->with('cropBuyers', $cropBuyers);
    }

    /**
     * Show the form for creating a new CropBuyer.
     *
     * @return Response
     */
    public function create()
    {
        return view('crop_buyers.create');
    }

    /**
     * Store a newly created CropBuyer in storage.
     *
     * @param CreateCropBuyerRequest $request
     *
     * @return Response
     */
    public function store(CreateCropBuyerRequest $request)
    {
        $input = $request->all();

        $cropBuyer = $this->cropBuyerRepository->create($input);

        Flash::success('Crop Buyer saved successfully.');

        return redirect(route('cropBuyers.index'));
    }

    /**
     * Display the specified CropBuyer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cropBuyer = $this->cropBuyerRepository->find($id);

        if (empty($cropBuyer)) {
            Flash::error('Crop Buyer not found');

            return redirect(route('cropBuyers.index'));
        }

        return view('crop_buyers.show')->with('cropBuyer', $cropBuyer);
    }

    /**
     * Show the form for editing the specified CropBuyer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cropBuyer = $this->cropBuyerRepository->find($id);

        if (empty($cropBuyer)) {
            Flash::error('Crop Buyer not found');

            return redirect(route('cropBuyers.index'));
        }

        return view('crop_buyers.edit')->with('cropBuyer', $cropBuyer);
    }

    /**
     * Update the specified CropBuyer in storage.
     *
     * @param int $id
     * @param UpdateCropBuyerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCropBuyerRequest $request)
    {
        $cropBuyer = $this->cropBuyerRepository->find($id);

        if (empty($cropBuyer)) {
            Flash::error('Crop Buyer not found');

            return redirect(route('cropBuyers.index'));
        }

        $cropBuyer = $this->cropBuyerRepository->update($request->all(), $id);

        Flash::success('Crop Buyer updated successfully.');

        return redirect(route('cropBuyers.index'));
    }

    /**
     * Remove the specified CropBuyer from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cropBuyer = $this->cropBuyerRepository->find($id);

        if (empty($cropBuyer)) {
            Flash::error('Crop Buyer not found');

            return redirect(route('cropBuyers.index'));
        }

        $this->cropBuyerRepository->delete($id);

        Flash::success('Crop Buyer deleted successfully.');

        return redirect(route('cropBuyers.index'));
    }
}
