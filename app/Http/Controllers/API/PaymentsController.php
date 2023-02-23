<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\PaymentRequest;
use App\Services\PaymentService;

class PaymentsController extends Controller
{

    public function transfer(PaymentRequest $paymentRequest){
        $paymentService = new PaymentService;
        $response = $paymentService->transferRequest($paymentRequest);
        return response()->json($response);
    }

    public function transfers(){
        $paymentService = new PaymentService;
        $response = $paymentService->transfers();
        return response()->json($response);
    }


}
