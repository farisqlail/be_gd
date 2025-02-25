<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\kode_akun;
use App\Models\Checkout;
use App\Models\detail_transaction;
use App\Models\detail_checkout;
use App\Models\detailAkun;
use App\Models\payment_method;
use App\Models\platform;
use App\Models\price;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Models\sumberTransaksi;
use App\Models\transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class transactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $transaksi = transaction::indexTransaction(idUser:Auth::user()->id);
            $payments = payment_method::where('deleted', false)->get();
            $idWA=User::findTimWA(Auth::user()->id);
            if ($idWA) {
                $checkouts=Checkout::indexCheckout(idWA:$idWA[0]->wa,status:1);
            } else {
                $checkouts=[];
            }
                return view('Menu.Transaksi.masterTransaksi', compact('transaksi', 'payments','checkouts'));
            //code...
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }
    
    public function indexHistory(Request $request)
    {
        try {
            // Fetch transactions with a status of 'completed'  
            $transactions = transaction::with(['price.product'])
                ->where('status_pembayaran', 'Lunas')
                ->orderBy('created_at', 'desc')
                ->get();

            $transactions = $transactions->map(function ($transaction) {
                return [
                    'id' => $transaction->id,
                    'nama_customer' => $transaction->nama_customer,
                    'wa' => $transaction->wa, // Include WhatsApp number  
                    'kode_transaksi' => $transaction->kode_transaksi,
                    'tanggal_pembelian' => $transaction->tanggal_pembelian,
                    'harga' => $transaction->harga,
                    'status' => $transaction->status,
                    'product_name' => $transaction->price->product->variance->variance_name ?? 'N/A',
                ];
            });

            return view('Menu.history.index', compact('transactions')); // Return the view with transactions  
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function indexTransactionPending()
    {
         $transactions = Checkout::where('payment_status', 'PENDING')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Menu.Transaksi.pending.index', compact('transactions'));
    }

    public function updateTransactionPending(Request $request, $id)
    {
        $checkout = Checkout::where('transaction_code', $id)->first();
            if ($checkout) {
                $checkout->payment_status = 'PAID';
                $checkout->save();
    
                $getAccount=Checkout::getAccount($id);
                $getKodeAkun=kode_akun::where('id_detail_akun',$getAccount[0]->id_detail_akun)->first();
                detail_checkout::create([
                    'id_checkout'=>$getAccount[0]->id_checkout,
                    'id_detail_akun'=>$getAccount[0]->id_detail_akun,
                    'keterangan'=>$getKodeAkun->kode
                ]);
    
                akun::where('id',$getAccount[0]->id_akun)->update([
                    'jumlah_pengguna'=>$getAccount[0]->qty_akun+1
                ]);
    
                detailAkun::where('id',$getAccount[0]->id_detail_akun)->update([
                    'jumlah_pengguna'=>$getAccount[0]->jumlah_pengguna+1
                ]);
                
                if ($checkout->created_at) {
                    try {
                        Transaction::create([
                            'id_user' => 1,
                            'id_price' => $checkout->id_price,
                            'id_customer' => $checkout->id_customer ? $checkout->id_customer : null,
                            'nama_customer' => $checkout->customer_name,
                            'kode_transaksi' => $getKodeAkun->kode,
                            'tanggal_pembelian' => $checkout->created_at,
                            'tanggal_berakhir' => $checkout->created_at->addDays(30), // Safely add days  
                            'harga' => $checkout->amount,
                            'wa' => $checkout->phone_customer,
                            'status' => 'Active',
                            'link_wa' => '',
                            'status_pembayaran' => 'Lunas',
                            'promo' => $checkout->id_promo ? $checkout->id_promo : 0,
                            'payment_method' => $checkout->payment_method,
                        ]);
                        
                        $customer = Customer::where('id', $checkout->id_customer ? $checkout->id_customer : null)->first();
                        if ($customer) {
                            $customer->point += 50;
                            $customer->save();
                        }
                        
                    } catch (\Exception $e) {
                        return redirect()->route('transactions.pending.index')->with('error', 'Failed to create transaction: ' . $e->getMessage());
                    }
                } else {
                    return redirect()->route('transactions.pending.index')->with('error', 'Created at timestamp is missing.');
                }
    
                return redirect()->route('transactions.pending.index')->with('success', 'Transaction updated successfully.');
            }
        
       

        return redirect()->route('transactions.pending.index')->with('error', 'Transaction not found.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        try {
            $platform = platform::where('deleted', false)->get();
            $payment = payment_method::where('deleted', false)->get();
            return response()->json([
                'platforms' => $platform,
                'payments' => $payment,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }

    public function fetchSumber(Request $request)
    {
        try {
            $sumber = sumberTransaksi::where('id_platform', $request->query('id_platform'))->get();
            $kode=Str::uuid()->toString();
            return response()->json([
                'sumbers' => $sumber,
                'kode'=>$kode
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }

    public function fetchProduk(Request $request)
    {
        try {
            $products = price::indexPrice(idToko: $request->query('id_toko'));
            return response()->json([
                'products' => $products,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }

    public function updateStatus(Request $request)
    {
        transaction::where('id', $request->id)->update([
            'status' => $request->status
        ]);

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }
   
    public function updateStatusCheckout(Request $request)
    {
        Checkout::where('id', $request->id)->update([
            'status' => $request->status
        ]);

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }
    public function fetchLastTransaction(Request $request)
    {
        try {
            $nomorFormat = "";
            $wa = $request->query('wa');
            if (substr($wa, 0, 1) == '0') {
                $trim_nomor = substr($wa, 1, 15);
                $nomorFormat = 62 . $trim_nomor;
            } elseif (substr($request->wa, 0, 1) == '8') {
                $nomorFormat = 62 . $wa;
            } else {
                $nomorFormat = str_replace(['+', ' ', '-'], '', $wa);
            }
            $lastTransaction = transaction::where('wa', $nomorFormat)->orderBy('created_at', 'desc')->first();
            return response()->json([
                'nama_customer' => $lastTransaction->nama_customer,
                'created_at' => $lastTransaction->created_at
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $nomorFormat = "";
        $berakhir = date("Y-m-d");
        if (substr($request->wa, 0, 1) == '0') {
            $trim_nomor = substr($request->wa, 1, 15);
            $nomorFormat = 62 . $trim_nomor;
        } elseif (substr($request->wa, 0, 1) == '8') {
            $nomorFormat = 62 . $request->wa;
        } else {
            $nomorFormat = str_replace(['+', ' ', '-'], '', $request->wa);
        }
        try {

            foreach ($data['produk'] as $key => $value) {
                $transaksi = new transaction();
                $transaksi->id_user = Auth::user()->id;
                $transaksi->id_price = $data['produk'][$key];
                $transaksi->id_payment = $request->payment;
                $transaksi->nama_customer = $request->customer;
                $transaksi->status_pembayaran = $request->status_bayar;
                $transaksi->kode_transaksi = $request->kode;
                $transaksi->tanggal_pembelian = date("Y-m-d");

                $produks = price::indexPrice(idPrice: $data['produk'][$key]);
                if ($produks[0]->ket_durasi == "Hari") {
                    $berakhir = date("Y-m-d", strtotime('+' . $produks[0]->durasi . ' day', strtotime(date('Y-m-d'))));
                } elseif ($produks[0]->ket_durasi == "Bulan") {
                    $berakhir = date("Y-m-d", strtotime('+' . $produks[0]->durasi . ' month', strtotime(date('Y-m-d'))));
                }

                $link_wa = 'https://api.whatsapp.com/send?phone=' . $nomorFormat . '&text=%0A%0AApakah%20Benar%20Kakak%20melakukan%20Pembelian%20' . $produks[0]->detail . '%3F';
                $transaksi->tanggal_berakhir = $berakhir;
                $transaksi->harga = $data['harga'][$key];
                $transaksi->wa = $nomorFormat;
                $transaksi->status = 0;
                $transaksi->link_wa = $link_wa;
                if ($request->promo) {
                    $transaksi->promo = $request->promo;
                }
                $transaksi->save();
            }

            $transaksi = transaction::indexTransaction(idUser:Auth::user()->id);
            return response()->json([
                'transactions' => $transaksi,
                'message' => "Data Berhasil Ditambahkan"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }

    public function provideAkun(Request $request)
    {
        try {
            transaction::where('id', $request->id)->update([
                'status' => 1,
            ]);
            $detailAkuns = detailAkun::find($request->profile);
            detailAkun::where('id', $request->profile)->update([
                'jumlah_pengguna' => $detailAkuns->jumlah_pengguna + 1
            ]);

            $akuns = akun::find($request->akun);
            akun::where('id', $request->akun)->update([
                'jumlah_pengguna' => $akuns->jumlah_pengguna + 1
            ]);
            $detailTransaction = new detail_transaction();
            $detailTransaction->id_transaksi = $request->id;
            $detailTransaction->id_detail_akun = $request->profile;
            $detailTransaction->save();
            $transaksi = transaction::indexTransaction(idUser:Auth::user()->id);
            return response()->json([
                'transactions' => $transaksi,
                'message' => "Data Berhasil Ditambahkan"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }
    
    public function provideAkunCheckout(Request $request)
    {
        try {
            Checkout::where('id', $request->id)->update([
                'status' => 2,
            ]);
            $detailAkuns = detailAkun::find($request->profile);
            detailAkun::where('id', $request->profile)->update([
                'jumlah_pengguna' => $detailAkuns->jumlah_pengguna + 1
            ]);

            $akuns = akun::find($request->akun);
            akun::where('id', $request->akun)->update([
                'jumlah_pengguna' => $akuns->jumlah_pengguna + 1
            ]);
            $detailTransaction = new detail_transaction();
            $detailTransaction->id_transaksi = $request->id;
            $detailTransaction->id_detail_akun = $request->profile;
            $detailTransaction->save();
            $checkouts=Checkout::indexCheckout(idWA:$idWA[0]->wa,status:1);
            return response()->json([
                'checkouts' => $checkouts,
                'message' => "Data Berhasil Ditambahkan"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
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
    public function edit(Request $request)
    {
        $id_transaksi = $request->query('id_trans');
        try {
            $platform = platform::where('deleted', false)->get();
            $payment = payment_method::where('deleted', false)->get();
            $transaction = transaction::indexTransaction($id_transaksi);
            $sumbers = sumberTransaksi::where('id_platform', $transaction[0]->id_platform)->get();
            $prices = price::indexPrice(idToko: $transaction[0]->id_toko);
            return response()->json([
                'platforms' => $platform,
                'payments' => $payment,
                'transactions' => $transaction,
                'sumbers' => $sumbers,
                'products' => $prices
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $nomorFormat = "";
        $berakhir = date("Y-m-d");
        if (substr($request->wa, 0, 1) == '0') {
            $trim_nomor = substr($request->wa, 1, 15);
            $nomorFormat = 62 . $trim_nomor;
        } elseif (substr($request->wa, 0, 1) == '8') {
            $nomorFormat = 62 . $request->wa;
        } else {
            $nomorFormat = str_replace(['+', ' ', '-'], '', $request->wa);
        }
        try {
            $produks = price::indexPrice(idPrice: $request->produk);
            if ($produks[0]->ket_durasi == "Hari") {
                $berakhir = date("Y-m-d", strtotime('+' . $produks[0]->durasi . ' day', strtotime(date('Y-m-d'))));
            } elseif ($produks[0]->ket_durasi == "Bulan") {
                $berakhir = date("Y-m-d", strtotime('+' . $produks[0]->durasi . ' month', strtotime(date('Y-m-d'))));
            }
            $link_wa = 'https://api.whatsapp.com/send?phone=' . $nomorFormat . '&text=%0A%0AApakah%20Benar%20Kakak%20melakukan%20Pembelian%20' . $produks[0]->detail . '%3F';

            transaction::where('id', $request->id)->update([
                'id_user' => $request->user,
                'id_price' => $request->produk,
                'id_payment' => $request->payment,
                'nama_customer' => $request->customer,
                'status_pembayaran' => $request->status_bayar,
                'kode_transaksi' => $request->kode,
                'tanggal_berakhir' => $berakhir,
                'harga' => $request->harga,
                'wa' => $nomorFormat,
                'link_wa' => $link_wa,
            ]);

            $transaksi = transaction::indexTransaction(idUser:Auth::user()->id);
            return response()->json([
                'transactions' => $transaksi,
                'message' => "Data Berhasil Di update"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $id=$request->query('id_trans');
            transaction::where('id',$id)->delete();
            $transaksi = transaction::indexTransaction(idUser:Auth::user()->id);
            return response()->json([
                'transactions' => $transaksi,
                'message' => "Data Berhasil Di Delete"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }

    public function fetchAkun(Request $request)
    {
        try {
            $id_transaksi = $request->query('id_trans');
            $id_produk = $request->query('id_produk');
            $transaction = transaction::indexTransaction(idTransaksi: $id_transaksi);
            $akun = akun::fetchAkun($id_produk);

            return response()->json([
                'transaksi' => $transaction,
                'akuns' => $akun
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }
    
    public function fetchAkunCheckout(Request $request)
    {
        try {
            $id_transaksi = $request->query('id_trans');
            $id_produk = $request->query('id_produk');
            $transaction = Checkout::indexCheckout(idTransaction: $id_transaksi);
            $akun = akun::fetchAkun($id_produk);

            return response()->json([
                'checkouts' => $transaction,
                'akuns' => $akun
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }
    public function fetchDetailAkun(Request $request)
    {
        try {
            $id_akun = $request->query('id_akun');
            $akun = detailAkun::where('id_akun', $id_akun)->get();
            return response()->json([
                'details' => $akun
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }
}
