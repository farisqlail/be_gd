<?php

namespace App\Http\Controllers;

use App\Models\payment_method;
use Illuminate\Http\Request;
// use Xendit\Configuration;
// use Xendit\PaymentRequest\PaymentRequestApi;
// use Xendit\PaymentRequest\PaymentRequestParameters;

class paymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $payment = new payment_method();
            $payment->nama_payment=$request->payment;
            $payment->save();

            $payments=payment_method::where('deleted',false)->get();
            return response()->json([
                'payments'=>$payments,
                'message'=>"Data Berhasil Ditambahkan"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            payment_method::where('id',$request->id)->update([
                'nama_payment'=>$request->payment
            ]);

            $payments=payment_method::where('deleted',false)->get();
            return response()->json([
                'payments'=>$payments,
                'message'=>"Data Berhasil Diupdate"
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            payment_method::where('id',$request->id)->update([
                'deleted'=>true
            ]);

            $payments=payment_method::where('deleted',false)->get();
            return response()->json([
                'payments'=>$payments,
                'message'=>"Data Berhasil Dihapus"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }

    // public function __construct()
    // {
    //     // Set Xendit API key
    //     Configuration::setXenditKey(env('XENDIT_API_KEY'));
    // }

    // public function createPaymentRequest(Request $request)
    // {
    //     try {
    //         // Initialize Xendit Payment API instance
    //         $apiInstance = new PaymentRequestApi();

    //         // Prepare payment request parameters
    //         $payment_request_parameters = new PaymentRequestParameters([
    //             'reference_id' => $request->input('reference_id'),
    //             'amount' => $request->input('amount'),
    //             'currency' => $request->input('currency', 'IDR'),
    //             'country' => $request->input('country', 'ID'),
    //             'payment_method' => [
    //                 'type' => 'EWALLET',
    //                 'ewallet' => [
    //                     'channel_code' => $request->input('channel_code'),
    //                     'channel_properties' => [
    //                         'success_return_url' => $request->input('success_return_url')
    //                     ]
    //                 ],
    //                 'reusability' => $request->input('reusability', 'ONE_TIME_USE')
    //             ]
    //         ]);

    //         // Call Xendit API to create the payment request
    //         $result = $apiInstance->createPaymentRequest(
    //             $request->input('idempotency_key'),
    //             $request->input('for_user_id'),
    //             $request->input('with_split_rule'),
    //             $payment_request_parameters
    //         );

    //         return response()->json([
    //             'message' => 'Payment request created successfully!',
    //             'data' => $result
    //         ], 200);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Error: ' . $e->getMessage()
    //         ], 400);
    //     }
    // }
}
