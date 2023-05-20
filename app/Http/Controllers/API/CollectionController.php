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
    public function collect(TransactionRequest $transactionRequest)
    {
        $transactionService = new TransactionService();

        $data["phone_number"] = request()->phone_number;
        $data["amount"] = request()->amount;
        $data["pay_type"] = request()->pay_type;
        $data["payment_id"] = request()->payment_id;

        $resp = $transactionService->transRequest($data);
        $redirect_link = $resp["meta"]["authorization"]["redirect"];
        $response = [
            "status" => $resp["status"],
            "message" => $resp["message"],
            "redirect-link" => $redirect_link,
        ];

        if ($resp["status"] == "success") {
            return response()->json($response, 200);
        } else {
            $response = [
                "success" => false,
                "message" => "Something wrong happened",
            ];
            return response()->json($res, 400);
        }
    }

    public function validateCharge(ValidateChargeRequest $validateChargeRequest)
    {
        $transactionService = new TransactionService();
        $response = $transactionService->validateRequest(
            $validateChargeRequest
        );
        return response()->json($response);
    }

    public function transactions()
    {
        $transactionService = new TransactionService();
        $response = $transactionService->transactions();
        return response()->json($response);
    }

    public function verifyTransaction($transactionId)
    {
        $transactionService = new TransactionService();
        $response = $transactionService->transactionVerify($transactionId);
        return response()->json($response);
    }

    public function resendTransaction($transactionId)
    {
        $transactionService = new TransactionService();
        $response = $transactionService->transactionResend($transactionId);
        return response()->json($response);
    }

    public function refundTransaction($transactionId)
    {
        $transactionService = new TransactionService();
        $response = $transactionService->transactionRefund($transactionId);
        return response()->json($response);
    }

    public function saveTransaction(Request $request)
    {
        $data = $request->all();

        if ($data) {
            $token = $data["data"]["tx_ref"];
            $decoded = base64_decode($token);
            $tokenDetails = explode(".", $decoded);

            $transactions = new Transactions();
            $transactions->trans_id = $data["data"]["trans_id"];
            $transactions->tx_ref = $data["data"]["tx_ref"];
            $transactions->flw_ref = $data["data"]["flw_ref"];
            $transactions->amount = $data["data"]["amount"];
            $transactions->trans_id = $data["data"]["id"];
            $transactions->currency = $data["data"]["currency"];
            $transactions->charged_amount = $data["data"]["charged_amount"];
            $transactions->app_fee = $data["data"]["app_fee"];
            $transactions->merchant_fee = $data["data"]["merchant_fee"];
            $transactions->auth_model = $data["data"]["auth_model"];
            $transactions->status = $data["data"]["status"];
            $transactions->payment_type = $data["data"]["payment_type"];
            $transactions->phone_number =
                $data["data"]["customer"]["phone_number"];
            $transactions->email = $data["data"]["customer"]["email"];
            $transactions->name = $data["data"]["customer"]["name"];
            $transactions->user_id = $tokenDetails[2];
            $transactions->pay_type = $tokenDetails[3];
            $transactions->payment_id = $tokenDetails[4];
            $transactions->save();
        } else {
            abort(404);
        }
    }
}
