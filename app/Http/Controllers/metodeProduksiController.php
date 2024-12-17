<?php

namespace App\Http\Controllers;

use App\Models\metode_produksi;
use Illuminate\Http\Request;

class metodeProduksiController extends Controller
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
            $metode=new metode_produksi();
            $metode->nama_metode=$request->metode;
            $metode->save();

            $metodes=metode_produksi::where('deleted',false)->get();
            return response()->json([
                'metode'=>$metodes,
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
            metode_produksi::where('id',$request->id)->update([
                'nama_metode'=>$request->metode
            ]);
            $metodes=metode_produksi::where('deleted',false)->get();
            return response()->json([
                'metode'=>$metodes,
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
            metode_produksi::where('id',$request->id)->update([
                'deleted'=>true
            ]);
            $metodes=metode_produksi::where('deleted',false)->get();
            return response()->json([
                'metode'=>$metodes,
                'message'=>"Data Berhasil Dihapus"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }
}
