<?php

namespace App\Http\Controllers;

use App\DataTables\CropOnSaleDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCropOnSaleRequest;
use App\Http\Requests\UpdateCropOnSaleRequest;
use App\Repositories\CropOnSaleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\CropOnSale;
use App\Models\Plot;
use App\Models\Farm;

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
     * @param CropOnSaleDataTable $cropOnSaleDataTable
     *
     * @return Response
     */
    public function index(CropOnSaleDataTable $cropOnSaleDataTable)
    {
        return $cropOnSaleDataTable->render('crop_on_sales.index');
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




        $existing_farmer = CropOnSale::where('user_id',$request->user_id)->first();
        $existing_crop = CropOnSale::where('crop_id',$request->crop_id)->first();

        if($existing_farmer && $existing_crop){

            Flash::error('Farmer already posted this crop for sale');
            return redirect(route('cropOnSales.index'));
       }

       else
        {

            //get farm for farmer
           $farmer = $request->user_id;
           //get farm
           $farm = Farm::where('user_id', $farmer)->first();
           dd($farm->plots);//check for plots
          //dd($farmer);

            if (empty($farm)) {
                Flash::error('Farmer has no farm');

                return redirect(route('cropOnSales.index'));
            }

           $crop_plot = Plot::where('crop_id',$request->crop_id)->first();

           if($crop_plot){

               //dd($crop_plot->total_harvest);
           $total_stock = $crop_plot->total_harvest;

           $crop_on_sale = new CropOnSale();
           $crop_on_sale->quantity = $total_stock;
           $crop_on_sale->selling_price = $request->selling_price;
           $crop_on_sale->crop_id = $request->crop_id;
           $crop_on_sale->user_id = $request->user_id;
           $crop_on_sale->save();


           Flash::success('Crop posted for sale successfully.');
           return redirect(route('cropOnSales.index'));


           }
           else{

            Flash::error('This crop doesnt exit on your farm plot');

            return redirect(route('cropOnSales.index'));
           }


       }


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
