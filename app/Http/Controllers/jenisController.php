<?php

namespace App\Http\Controllers;

use App\Models\product_type;
use Illuminate\Http\Request;

class jenisController extends Controller
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
            $type= new product_type();
            $type->type_name=$request->jenis;
            $type->save();

            $types=product_type::where('deleted',false)->get();
            return response()->json([
                'types'=>$types,
                'message'=>'Data Berhasil Ditambahkan'
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
            product_type::where('id',$request->id)->update([
                'type_name'=>$request->jenis
            ]);
            $types=product_type::where('deleted',false)->get();
            return response()->json([
                'types'=>$types,
                'message'=>'Data Berhasil Diupdate'
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
            product_type::where('id',$request->id)->update([
                'deleted'=>true
            ]);
            $types=product_type::where('deleted',false)->get();
            return response()->json([
                'types'=>$types,
                'message'=>'Data Berhasil Dihapus'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }
}
