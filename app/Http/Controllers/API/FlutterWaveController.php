<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\TransactionRequest;
use KingFlamez\Rave\Facades\Rave as Flutterwave;

class FlutterwaveController extends Controller
{
    public function collect(TransactionRequest $transactionRequest)
    {

        $tx_ref = Flutterwave::generateReference();
        $order_id = Flutterwave::generateReference('momo');

        $data = [
            'amount' => $transactionRequest->amount,
            'email' => $transactionRequest->user()->email,
            'redirect_url' => route('callback'),
            'phone_number' => $transactionRequest->phone_number,
            'tx_ref' => $tx_ref,
            'order_id' => $order_id
        ];

        $charge = Flutterwave::payments()->momoUG($data);

        return response()->json($charge);
    }

}
