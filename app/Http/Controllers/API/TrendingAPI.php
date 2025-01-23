<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Trending;
use Illuminate\Http\Request;

class TrendingAPI extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $trending = Trending::all();

            $baseUrl = url('/');
            $trending = $trending->map(function ($item) use ($baseUrl) {
                if ($item->image) {
                    $item->image = $baseUrl . '/storage/trendings/' . $item->image;
                }
                return $item;
            });

            return response()->json([
                'trending' => $trending
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
