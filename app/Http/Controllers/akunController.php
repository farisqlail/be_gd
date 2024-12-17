<?php

namespace App\Http\Controllers;

use App\Models\akun;
use App\Models\detailAkun;
use App\Models\metode_produksi;
use App\Models\product;
use Illuminate\Http\Request;

class akunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $varian=$request->query('varian');
        if ($varian=="Netflix") {
            $akuns=akun::indexAkun($varian);
            $metode=metode_produksi::where('deleted',false)->get();
            return view('Menu.Akun.netflix',compact('akuns','metode'));
        } else {
            return view('Menu.Akun.vision');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $varian=$request->query('varian');
        try {
            if ($varian=="Netflix") {
                $produk=product::fetchProdukAkun($varian);
                $metode=metode_produksi::where('deleted',false)->get();
               return view('Menu.Akun.Form.createAkun',compact('produk','metode'));
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }

    }

    public function fetchFormUpdate(Request $request){
        $varian=$request->query('varian');
        $idAkun=$request->query('idAkun');
        try {
            $akuns=akun::where('id',$idAkun)->get();
            $details=detailAkun::where('id_akun',$idAkun)->get();
            $products=akun::fetchProduk($varian);
            $metode=metode_produksi::where('deleted',false)->get();

            return response()->json([
                'akuns'=>$akuns,
                'details'=>$details,
                'products'=>$products,
                'metode'=>$metode
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
        $varianPost=$request->varian;
        $data=$request->all();
        if ($varianPost=="Netflix") {
            try {
                foreach ($data['produk'] as $key => $value) {
                    $akun = new akun();
                    $akun->id_produk=$data['produk'][$key];
                    $akun->email=$data['email'][$key];
                    $akun->id_metode=$data['metode'][$key];
                    $akun->password=$data['password'][$key];
                    $akun->tanggal_pembuatan=$data['tanggal'][$key];
                    if (substr($data['nomor'][$key], 0, 1) == '0') {
                        $trim_nomor = substr($data['nomor'][$key], 1, 15);
                        $nomorFormat = 62 . $trim_nomor;
                    } elseif (substr($data['nomor'][$key], 0, 1) == '8') {
                        $nomorFormat = 62 . $data['nomor'][$key];
                    } else {
                        $nomorFormat = $data['nomor'][$key];
                    }
                    // Nomor Akun
                    $akun->nomor_akun=$nomorFormat;
                    $akun->save();

                    $akuns=akun::all()->last();
                    for ($i=1; $i <6 ; $i++) {
                        $detail=new detailAkun();
                        $detail->id_akun=$akuns->id;
                        $detail->profile=$i;
                        $detail->pin="";
                        $detail->save();
                    }
                }

                return redirect('/Akun/Index?varian=Netflix')->with(['success'=>"Data Berhasil Ditambahkan"]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message'=>$th->getMessage()
                ]);
            }
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
        $varian=$request->varian;
        $data=$request->all();
        if (substr($request->nomor, 0, 1) == '0') {
            $trim_nomor = substr($request->nomor, 1, 15);
            $nomorFormat = 62 . $trim_nomor;
        } elseif (substr($request->nomor, 0, 1) == '8') {
            $nomorFormat = 62 . $request->nomor;
        } else {
            $nomorFormat = $request->nomor;
        }
        try {
            if ($varian=="Netflix") {
                akun::where('id',$request->id)->update([
                    'id_produk'=>$request->produk,
                    'email'=>$request->email,
                    'id_metode'=>$request->metode,
                    'nomor_akun'=>$nomorFormat,
                    'password'=>$request->password,
                    'tanggal_pembuatan'=>$request->tanggal
                ]);

                foreach ($data['profile'] as $key => $value) {
                    detailAkun::where('id',$data['id_detail'][$key])->update([
                        'id_akun'=>$request->id,
                        'profile'=>$data['profile'][$key],
                        'pin'=>$data['pin'][$key]
                    ]);
                }
                $akuns=akun::indexAkun($varian);
                return response()->json([
                    'akuns'=>$akuns,
                    'message'=>"Data Berhasil Diupdate"
                ]);
            }

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
        $varian=$request->varian;
        try {
            detailAkun::where('id_akun',$request->id)->delete();
            akun::where('id',$request->id)->delete();

            $akuns=akun::indexAkun($varian);
            return response()->json([
                'akuns'=>$akuns,
                'message'=>"Data Berhasil Dihapus"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>$th->getMessage()
            ]);
        }
    }
}
