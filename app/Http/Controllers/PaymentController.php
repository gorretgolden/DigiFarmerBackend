<?php

namespace App\Http\Controllers;

use KingFlamez\Rave\Facades\Rave as Flutterwave;
use App\Models\User;
use App\Models\Order;
use App\Http\Controllers\HousePlanController;
use Session;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Initialize Rave payment process
     * @return void
     */
    public function initialize()
    {
        //This generates a payment reference
        $reference = Flutterwave::generateReference();

        // Enter the details of the payment
        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => request()->price,
            'email' => request()->email,
            'tx_ref' => $reference,
            'currency' => "UGX",
            'redirect_url' => route('callback'),
            'customer' => [
                'email' => request()->email,
                "phone_number" => request()->phone,
                "name" => request()->name,
            ],

            "customizations" => [
                "title" => request()->title,
                "description" =>  request()->description
            ]
        ];

        Session::put('product_id', request()->id);
        Session::put('price', request()->price);
        Session::put('which_product', request()->which_product);
        // request()->session::put('product_id', request()->id);
        //request()->session::put('price', request()->price);

        $payment = Flutterwave::initializePayment($data);


        if ($payment['status'] !== 'success') {
            // notify something went wrong
            return;
        }

        return redirect($payment['data']['link']);
    }

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback()
    {

        $status = request()->status;

        //if payment is successful
        if ($status ==  'successful') {

        $transactionID = Flutterwave::getTransactionIDFromCallback();
        $data = Flutterwave::verifyTransaction($transactionID);


        // return  Session::get('product_id');
        // Session::get('product_id')

        // Session::flush();
        $data2 = ['loggedUserInfo'=>User::where('id','=',session('loggedUser'))->first()];

        foreach ( $data2  as $key) {
           $userId = $key->id;
        }

        $order = new Order();

        $order->user_id = $userId;
        $order->transaction_id = $transactionID;
        $order->total =  Session::get('price');
        $order->which_product = Session::get('which_product');

        $save = $order->save();
        $current_id = $order->id;
       $product_order = DB::table('order_product')->insert([
              "order_id" => $current_id,
              "product_id" => Session::get('product_id'),
              "quantity" => "1"
              ]
       );

        if ( $save &&   $product_order  ) {


            if ($order->which_product == "house_plan") {
                return HousePlanController::sendEmailWithPdfs(Session::get('product_id'),  $userId);
            }elseif ($order->which_product == "product") {
                return ProductUserController::sendEmailWithPdfs(Session::get('product_id'),  $userId);
            }



        //    return HousePlanController::sendEmailWithPdfs(Session::get('product_id'),  $userId);


        } else {
            emotify('error', 'Something went wrong');
            return  back();
            // return "Something went wrong";
        }




        }
        elseif ($status ==  'cancelled'){
            $data2 = ['loggedUserInfo'=>User::where('id','=',session('loggedUser'))->first()];

            //Put desired action/code after transaction has been cancelled here
            return view('user-dashboard.cancelled-payment', $data2);
        }
        else{
            //Put desired action/code after transaction has failed here
        }
        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (including parameters that didn't exist before the transaction is completed. for audit purpose)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here

    }


}
