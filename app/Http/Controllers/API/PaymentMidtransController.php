<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Transaction as AppTransaction;

class PaymentMidtransController extends Controller
{
    public function __construct()
    {
        // Configure Midtrans  
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createPayment(Request $request)
    {
        // Validate incoming request  
        $request->validate([
            'amount' => 'required|numeric',
            'customer_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            // Add other necessary fields  
        ]);

        // Create transaction data  
        $transactionData = [
            'transaction_details' => [
                'order_id' => uniqid(), // Generate a unique order ID  
                'gross_amount' => $request->amount, // Amount to be charged  
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ],
            // Add other necessary fields like item details, etc.  
        ];
        // Create a payment request  
        try {
            $snapToken = Snap::getSnapToken($transactionData);
            return response()->json(['success' => true, 'snap_token' => $snapToken], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function handleCallback(Request $request)
    {
        // Handle the callback from Midtrans  
        $json = $request->getContent();
        $data = json_decode($json, true);

        // Process the payment notification  
        if ($data['transaction_status'] == 'settlement') {
            // Update your transaction status in the database  
            $transaction = AppTransaction::where('kode_transaksi', $data['order_id'])->first();
            if ($transaction) {
                $transaction->update(['status' => 'completed']);
            }
        }

        return response()->json(['success' => true]);
    }
}
