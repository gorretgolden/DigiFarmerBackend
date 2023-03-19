<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Http\Requests\API\TransactionRequest;
use App\Http\Requests\API\ValidateChargeRequest;
use App\Services\TransactionService;

class CollectionController extends Controller
{


    public function collect(TransactionRequest $transactionRequest){
        $transactionService = new TransactionService;
        $response = $transactionService->transRequest($transactionRequest);
        return response()->json($response);
    }


    public function validateCharge(ValidateChargeRequest $validateChargeRequest){
        $transactionService = new TransactionService;
        $response = $transactionService->validateRequest($validateChargeRequest);
        return response()->json($response);
    }


    public function transactions(){
        $transactionService = new TransactionService;
        $response = $transactionService->transactions();
        return response()->json($response);
    }

    public function verifyTransaction($transactionId){
        $transactionService = new TransactionService;
        $response = $transactionService->transactionVerify($transactionId);
        return response()->json($response);
    }

    public function resendTransaction($transactionId){
        $transactionService = new TransactionService;
        $response = $transactionService->transactionResend($transactionId);
        return response()->json($response);
    }

    public function refundTransaction($transactionId){
        $transactionService = new TransactionService;
        $response = $transactionService->transactionRefund($transactionId);
        return response()->json($response);
    }

    public function saveTransaction(Request $request){
        $data = $request->all();

        if($data){
        $transactions = new Transactions();
        $transactions->tx_ref = $data['data']['tx_ref'];
        $transactions->flw_ref = $data['data']['flw_ref'];
        $transactions->amount = $data['data']['amount'];
        $transactions->trans_id = $data['data']['id'];
        $transactions->currency = $data['data']['currency'];
        $transactions->charged_amount = $data['data']['charged_amount'];
        $transactions->app_fee = $data['data']['app_fee'];
        $transactions->merchant_fee = $data['data']['merchant_fee'];
        $transactions->auth_model = $data['data']['auth_model'];
        $transactions->status = $data['data']['status'];
        $transactions->payment_type = $data['data']['payment_type'];
        $transactions->phone_number = $data['data']['customer']['phone_number'];
        $transactions->email = $data['data']['customer']['email'];
        $transactions->name = $data['data']['customer']['name'];
        $transactions->save();
        }else{
            abort(404);
        }
    }


}
