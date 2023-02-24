<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException as ClientRequestException;
use Illuminate\Support\Facades\Http;


/**
 * Payment Service
 *
 * @author nico_walter
 */
class PaymentService
{

    function __construct()
    {
        $this->baseUrl = config("gateways.wave.url");
        $this->secretKey = config("gateways.wave.secret_key");
    }


    public function transferRequest($validatedData)
    {
        return $this->doTransfer($validatedData);
    }

    public function transfers()
    {
        return $this->fetchTransfers();
    }

    /**
     * initiate a transfer
     */
    private function doTransfer($bodyData)
    {

        $headers = array(
            'Authorization' => "Bearer " . $this->secretKey,
        );

        try {
            $uri = "{$this->baseUrl}"."/transfers";
            $response = Http::withHeaders($headers)->withOptions(["verify" => false])->retry(3, 100)->post($uri, ['currency' => $bodyData->currency,
            'account_bank' => $bodyData->account_bank,
            'account_number' =>$bodyData->account_number,
            'amount' => $bodyData->amount,
            'narration' =>$bodyData->narration,
            'reference' =>$bodyData->reference,
            'beneficiary_name' =>$bodyData->beneficiary_name,
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
     * method to fetch all transfers
     */
    private function fetchTransfers()
    {
        $headers = array(
            'Authorization' => "Bearer " . $this->secretKey,
        );

        try {
            $uri = "{$this->baseUrl}"."transfers";
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




}
