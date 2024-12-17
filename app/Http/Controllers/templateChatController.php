<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\templateChat;
use Illuminate\Http\Request;

class templateChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $templates=templateChat::indexTemplate();
            return view('Menu.TemplateChat.template',compact('templates'));
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
            $productsInput=templateChat::fetchProduct();
            $productsUpdate=templateChat::fetchProductAll();
            $templates=templateChat::all();
            return response()->json([
                'products'=>$productsInput,
                'products_update'=>$productsUpdate,
                'templates'=>$templates
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
            $template=new templateChat();
            $template->id_produk=$request->produk;
            $template->template=$request->template;
            $template->save();

            $templates=templateChat::indexTemplate();
            return response()->json([
                'templates'=>$templates,
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
            templateChat::where('id',$request->id)->update([
                'id_produk'=>$request->produk,
                'template'=>$request->template
            ]);

            $templates=templateChat::indexTemplate();
            return response()->json([
                'templates'=>$templates,
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
            templateChat::find($request->id)->delete();

            $templates=templateChat::indexTemplate();
            return response()->json([
                'templates'=>$templates,
                'message'=>"Data Berhasil Dihapus"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }
}
