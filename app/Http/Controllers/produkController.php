<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\product_type;
use App\Models\variance;
use Illuminate\Http\Request;

class produkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $produk = product::indexProduk();
            $variances = variance::where('deleted', false)->get();
            $types = product_type::where('deleted', false)->get();

            return view('Menu.Produk.produk', compact('produk', 'variances', 'types'));
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $variances = variance::where('deleted', false)->get();
            $types = product_type::where('deleted', false)->get();
            $products = product::where('deleted', false)->get();

            return view('Menu.Produk.create', compact('variances', 'types', 'products'));
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }

    public function getFilter()
    {
        try {
            $data['variances'] = variance::where('deleted', false)->get();
            $data['types'] = product_type::where('deleted', false)->get();
            return response()->json([
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }

    public function FetchFilter(Request $request)
    {
        try {
            $products = product::indexProduk(idVarian: $request->varian, idJenis: $request->jenis);
            return response()->json([
                'products' => $products
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
        try {

            $varian = variance::find($request->nama_produk);
            $jenis = product_type::find($request->jenis_produk);
            $kode = "#" . substr($varian->variance_name, 0, 2) . substr($varian->variance_name, -1, 1) . $request->durasi . substr($jenis->type_name, 0, 2) . $jenis->id;
            $produk = new product();
            $produk->id_varian = $request->nama_produk;
            $produk->id_jenis = $request->jenis_produk;
            $produk->kode_produk = $kode;
            $produk->durasi = $request->durasi;
            $produk->ket_durasi = $request->keterangan;
            $produk->biaya = $request->biaya;
            $produk->batas_pengguna = $request->batas;
            $produk->description = $request->description;
            $produk->save();

            return redirect()->route('produk.index')->with(['success', 'Produk Berhasil dibuat']);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
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
        $product = Product::findOrFail($id);
        $variances = variance::where('deleted', false)->get();
        $types = product_type::where('deleted', false)->get();

        return view('Menu.Produk.edit', compact('product', 'variances', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $varian = variance::find($request->nama_produk);
        $jenis = product_type::find($request->jenis_produk);
        $kode = "#" . substr($varian->variance_name, 0, 2) . substr($varian->variance_name, -1, 1) . $request->durasi . substr($jenis->type_name, 0, 2) . $jenis->id;

        try {
            product::where('id', $id)->update([
                'id_varian' => $request->nama_produk,
                'id_jenis' => $request->jenis_produk,
                'kode_produk' => $kode,
                'durasi' => $request->durasi,
                'ket_durasi' => $request->keterangan,
                'biaya' => $request->biaya,
                'batas_pengguna' => $request->batas,
                'description' => $request->description
            ]);

            return redirect()->route('produk.index')->with(['success', 'Produk Berhasil diubah']);
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
            product::where('id', $request->id)->update([
                'deleted' => true
            ]);

            return redirect()->route('produk.index')->with(['success', 'Produk Berhasil dihapus']);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }
}
