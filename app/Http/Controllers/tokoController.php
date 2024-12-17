<?php

namespace App\Http\Controllers;

use App\Models\platform;
use App\Models\sumberTransaksi;
use Illuminate\Http\Request;

class tokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $platforms=platform::where('deleted',false)->get();
        $toko=sumberTransaksi::indexPlatform();
        return view('Menu.SumberTransaksi.toko',compact('platforms','toko'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $platforms=platform::where('deleted',false)->get();
            $sumbers=sumberTransaksi::where('deleted',false)->get();
            return response()->json([
                'platforms'=>$platforms,
                'sumbers'=>$sumbers
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
        try {
            $toko = new sumberTransaksi();
            $toko->id_platform=$request->platform;
            $toko->nama_sumber=$request->toko;
            $toko->save();

            $sumbers=sumberTransaksi::indexPlatform();
            return response()->json([
                'sumbers'=>$sumbers,
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
            sumberTransaksi::where('id',$request->id)->update([
                'id_platform'=>$request->platform,
                'nama_sumber'=>$request->toko,
            ]);
            $sumbers=sumberTransaksi::indexPlatform();
            return response()->json([
                'sumbers'=>$sumbers,
                'message'=>"Data Berhasil Ditambahkan"
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
            sumberTransaksi::where('id',$request->id)->update([
                'deleted'=>true
            ]);
            $sumbers=sumberTransaksi::indexPlatform();
            return response()->json([
                'sumbers'=>$sumbers,
                'message'=>"Data Berhasil Ditambahkan"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }
}
