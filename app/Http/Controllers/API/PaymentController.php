<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\services\XenditService;

class PaymentController extends Controller
{
    protected $xenditService;

    public function __construct(XenditService $xenditService)
    {
        $this->xenditService = $xenditService;
    }

    public function createInvoice(Request $request)
    {
        $validated = $request->validate([
            'external_id' => 'required|string',
            'amount' => 'required|numeric|min:10000',
            'id_price' => 'required|integer',
            'id_promo' => 'integer',
            'customer_name' => 'required|string',
            'email_customer' => 'required|string',
            'phone_customer' => 'required|string',
            'transaction_code' => 'required|string',
            'payment_status' => 'nullable|string',
        ]);

        try {
            $invoice = $this->xenditService->createInvoice([
                'external_id' => $validated['external_id'],
                'amount' => $validated['amount'],
                'success_redirect_url' => 'http://localhost:3002/success',
            ]);

            $amount = $invoice['amount'];
            $statusPayment = 'PENDING';

            Checkout::insert([
                'amount' => $amount,
                'id_price' => $validated['id_price'],
                'id_user' => $request->get('id_user'),
                'id_promo' => $validated['id_promo'],
                'customer_name' => $validated['customer_name'],
                'email_customer' => $validated['email_customer'],
                'phone_customer' => $validated['phone_customer'],
                'transaction_code' => $validated['transaction_code'],
                'payment_status' => $statusPayment,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Checkout created and invoice generated successfully.',
                'invoice' => $invoice,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function checkPaymentStatus(Request $request)
    {
        // Validasi input dari request
        $validated = $request->validate([
            'transaction_code' => 'required|string',
        ]);

        try {
            $checkout = Checkout::where('transaction_code', $validated['transaction_code'])->first();
            if (!$checkout) {
                return response()->json(['success' => false, 'message' => 'Transaction not found'], 404);
            }

            if ($checkout->payment_status === 'PENDING') {
                return response()->json([
                    'success' => true,
                    'message' => 'Payment status is pending',
                    'payment_status' => $checkout->payment_status,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment status is not pending',
                    'payment_status' => $checkout->payment_status,
                ], 200);
            }
        } catch (\Exception $e) {
            // Menangani error jika terjadi exception
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function handleXenditCallback(Request $request)
    {
        try {
            $data = $request->all();

            if (!isset($data['external_id'], $data['status'])) {
                return response()->json(['success' => false, 'message' => 'Invalid callback data'], 400);
            }

            $checkout = Checkout::where('transaction_code', $data['external_id'])->first();

            if (!$checkout) {
                return response()->json(['success' => false, 'message' => 'Transaction not found'], 404);
            }

            $statusPayment = strtoupper($data['status']);

            if ($statusPayment === 'PAID' && $checkout->payment_status !== 'PAID') {
                $checkout->update([
                    'payment_status' => $statusPayment,
                    'updated_at' => now(),
                ]);

                $customer = Customer::where('email', $checkout->email_customer)->first();

                if ($customer) {
                    $customer->point += 50;
                    $customer->save();
                }
            }

            return response()->json(['success' => true, 'message' => 'Payment status updated'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function historyTransaction() {}
}
