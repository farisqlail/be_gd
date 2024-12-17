<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Xendit\Configuration;
use Xendit\PaymentRequest\PaymentRequestApi;
use Xendit\PaymentRequest\PaymentRequestParameters;

class paymentRequestController extends Controller
{
    # E-Wallet One Time Payment via Redirect URL
    public function eWallet(){
        try {
            Configuration::setXenditKey(env('XENDIT_API_KEY'));
            $apiInstance = new PaymentRequestApi();
            $idempotency_key = "5f9a3fbd571a1c4068aa40ce"; // string
            $for_user_id = "5f9a3fbd571a1c4068aa40cf"; // string
            $with_split_rule = "splitru_c676f55d-a9e0-47f2-b672-77564d57a40b"; // string
            $payment_request_parameters = new PaymentRequestParameters([
              'reference_id' => 'example-ref-1234',
              'amount' => 15000,
              'currency' => 'IDR',
              'country' => 'ID',
              'payment_method' => [
                'type' => 'EWALLET',
                'ewallet' => [
                  'channel_code' => 'SHOPEEPAY',
                  'channel_properties' => [
                    'success_return_url' => '/'
                  ]
                ],
                'reusability' => 'ONE_TIME_USE'
              ]
            ]);

            try {
                $result = $apiInstance->createPaymentRequest($idempotency_key, $for_user_id, $with_split_rule, $payment_request_parameters);
                    print_r($result);
            } catch (\Xendit\XenditSdkException $e) {
                echo 'Exception when calling PaymentRequestApi->createPaymentRequest: ', $e->getMessage(), PHP_EOL;
                echo 'Full Error: ', json_encode($e->getFullError()), PHP_EOL;
            }
            //code...
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
   }
}
