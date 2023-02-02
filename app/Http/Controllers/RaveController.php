<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use KingFlamez\Rave\Facades\Rave as Flutterwave;

use Rave;
class RaveController extends Controller{



     /**
     * Initialize Rave payment process
     * @return void
     */
    public function initialize()
    {
        $reference = Flutterwave::generateReference();
        $details = [
          "account_bank" => "MPS",
          "account_number" => "256757856789",
          "amount" => 120,
          "currency" => "UGX",
          "debit_currency" => "UGX",
          "narration" => "Payment for things",
          'reference' => $reference,
          "beneficiary_name" => "Golden",
          "meta" => [
            "sender"=> "Flutterwave Developers",
            "sender_country" =>"UG",
            "mobile_number"=>"256751547654"
          ]
        ];
        $transfer = Flutterwave::transfers()->initiate($details);
      dd($transfer);
    }


    public function webhook(Request $request)
    {
      //This verifies the webhook is sent from Flutterwave
      $verified = Flutterwave::verifyWebhook();

      // if it is a charge event, verify and confirm it is a successful transaction
      if ($verified && $request->event == 'charge.completed' && $request->data->status == 'successful') {
          $verificationData = Flutterwave::verifyPayment($request->data['id']);
          if ($verificationData['status'] === 'success') {
          // process for successful charge

          }

      }

      // if it is a transfer event, verify and confirm it is a successful transfer
      if ($verified && $request->event == 'transfer.completed') {

          $transfer = Flutterwave::transfers()->fetch($request->data['id']);

          if($transfer['data']['status'] === 'SUCCESSFUL') {
              // update transfer status to successful in your db
          } else if ($transfer['data']['status'] === 'FAILED') {
              // update transfer status to failed in your db
              // revert customer balance back
          } else if ($transfer['data']['status'] === 'PENDING') {
              // update transfer status to pending in your db
          }

      }
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
      //  dd($data);


        }
        elseif ($status ==  'cancelled'){
            //Put desired action/code after transaction has been cancelled here
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
