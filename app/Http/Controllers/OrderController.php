<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\VendorService;
use App\Models\CartPivot;
use App\Models\Orders;
use App\Models\orderDetail;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $data = Orders::where(["user_id" => $request->user()->id])
                ->with("orderDetails.cart.product")
                ->get();

            return response()->json([
                "success" => true,
                "message" => "orders fetched successfully",
                "data" => $data,
                "error" => null,
            ]);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Error processing orders",
                "data" => null,
                "error" => $e->getMessage(),
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart = CartItem::all();

        if (!$cart->isEmpty()) {
            foreach ($cart as $cart_data) {
                $save_data[] = [
                    "id" => $cart_data["id"],
                    "cart_id" => $cart_data["cart_id"],
                    "vendor_service_id" => $cart_data["vendor_service_id"],
                    "quantity" => $cart_data["quantity"],
                    "type" => $cart_data["type"],
                    "total_cost" => $cart_data["total_cost"],
                    "user_id" => $cart_data["user_id"],
                ];
            }

            DB::table("cart_pivots")->insert($save_data);
            $orderModel = new Orders();
            $orderModel->payment_method = $request->payment_method;
            $orderModel->total_amount = $request->total_amount;
            $orderModel->user_id = $request->user()->id;
            $orderModel->payment_status = "unpaid";
            $orderModel->id = mt_rand(1000000000, 9999999999);
            $orderModel->amount_paid = $request->amount_paid;
            $orderModel->transaction_ref = $request->transaction_ref;
            $orderModel->external_ref = $request->external_ref;
            $orderModel->save();
            foreach ($cart as $cartData) {
                $orderdetail = new orderDetail();
                $orderdetail->cart_pivot_id = $cartData->id;
                $orderModel->orderDetails()->save($orderdetail);
            }

            CartItem::where(["user_id" => $request->user()->id])->delete();
        } else {
            return response()->json(
                ["message" => "You add some items to cart"],
                402
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
