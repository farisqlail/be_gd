<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\akun;
use App\Models\Checkout;
use App\Models\Customer;
use App\Models\detailAkun;
use App\Models\product;
use App\Models\transaction;
use Illuminate\Http\Request;
use App\services\XenditService;
use Illuminate\Support\Facades\Log;

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
                'email_customer' => $request->get('email_customer'),
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
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function handleXenditCallback(Request $request)
    {
        try {
            $data = $request->all();

            if (!isset($data['external_id'], $data['status'], $data['id_customer'])) {
                return response()->json(['success' => false, 'message' => 'Invalid callback data'], 400);
            }

            $checkout = Checkout::where('transaction_code', $data['transaction_code'])->first();

            if (!$checkout) {
                return response()->json(['success' => false, 'message' => 'Transaction not found'], 404);
            }

            $statusPayment = strtoupper($data['status']);
            $productCode = explode('#', $data['external_id'])[1] ?? null;
            $productCodeFix = '#' . $productCode;
            $product = Product::where('kode_produk', $productCodeFix)->first();

            if ($statusPayment === 'PAID' && $checkout->payment_status !== 'PAID') {
                $checkout->update([
                    'payment_status' => $statusPayment,
                    'updated_at' => now(),
                ]);

                if ($productCodeFix) {
                    if ($product) {
                        $akun = Akun::where('id_produk', $product->id)->first();

                        if ($akun) {
                            $akun->jumlah_pengguna = max(0, $akun->jumlah_pengguna - 1);
                            $akun->save();

                            $detailAkun = detailAkun::where('id_akun', $akun->id)->first();
                            if ($detailAkun) {
                                $detailAkun->jumlah_pengguna = max(0, $detailAkun->jumlah_pengguna + 1);
                                $detailAkun->save();
                            }

                            $customer = Customer::where('id', $data['id_customer'])->first();
                            if ($customer) {
                                $customer->point += 50;
                                $customer->id_akun = $akun->id;
                                $customer->save();
                            }
                        }
                    }
                }

                Transaction::create([
                    'id_user' => null,
                    'id_price' => $checkout->id_price,
                    'id_customer' => $data['id_customer'],
                    'id_payment' => null,
                    'nama_customer' => $checkout->customer_name,
                    'kode_transaksi' => $checkout->transaction_code,
                    'tanggal_pembelian' => now(),
                    'tanggal_berakhir' => now()->addDays(30),
                    'harga' => $checkout->amount,
                    'wa' => $checkout->phone_customer,
                    'status' => 'completed',
                    'link_wa' => "",
                    'status_pembayaran' => 'Lunas',
                    'promo' => $checkout->id_promo,
                ]);
            }

            $akunDetails = detailAkun::where('id_akun', $akun->id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Payment status updated and transaction recorded',
                'akun' => $akun,
                'detailAkun' => $akunDetails
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function historyTransaction($id)
    {
        try {
            $customer = Customer::with('akun')->find($id);

            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer not found.'
                ], 404);
            }

            $transactions = Transaction::where('id_customer', $id)
                ->with('customer.akun')
                ->orderBy('tanggal_pembelian', 'desc')
                ->get();

            if ($transactions->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No transactions found for this user.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'transactions' => $transactions,
                    'akun' => $customer->akun
                ],
                'message' => 'Transaction history retrieved successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
