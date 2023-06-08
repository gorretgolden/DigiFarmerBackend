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
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Notifications\NewFarmerOrder;

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
        $cart_user = Cart::where('user_id',auth()->user()->id)->first();

        if(empty($cart_user)){

               return response()->json(
                [
                    "success" => false,
                    "message" => "User has no cart",
                ],
                404
            );

        }
        $cart = CartItem::where('cart_id',$cart_user->id)->get();
        $data = [];
        $save_data =[];

        if(empty($cart)){

               return response()->json(
                [
                    "success" => false,
                    "message" => "Your cart it empty",
                ],
                404
            );

        }else{

             foreach ($cart as $cart_data) {
                $save_data[] = [
                    "cart_id" => $cart_data["cart_id"],
                    "vendor_service_id" => $cart_data["vendor_service_id"],
                    "quantity" => $cart_data["quantity"],
                    "type" => $cart_data["type"],
                    "total_cost" => $cart_data["total_cost"],
                    "user_id" => $cart_data["user_id"] ?? $request->user()->id,
                ];
            }

            foreach ($save_data as $save) {
                $newCart[] = CartPivot::create([
                    "cart_id" => $save["cart_id"],
                    "vendor_service_id" => $save["vendor_service_id"],
                    "quantity" => $save["quantity"],
                    "type" => $save["type"],
                    "total_cost" => $save["total_cost"],
                    "user_id" => $save["user_id"],
                ]);


                //update farmer and vendor details
                $vendor_service = VendorService::find($save["vendor_service_id"]);
                $vendor = $vendor_service->vendor;

                $data['vendor_service'] = $vendor_service->name;
                $data['vendor'] = $vendor;
                $data['vendor_name'] = $vendor_service->vendor->username;
                $data['farmer_name'] = auth()->user()->username;
                $data['farmer_email'] = auth()->user()->email;
                $data['vendor_email'] = $vendor_service->vendor->email;



            }


             $farmer = User::find(auth()->user()->id);
             $vendor = User::find($data['vendor']['id']);

            $vendor->notify(new NewFarmerOrder($data));
            $farmer->notify(new NewOrderNotification($data));

            dd($data);


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

            //update order id
            $data['order_id'] = $orderModel->id;


            foreach ($newCart as $cartData) {
                $orderdetail = new orderDetail();
                $orderdetail->cart_pivot_id = $cartData["id"];
                $orderModel->orderDetails()->save($orderdetail);
            }

               //send notifacation after order


            CartItem::where(["user_id" => $request->user()->id])->delete();

            //notify farmer and vendor

            return response()->json(
                [
                    "success" => true,
                    "error" => null,
                    "message" => "Order added successfully",
                ],
                201
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
