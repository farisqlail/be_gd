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
        $request->validate([
            'varian' => 'required|string|max:255',
            'images' => 'required|array|min:3|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        try {
            $variance = new variance();
            $variance->variance_name = $request->varian;
            $variance->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('variance_images', 'public'); 
                    $variance->images()->create(['image_path' => $path]);
                }
            }

            $variances = variance::where('deleted', false)->with('images')->get();
            return response()->json([
                'variances' => $variances,
                'message' => "Data Berhasil Ditambahkan"
            ]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'varian' => 'required|string|max:255',
            'images' => 'array|min:3|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try { 
            $variance = variance::findOrFail($request->id);
            $variance->variance_name = $request->varian;
            $variance->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('variance_images', 'public');
                    $variance->images()->create([
                        'image_path' => $imagePath,
                    ]);
                }
            }

            $variances = variance::where('deleted', false)->get();
            return response()->json([
                'variances' => $variances,
                'message' => "Data Berhasil Diupdate"
            ]);
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
            variance::where('id', $request->id)->update([
                'deleted' => true
            ]);

            $variances = variance::where('deleted', false)->get();
            return response()->json([
                'variances' => $variances,
                'message' => "Data Berhasil Dihapus"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ]);
        }
    }
}
