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

    public function varianceDetail(String $variance)
    {
        try {
            $products = price::get_products($variance, "website");

            $result = [];

            foreach ($products as $item) {
                $variance = $item->variance_name;
                if (!isset($result[$variance])) {
                    $result[$variance] = [];
                }
                $result[$variance][] = $item;
            }
            return response()->json([
                'products' => $result
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
    public function show(String $id_variance)  
    {  
        // Fetch prices associated with the given id_variance and id_toko = 11  
        $prices = Price::with(['product.variance', 'product.productType']) // Eager load variance and product type  
            ->whereHas('product.variance', function ($query) use ($id_variance) {  
                $query->where('id', $id_variance);  
            })  
            ->where('id_toko', 11) // Filter by id_toko  
            ->get();  
      
        if ($prices->isEmpty()) {  
            return response()->json([  
                'message' => 'No prices found for the given variance and store.',  
            ], 404);  
        }  
      
        return response()->json([  
            'prices' => $prices,  
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
