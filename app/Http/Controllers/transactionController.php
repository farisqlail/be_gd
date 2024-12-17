<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\detail_transaction;
use App\Models\detailAkun;
use App\Models\payment_method;
use App\Models\platform;
use App\Models\price;
use App\Models\product;
use App\Models\sumberTransaksi;
use App\Models\transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class transactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $transaksi=transaction::indexTransaction();
            $payments=payment_method::where('deleted',false)->get();
            return view('Menu.Transaksi.transaksi',compact('transaksi','payments'));
            //code...
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        try {
            $platform=platform::where('deleted',false)->get();
            $payment=payment_method::where('deleted',false)->get();
            return response()->json([
                'platforms'=>$platform,
                'payments'=>$payment,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }

    public function fetchSumber(Request $request){
        try {
            $sumber=sumberTransaksi::where('id_platform',$request->query('id_platform'))->get();
            return response()->json([
                'sumbers'=>$sumber
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }

    public function fetchProduk(Request $request){
        try {
            $products=price::indexPrice(idToko:$request->query('id_toko'));
            return response()->json([
                'products'=>$products,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }

    public function updateStatus(Request $request){
            transaction::where('id',$request->id)->update([
                'status' => $request->status
            ]);

            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }
    public function fetchLastTransaction(Request $request){
        try {
            $nomorFormat="";
            $wa=$request->query('wa');
            if (substr($wa, 0, 1) == '0') {
                $trim_nomor = substr($wa, 1, 15);
                $nomorFormat = 62 . $trim_nomor;
            } elseif (substr($request->wa, 0, 1) == '8') {
                $nomorFormat = 62 . $wa;
            } else {
                $nomorFormat = str_replace(['+', ' ', '-'], '', $wa);
            }
            $lastTransaction=transaction::where('wa',$nomorFormat)->orderBy('created_at','desc')->first();
            return response()->json([
                'nama_customer'=>$lastTransaction->nama_customer,
                'created_at'=>$lastTransaction->created_at
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->all();
        $nomorFormat="";
        $berakhir=date("Y-m-d");
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
                $transaksi->id_user=Auth::user()->id;
                $transaksi->id_price=$data['produk'][$key];
                $transaksi->id_payment=$request->payment;
                $transaksi->nama_customer=$request->customer;
                $transaksi->status_pembayaran=$request->status_bayar;
                $transaksi->kode_transaksi=$request->kode;
                $transaksi->tanggal_pembelian=date("Y-m-d");

                $produks=price::indexPrice(idPrice:$data['produk'][$key]);
                if ($produks[0]->ket_durasi=="Hari") {
                    $berakhir=date("Y-m-d",strtotime('+'.$produks[0]->durasi.' day',strtotime(date('Y-m-d'))));
                } elseif ($produks[0]->ket_durasi=="Bulan") {
                    $berakhir=date("Y-m-d",strtotime('+'.$produks[0]->durasi.' month',strtotime(date('Y-m-d'))));
                }

                $link_wa = 'https://api.whatsapp.com/send?phone=' . $nomorFormat . '&text=%0A%0AApakah%20Benar%20Kakak%20melakukan%20Pembelian%20' . $produks[0]->detail . '%3F';
                $transaksi->tanggal_berakhir=$berakhir;
                $transaksi->harga=$data['harga'][$key];
                $transaksi->wa=$nomorFormat;
                $transaksi->status=0;
                $transaksi->link_wa=$link_wa;
                if ($request->promo) {
                    $transaksi->promo=$request->promo;
                }
                $transaksi->save();
            }

            $transaksi=transaction::indexTransaction();
            return response()->json([
                'transactions'=>$transaksi,
                'message'=>"Data Berhasil Ditambahkan"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }

    public function provideAkun(Request $request){
        try {
            transaction::where('id',$request->id)->update([
                'status'=>1,
            ]);
            $detailAkuns=detailAkun::find($request->profile);
            detailAkun::where('id',$request->profile)->update([
                'jumlah_pengguna'=>$detailAkuns->jumlah_pengguna+1
            ]);

            $akuns=akun::find($request->akun);
            akun::where('id',$request->akun)->update([
                'jumlah_pengguna'=>$akuns->jumlah_pengguna+1
            ]);
            $detailTransaction=new detail_transaction();
            $detailTransaction->id_transaksi=$request->id;
            $detailTransaction->id_detail_akun=$request->profile;
            $detailTransaction->save();
            $transaksi=transaction::indexTransaction();
            return response()->json([
                'transactions'=>$transaksi,
                'message'=>"Data Berhasil Ditambahkan"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error'=>$th->getMessage()
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
        $id_transaksi=$request->query('id_trans');
        try {
            $platform=platform::where('deleted',false)->get();
            $payment=payment_method::where('deleted',false)->get();
            $transaction=transaction::indexTransaction($id_transaksi);
            $sumbers=sumberTransaksi::where('id_platform',$transaction[0]->id_platform)->get();
            $prices=price::indexPrice(idToko:$transaction[0]->id_toko);
            return response()->json([
                'platforms'=>$platform,
                'payments'=>$payment,
                'transactions'=>$transaction,
                'sumbers'=>$sumbers,
                'products'=>$prices
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $nomorFormat="";
        $berakhir=date("Y-m-d");
        if (substr($request->wa, 0, 1) == '0') {
            $trim_nomor = substr($request->wa, 1, 15);
            $nomorFormat = 62 . $trim_nomor;
        } elseif (substr($request->wa, 0, 1) == '8') {
            $nomorFormat = 62 . $request->wa;
        } else {
            $nomorFormat = str_replace(['+', ' ', '-'], '', $request->wa);
        }
        try {
            $produks=price::indexPrice(idPrice:$request->produk);
            if ($produks[0]->ket_durasi=="Hari") {
                $berakhir=date("Y-m-d",strtotime('+'.$produks[0]->durasi.' day',strtotime(date('Y-m-d'))));
            } elseif ($produks[0]->ket_durasi=="Bulan") {
                $berakhir=date("Y-m-d",strtotime('+'.$produks[0]->durasi.' month',strtotime(date('Y-m-d'))));
            }
            $link_wa = 'https://api.whatsapp.com/send?phone=' . $nomorFormat . '&text=%0A%0AApakah%20Benar%20Kakak%20melakukan%20Pembelian%20' . $produks[0]->detail . '%3F';

            transaction::where('id',$request->id)->update([
                'id_user'=>$request->user,
                'id_price'=>$request->produk,
                'id_payment'=>$request->payment,
                'nama_customer'=>$request->customer,
                'status_pembayaran'=>$request->status_bayar,
                'kode_transaksi'=>$request->kode,
                'tanggal_berakhir'=>$berakhir,
                'harga'=>$request->harga,
                'wa'=>$nomorFormat,
                'link_wa'=>$link_wa,
            ]);

            $transaksi=transaction::indexTransaction();
            return response()->json([
                'transactions'=>$transaksi,
                'message'=>"Data Berhasil Di update"
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
    public function destroy(string $id)
    {
        //
    }

    public function fetchAkun(Request $request){
        try {
            $id_transaksi=$request->query('id_trans');
            $id_produk=$request->query('id_produk');
            $transaction=transaction::indexTransaction(idTransaksi:$id_transaksi);
            $akun=akun::fetchAkun($id_produk);

            return response()->json([
                'transaksi'=>$transaction,
                'akuns'=>$akun
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error'=>$th->getMessage()
            ]);
        }

    }
    public function fetchDetailAkun(Request $request){
        try {
            $id_akun=$request->query('id_akun');
            $akun=detailAkun::where('id_akun',$id_akun)->get();
            return response()->json([
                'details'=>$akun
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error'=>$th->getMessage()
            ]);
        }

    }
}
