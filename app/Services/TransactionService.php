<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException as ClientRequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


/**
 * Transaction Service
 *
 * @author nico_walter
 */
class TransactionService
{

    function __construct()
    {
        $this->baseUrl = config("gateways.wave.url");
        $this->secretKey = config("gateways.wave.secret_key");
    }


    public function transRequest($validatedData)
    {
        return $this->doTransactionHttp($validatedData);
    }




    public function validateRequest($validatedData)
    {
        return $this->validateTransaction($validatedData);
    }

    public function transactions()
    {
        return $this->fetchTransactions();
    }

    public function transactionVerify($id)
    {
        return $this->verifyTransaction($id);
    }
    public function transactionResend($id)
    {
        return $this->resendTransaction($id);
    }
    public function transactionRefund($id)
    {
        return $this->refundTransaction($id);
    }


    public function transRequestStatus($referenceId, $mode)
    {
        $authentication = $this->getCredentials($mode);

        return $this->getTransStatusViaHttp($authentication, $referenceId, $this->urls[$mode]);
    }

    /**
     * initiate a collection/charge
     */
    private function doTransactionHttp($bodyData)
    {

        $headers = array(
            'Authorization' => "Bearer " . $this->secretKey,
        );

        try {
            $uri = "{$this->baseUrl}"."/charges?type=mobile_money_uganda";
            $response = Http::withHeaders($headers)->withOptions(["verify" => false])->retry(3, 100)->post($uri, ['amount' => $bodyData['amount'],
            'tx_ref' => base64_encode(auth()->user()->email . "." .auth()->user()->id . "." .$bodyData['pay_type'] . "." . $bodyData['payment_id']),
            'currency' =>"UGX",
            'phone_number' => $bodyData['phone_number'],
            'email' =>  auth()->user()->email,
            'fullname' => auth()->user()->username,
        ],);



            if($response->status() == 200){

                return $response->json();
            }
            else {
                return ["statusCode" => $response->status(), "message" => "Request failed"];
            }

        } catch (ClientRequestException $reqException) {
            return ["statusCode" => 500, "message" => $reqException->getMessage()];
        }
    }


    /**
     * validate transactions
     */
    private function validateTransaction($bodyData)
    {

        $headers = array(
            'Authorization' => "Bearer " . $this->secretKey,
        );

        try {
            $uri = "{$this->baseUrl}"."/validate-charge";
            $response = Http::withHeaders($headers)->withOptions(["verify" => false])->retry(3, 100)->post($uri, ['flw_ref' => $bodyData->flw_ref,
            'otp' => $bodyData->otp]);

            if($response->status() == 200){
                return $response->json();
            }
            else {
                return ["statusCode" => $response->status(), "message" => "Request failed"];
            }

        } catch (ClientRequestException $reqException) {
            return ["statusCode" => 500, "message" => $reqException->getMessage()];
        }
    }

    /**
     * method to fetch all transactions initiated
     */
    private function fetchTransactions()
    {

        $headers = array(
            'Authorization' => "Bearer " . $this->secretKey,
        );

        try {
            $uri = "{$this->baseUrl}"."/transactions";
            $response = Http::withHeaders($headers)->withOptions(["verify" => false])->retry(3, 100)->get($uri);

            if($response->status() == 200){
                return $response->json();
            }
            else {
                return ["statusCode" => $response->status(), "message" => "Request failed"];
            }

        } catch (ClientRequestException $reqException) {
            return ["statusCode" => 500, "message" => $reqException->getMessage()];
        }
    }


    /**
     * method to verify a specific transaction
     */
    private function verifyTransaction($transactionId)
    {
        $headers = array(
            'Authorization' => "Bearer " . $this->secretKey,
        );

        try {
            $uri = "{$this->baseUrl}"."transactions/".$transactionId."/verify";
            $response = Http::withHeaders($headers)->withOptions(["verify" => false])->retry(3, 100)->get($uri);

            if($response->status() == 200){
                return $response->json();
            }
            else {
                return ["statusCode" => $response->status(), "message" => "Request failed"];
            }

        } catch (ClientRequestException $reqException) {
            return ["statusCode" => 500, "message" => $reqException->getMessage()];
        }
    }


    /**
     * resend failed  transactions
     */
    private function resendTransaction($transactionId)
    {
        $headers = array(
            'Authorization' => "Bearer " . $this->secretKey,
        );

        try {
            $uri = "{$this->baseUrl}"."transactions/".$transactionId."/resend-hook";
            $response = Http::withHeaders($headers)->withOptions(["verify" => false])->retry(3, 100)->post($uri);

            if($response->status() == 200){
                return $response->json();
            }
            else {
                return ["statusCode" => $response->status(), "message" => "Request failed"];
            }

        } catch (ClientRequestException $reqException) {
            return ["statusCode" => 500, "message" => $reqException->getMessage()];
        }
    }

    /**
     * refund   transaction
     */
    private function refundTransaction($transactionId)
    {
        $headers = array(
            'Authorization' => "Bearer " . $this->secretKey,
        );

        try {
            $uri = "{$this->baseUrl}"."transactions/".$transactionId."/refund";
            $response = Http::withHeaders($headers)->withOptions(["verify" => false])->retry(3, 100)->post($uri);

            if($response->status() == 200){
                return $response->json();
            }
            else {
                return ["statusCode" => $response->status(), "message" => "Request failed"];
            }

        } catch (ClientRequestException $reqException) {
            return ["statusCode" => 500, "message" => $reqException->getMessage()];
        }
    }

}
