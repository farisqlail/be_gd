<?php

namespace App\Http\Controllers;

use App\Models\variance;
use Illuminate\Http\Request;

class varianController extends Controller
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
            $variance= new variance();
            $variance->variance_name=$request->varian;
            $variance->save();
            $variances=variance::where('deleted',false)->get();
            return response()->json([
                'variances'=>$variances,
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
            variance::where('id',$request->id)->update([
                'variance_name'=>$request->varian
            ]);
            $variances=variance::where('deleted',false)->get();
            return response()->json([
                'variances'=>$variances,
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
            variance::where('id',$request->id)->update([
                'deleted'=>true
            ]);

            $variances=variance::where('deleted',false)->get();
            return response()->json([
                'variances'=>$variances,
                'message'=>"Data Berhasil Dihapus"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }
}
