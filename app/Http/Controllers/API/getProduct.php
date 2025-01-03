<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\price;
use App\Models\product;
use App\Models\variance;
use Illuminate\Http\Request;

class getProduct extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = price::get_products();

            return response()->json([
                'products' => $products
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getVariances()
    {
        try {
            $variance = variance::all();
            return response()->json([
                'variance' => $variance
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {

        $price = Price::with(['product.variance'])
            ->where('id', $id)
            ->first();

        if (!$price) {
            return response()->json([
                'message' => 'Price not found',
            ], 404);
        }

        return response()->json([
            'price' => $price,
        ], 200);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
