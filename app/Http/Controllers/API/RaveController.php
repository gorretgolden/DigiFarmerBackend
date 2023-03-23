<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
class RaveController extends Controller
{


    public function initialize()
    {
        //This generates a payment reference
        $reference = Flutterwave::generateReference();

        // Enter the details of the payment
        $data = [
            'payment_options' => 'mobilemoneyuganda',
            'amount' => 100,
            'email' => auth()->user()->email,
            'tx_ref' => $reference,
            'currency' => "NGN",
            'redirect_url' => route('callback'),
            'customer' => [
                'email' =>auth()->user()->email,
                "phone_number" => auth()->user()->phone,
                "name" => auth()->user()->username
            ],


        ];

        $payment = Flutterwave::initializePayment($data);



        if ($payment['status'] !== 'success') {
            // notify something went wrong
            return 'sometjjj';
        }

        return response()->json($payment['data']['link']);
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

        dd($data);
        }
        elseif ($status ==  'cancelled'){
            //Put desired action/code after transaction has been cancelled here
        }
        else{
            //Put desired action/code after transaction has failed here
        }
        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your success page else, continue
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (including parameters that didn't exist before the transaction is completed. for audit purposes)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here

    }

    // public function initialize()
    // {

    //       $reference = Flutterwave::generateReference();
    //       $details = [
    //         "account_bank" => "MPS",
    //         "account_number" => "256751547654",
    //         "amount" => 1200,
    //         "currency" => "UGX",
    //         "debit_currency" => "UGX",
    //         "narration" => "Payment for things",
    //         'reference' => $reference,
    //         "callback_url" => route('callback'),
    //         "beneficiary_name" => "Golden",
    //         "meta" => [
    //           "sender"=> "Flutterwave Developers",
    //           "sender_country" =>"UG",
    //           "mobile_number"=>"256757856789"
    //         ]
    //       ];
    //       $transfer = Flutterwave::transfers()->initiate($details);
    //       dd($transfer);
    // }

    // public function webhook(Request $request)
    // {
    //   //This verifies the webhook is sent from Flutterwave
    //   $verified = Flutterwave::verifyWebhook();

    //   // if it is a charge event, verify and confirm it is a successful transaction
    //   if ($verified && $request->event == 'charge.completed' && $request->data->status == 'successful') {
    //       $verificationData = Flutterwave::verifyPayment($request->data['id']);
    //       if ($verificationData['status'] === 'success') {
    //         dd('ys');

    //       }

    //   }

    //   // if it is a transfer event, verify and confirm it is a successful transfer
    //   if ($verified && $request->event == 'transfer.completed') {

    //       $transfer = Flutterwave::transfers()->fetch($request->data['id']);

    //       if($transfer['data']['status'] === 'SUCCESSFUL') {
    //           // update transfer status to successful in your db
    //           dd('an');
    //       } else if ($transfer['data']['status'] === 'FAILED') {
    //           // update transfer status to failed in your db
    //           // revert customer balance back
    //           dd('no');
    //       } else if ($transfer['data']['status'] === 'PENDING') {
    //           // update transfer status to pending in your db
    //           dd('pe');
    //       }

    //   }
    // }

    // /**
    //  * Obtain Rave callback information
    //  * @return void
    //  */

    //  public function callback()
    // {

    //     $status = request()->status;

    //     //if payment is successful
    //     if ($status ==  'successful') {

    //     $transactionID = Flutterwave::getTransactionIDFromCallback();
    //     $data = Flutterwave::verifyTransaction($transactionID);
    //     dd($data);


    //     }
    //     elseif ($status ==  'cancelled'){
    //         //Put desired action/code after transaction has been cancelled here
    //     }
    //     else{
    //         //Put desired action/code after transaction has failed here
    //     }
    //     // Get the transaction from your DB using the transaction reference (txref)
    //     // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
    //     // Confirm that the currency on your db transaction is equal to the returned currency
    //     // Confirm that the db transaction amount is equal to the returned amount
    //     // Update the db transaction record (including parameters that didn't exist before the transaction is completed. for audit purpose)
    //     // Give value for the transaction
    //     // Update the transaction to note that you have given value for the transaction
    //     // You can also redirect to your success page from here

    // }
}
