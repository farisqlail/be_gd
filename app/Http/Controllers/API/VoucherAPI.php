<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherAPI extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Retrieve query parameters  
            $id_variance = $request->query('id_variance');
            $id_product_type = $request->query('id_product_type'); // Get id_product_type from the request  

            // Initialize the query  
            $query = Voucher::query();

            // Apply filters if they are provided  
            if ($id_variance) {
                $query->where('id_variance', $id_variance);
            }

            if ($id_product_type) {
                $query->where('id_product_type', $id_product_type); // Filter by id_product_type  
            }

            // Execute the query and get the results  
            $vouchers = $query->get();

            return response()->json([
                'success' => true,
                'vouchers' => $vouchers
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
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
    public function show(string $id) {}

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
