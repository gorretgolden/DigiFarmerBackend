<?php

namespace App\Http\Controllers;

use App\DataTables\CropOrderDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCropOrderRequest;
use App\Http\Requests\UpdateCropOrderRequest;
use App\Repositories\CropOrderRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\CropOrder;
use App\Models\CropOrderCropOnSale;

class CropOrderController extends AppBaseController
{
    /** @var CropOrderRepository $cropOrderRepository*/
    private $cropOrderRepository;

    public function __construct(CropOrderRepository $cropOrderRepo)
    {
        $this->cropOrderRepository = $cropOrderRepo;
    }

    /**
     * Display a listing of the CropOrder.
     *
     * @param CropOrderDataTable $cropOrderDataTable
     *
     * @return Response
     */
    // public function index(CropOrderDataTable $cropOrderDataTable)
    // {
    //     return $cropOrderDataTable->render('crop_orders.index');
    // }

    public function index()
    {
    $orders = CropOrder::with('crops_on_sale')->get();
    return view('crop_orders.index', compact('orders'));
   }

    /**
     * Show the form for creating a new CropOrder.
     *
     * @return Response
     */
    public function create()
    {
        return view('crop_orders.create');
    }

    /**
     * Store a newly created CropOrder in storage.
     *
     * @param CreateCropOrderRequest $request
     *
     * @return Response
     */
    public function store(CreateCropOrderRequest $request)
    {

        $existing_buyer = CropOrder::where('user_id',$request->user_id)->first();
        $existing_crop_on_sale = CropOrderCropOnSale::where('crop_on_sale_id', $request->crops_on_sales)->first();
       // dd($existing_crop_on_sale );

        if($existing_buyer && $existing_crop_on_sale ){

            Flash::error('You already made an order for'. " ". $existing_crop_on_sale->crop_on_sale->quantity.$existing_crop_on_sale->crop_on_sale->quantity_unit. " ". 'of'. " ". $existing_crop_on_sale->crop_on_sale->crop->name. " ". 'sold by' ." ". 'farmer:'. " ". $existing_crop_on_sale->crop_on_sale->user->username );

            return redirect(route('cropOrders.index'));

        }
        else{

            $order = CropOrder::create($request->all());

            //dd($order);

            $crop_orders = $request->input('crops_on_sales', []);
           //dd($crop_orders);

            $buying_prices = $request->input('buying_prices', []);
           //dd($buying_prices);
            for ($crop_order=0; $crop_order < count($crop_orders); $crop_order++) {
              if ($crop_orders[$crop_order] != '') {
                //dd($crop_orders[$crop_order]);

                $order->crops_on_sale()->attach($crop_orders[$crop_order], ['buying_price' => $buying_prices[$crop_order]]);
              }
            }


             Flash::success('Crop Order saved successfully.');

             return redirect(route('cropOrders.index'));
        }


    }

    /**
     * Display the specified CropOrder.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cropOrder = $this->cropOrderRepository->find($id);

        if (empty($cropOrder)) {
            Flash::error('Crop Order not found');

            return redirect(route('cropOrders.index'));
        }

        return view('crop_orders.show')->with('cropOrder', $cropOrder);
    }

    /**
     * Show the form for editing the specified CropOrder.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cropOrder = $this->cropOrderRepository->find($id);

        if (empty($cropOrder)) {
            Flash::error('Crop Order not found');

            return redirect(route('cropOrders.index'));
        }

        return view('crop_orders.edit')->with('cropOrder', $cropOrder);
    }

    /**
     * Update the specified CropOrder in storage.
     *
     * @param int $id
     * @param UpdateCropOrderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCropOrderRequest $request)
    {
        $cropOrder = $this->cropOrderRepository->find($id);

        if (empty($cropOrder)) {
            Flash::error('Crop Order not found');

            return redirect(route('cropOrders.index'));
        }

        $cropOrder = $this->cropOrderRepository->update($request->all(), $id);

        Flash::success('Crop Order updated successfully.');

        return redirect(route('cropOrders.index'));
    }

    /**
     * Remove the specified CropOrder from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cropOrder = $this->cropOrderRepository->find($id);

        if (empty($cropOrder)) {
            Flash::error('Crop Order not found');

            return redirect(route('cropOrders.index'));
        }

        $this->cropOrderRepository->delete($id);

        Flash::success('Crop Order deleted successfully.');

        return redirect(route('cropOrders.index'));
    }
}
