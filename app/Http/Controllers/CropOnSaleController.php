<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCropOnSaleRequest;
use App\Http\Requests\UpdateCropOnSaleRequest;
use App\Repositories\CropOnSaleRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CropOnSaleController extends AppBaseController
{
    /** @var CropOnSaleRepository $cropOnSaleRepository*/
    private $cropOnSaleRepository;

    public function __construct(CropOnSaleRepository $cropOnSaleRepo)
    {
        $this->cropOnSaleRepository = $cropOnSaleRepo;
    }

    /**
     * Display a listing of the CropOnSale.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $cropOnSales = $this->cropOnSaleRepository->all();

        return view('crop_on_sales.index')
            ->with('cropOnSales', $cropOnSales);
    }

    /**
     * Show the form for creating a new CropOnSale.
     *
     * @return Response
     */
    public function create()
    {
        return view('crop_on_sales.create');
    }

    /**
     * Store a newly created CropOnSale in storage.
     *
     * @param CreateCropOnSaleRequest $request
     *
     * @return Response
     */
    public function store(CreateCropOnSaleRequest $request)
    {
        $input = $request->all();

        $cropOnSale = $this->cropOnSaleRepository->create($input);

        Flash::success('Crop On Sale saved successfully.');

        return redirect(route('cropOnSales.index'));
    }

    /**
     * Display the specified CropOnSale.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cropOnSale = $this->cropOnSaleRepository->find($id);

        if (empty($cropOnSale)) {
            Flash::error('Crop On Sale not found');

            return redirect(route('cropOnSales.index'));
        }

        return view('crop_on_sales.show')->with('cropOnSale', $cropOnSale);
    }

    /**
     * Show the form for editing the specified CropOnSale.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cropOnSale = $this->cropOnSaleRepository->find($id);

        if (empty($cropOnSale)) {
            Flash::error('Crop On Sale not found');

            return redirect(route('cropOnSales.index'));
        }

        return view('crop_on_sales.edit')->with('cropOnSale', $cropOnSale);
    }

    /**
     * Update the specified CropOnSale in storage.
     *
     * @param int $id
     * @param UpdateCropOnSaleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCropOnSaleRequest $request)
    {
        $cropOnSale = $this->cropOnSaleRepository->find($id);

        if (empty($cropOnSale)) {
            Flash::error('Crop On Sale not found');

            return redirect(route('cropOnSales.index'));
        }

        $cropOnSale = $this->cropOnSaleRepository->update($request->all(), $id);

        Flash::success('Crop On Sale updated successfully.');

        return redirect(route('cropOnSales.index'));
    }

    /**
     * Remove the specified CropOnSale from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cropOnSale = $this->cropOnSaleRepository->find($id);

        if (empty($cropOnSale)) {
            Flash::error('Crop On Sale not found');

            return redirect(route('cropOnSales.index'));
        }

        $this->cropOnSaleRepository->delete($id);

        Flash::success('Crop On Sale deleted successfully.');

        return redirect(route('cropOnSales.index'));
    }
}
