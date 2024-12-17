<?php

namespace App\Http\Controllers;

use App\Models\platform;
use App\Models\price;
use App\Models\product;
use App\Models\sumberTransaksi;
use App\Models\variance;
use Illuminate\Http\Request;

class hargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $prices=price::indexPrice();
            return view('Menu.Harga.harga',compact('prices'));
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
            $products=product::indexProduk();
            $sumbers=sumberTransaksi::indexPlatform();
            $prices=price::where('deleted',false)->get();
            return response()->json([
                'products'=>$products,
                'sumbers'=>$sumbers,
                'prices'=>$prices
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }

    public function getFilter(){
        try {
            $variances=variance::where('deleted',false)->get();
            $platforms=platform::where('deleted',false)->get();
            $toko=sumberTransaksi::where('deleted',false)->get();

            return response()->json([
                'variances'=>$variances,
                'platforms'=>$platforms,
                'toko'=>$toko
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }

    public function FetchFilter(Request $request){
        try {
            $prices=price::indexPrice(idVarian:$request->varian,idToko:$request->toko,idPlatform:$request->platform);
            return response()->json([
                'prices'=>$prices
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
        $product=product::find($request->produk);
        $toko=sumberTransaksi::find($request->sumber);
        $kode=substr($toko->nama_sumber,0,2).substr($toko->nama_sumber,-1,1).$toko->id.$product->kode_produk;
        try {
            $price= new price();
            $price->id_toko=$request->sumber;
            $price->id_produk=$request->produk;
            $price->harga=$request->harga;
            $price->kode_toko=$kode;
            $price->save();

            $prices=price::indexPrice();
            return response()->json([
                'prices'=>$prices,
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
        $product=product::find($request->produk);
        $toko=sumberTransaksi::find($request->sumber);
        $kode=substr($toko->nama_sumber,0,2).substr($toko->nama_sumber,-1,1).$toko->id.$product->kode_produk;
        try {
            price::where('id',$request->id)->update([
                'id_produk'=>$request->produk,
                'id_toko'=>$request->sumber,
                'harga'=>$request->harga,
                'kode_toko'=>$kode
            ]);
            $prices=price::indexPrice();
            return response()->json([
                'prices'=>$prices,
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
            price::where('id',$request->id)->update([
                'deleted'=>true
            ]);
            $prices=price::indexPrice();
            return response()->json([
                'prices'=>$prices,
                'message'=>"Data Berhasil Ditambahkan"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }
}
