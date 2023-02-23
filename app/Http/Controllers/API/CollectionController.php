<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

}
