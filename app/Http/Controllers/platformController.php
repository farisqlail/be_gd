<?php

namespace App\Http\Controllers;

use App\Models\platform;
use Illuminate\Http\Request;

class platformController extends Controller
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
            $platform = new platform();
            $platform->nama_platform=$request->platform;
            $platform->save();
            $platforms=platform::where('deleted',false)->get();
            return response()->json([
                'platforms'=>$platforms,
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
            platform::where('id',$request->id)->update([
                'nama_platform'=>$request->platform
            ]);
            $platforms=platform::where('deleted',false)->get();
            return response()->json([
                'platforms'=>$platforms,
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
            platform::where('id',$request->id)->update([
                'deleted'=>true
            ]);
            $platforms=platform::where('deleted',false)->get();
            return response()->json([
                'platforms'=>$platforms,
                'message'=>"Data Berhasil Dihapus"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }
}
